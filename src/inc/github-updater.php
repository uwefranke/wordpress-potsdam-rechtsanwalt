<?php
/**
 * GitHub Theme Updater
 * 
 * Prüft automatisch auf Updates von GitHub Releases
 */

if (!defined('ABSPATH')) {
    exit;
}

class Potsdam_Rechtsanwalt_GitHub_Updater {
    private $github_user = 'uwefranke';
    private $github_repo = 'wordpress-potsdam-rechtsanwalt';
    private $theme_slug = 'potsdam-rechtsanwalt';
    private $theme_data;
    
    public function __construct() {
        add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));
        add_filter('upgrader_source_selection', array($this, 'fix_source_folder'), 10, 3);
    }
    
    /**
     * Prüft auf Updates via GitHub API
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        // Theme-Daten abrufen
        $theme = wp_get_theme($this->theme_slug);
        $current_version = $theme->get('Version');
        
        // GitHub API abfragen
        $release_info = $this->get_latest_release();
        
        if (!$release_info || !isset($release_info->tag_name)) {
            return $transient;
        }
        
        // Versionsnummer aus Git-Tag extrahieren (v1.0.0 -> 1.0.0)
        $latest_version = ltrim($release_info->tag_name, 'v');
        
        // Versionsvergleich
        if (version_compare($current_version, $latest_version, '<')) {
            $download_url = $this->get_download_url($release_info);
            
            if ($download_url) {
                $transient->response[$this->theme_slug] = array(
                    'theme'       => $this->theme_slug,
                    'new_version' => $latest_version,
                    'url'         => sprintf('https://github.com/%s/%s/releases/latest', $this->github_user, $this->github_repo),
                    'package'     => $download_url,
                );
            }
        }
        
        return $transient;
    }
    
    /**
     * Holt die neueste Release-Info von GitHub
     */
    private function get_latest_release() {
        $api_url = sprintf('https://api.github.com/repos/%s/%s/releases/latest', 
            $this->github_user, 
            $this->github_repo
        );
        
        $response = wp_remote_get($api_url, array(
            'timeout' => 10,
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
            ),
        ));
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body);
    }
    
    /**
     * Findet die Download-URL für das Theme-ZIP
     */
    private function get_download_url($release_info) {
        if (!isset($release_info->assets) || empty($release_info->assets)) {
            return false;
        }
        
        // Suche nach potsdam-rechtsanwalt.zip oder potsdam-rechtsanwalt-theme-*.zip
        foreach ($release_info->assets as $asset) {
            if (preg_match('/potsdam-rechtsanwalt.*\.zip$/i', $asset->name)) {
                return $asset->browser_download_url;
            }
        }
        
        return false;
    }
    
    /**
     * Korrigiert den Ordnernamen nach dem Download
     * (GitHub erstellt manchmal Ordner wie "wordpress-potsdam-rechtsanwalt-main")
     */
    public function fix_source_folder($source, $remote_source, $upgrader) {
        global $wp_filesystem;
        
        // Nur für dieses Theme
        if (!isset($upgrader->skin->theme) || $upgrader->skin->theme !== $this->theme_slug) {
            return $source;
        }
        
        // Zielordner
        $corrected_source = trailingslashit($remote_source) . $this->theme_slug . '/';
        
        // Ordner umbenennen
        if ($source !== $corrected_source) {
            if ($wp_filesystem->move($source, $corrected_source, true)) {
                return $corrected_source;
            }
        }
        
        return $source;
    }
}

// Updater initialisieren
new Potsdam_Rechtsanwalt_GitHub_Updater();
