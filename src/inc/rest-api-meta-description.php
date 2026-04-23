<?php
/**
 * Custom REST API Endpoint für Rank Math Meta-Description Updates
 * 
 * Dieser Endpoint ermöglicht es, Rank Math Meta-Descriptions über die REST API zu setzen,
 * da die Standard-WordPress REST API keinen direkten Zugriff auf Rank Math Custom Fields bietet.
 * 
 * @package Potsdam_Rechtsanwalt
 */

// Verhindere direkten Zugriff
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registriere Custom REST API Route
 */
add_action('rest_api_init', function () {
    register_rest_route('potsdam/v1', '/meta-description/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'potsdam_update_meta_description',
        'permission_callback' => function ($request) {
            // Nur authentifizierte Benutzer mit edit_posts Berechtigung
            return current_user_can('edit_posts');
        },
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
            'description' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function ($param) {
                    return !empty($param) && strlen($param) <= 300;
                }
            ),
            'focus_keyword' => array(
                'required' => false,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function ($param) {
                    return is_null($param) || strlen($param) <= 120;
                }
            ),
            'post_type' => array(
                'required' => false,
                'default' => 'post',
                'sanitize_callback' => 'sanitize_key',
            )
        ),
    ));
});

/**
 * Callback für Meta-Description Update
 * 
 * @param WP_REST_Request $request REST API Request
 * @return WP_REST_Response|WP_Error
 */
function potsdam_update_meta_description($request) {
    $post_id = $request->get_param('id');
    $description = $request->get_param('description');
    $focus_keyword = $request->get_param('focus_keyword');
    $post_type = $request->get_param('post_type');
    
    // Prüfe ob Post existiert
    $post = get_post($post_id);
    if (!$post) {
        return new WP_Error(
            'post_not_found',
            'Post nicht gefunden',
            array('status' => 404)
        );
    }
    
    // Prüfe Post-Type
    $expected_type = $post_type === 'pages' ? 'page' : 'post';
    if ($post->post_type !== $expected_type) {
        return new WP_Error(
            'invalid_post_type',
            "Post-Type Mismatch: Erwartet $expected_type, gefunden {$post->post_type}",
            array('status' => 400)
        );
    }
    
    // Setze Rank Math Description
    $result = update_post_meta($post_id, 'rank_math_description', $description);
    
    if ($result === false) {
        return new WP_Error(
            'update_failed',
            'Meta-Description konnte nicht gespeichert werden',
            array('status' => 500)
        );
    }

    if (!empty($focus_keyword)) {
        $focus_result = update_post_meta($post_id, 'rank_math_focus_keyword', $focus_keyword);

        if ($focus_result === false) {
            return new WP_Error(
                'focus_keyword_update_failed',
                'Fokus-Schluesselwort konnte nicht gespeichert werden',
                array('status' => 500)
            );
        }
    }

    $saved_description = get_post_meta($post_id, 'rank_math_description', true);
    $saved_focus_keyword = get_post_meta($post_id, 'rank_math_focus_keyword', true);
    
    // Erfolgreiche Antwort
    return new WP_REST_Response(array(
        'success' => true,
        'post_id' => $post_id,
        'post_title' => $post->post_title,
        'description' => $saved_description,
        'description_length' => strlen($saved_description),
        'focus_keyword' => $saved_focus_keyword,
        'message' => 'Meta-Description und Fokus-Schluesselwort erfolgreich gespeichert'
    ), 200);
}

/**
 * Füge Custom REST Route zu WordPress Rewrite Rules hinzu
 */
add_action('init', function() {
    // Flush Rewrite Rules wenn nötig (nur beim Theme-Activation)
    if (get_option('potsdam_rest_api_flush_needed')) {
        flush_rewrite_rules();
        delete_option('potsdam_rest_api_flush_needed');
    }
});

/**
 * Setze Flag für Rewrite Rules Flush bei Theme-Activation
 */
add_action('after_switch_theme', function() {
    add_option('potsdam_rest_api_flush_needed', true);
});
