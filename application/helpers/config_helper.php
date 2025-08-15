<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuration Helper
|--------------------------------------------------------------------------
| Helper functions for managing configuration and environment variables
|
*/

if (!function_exists('env')) {
    /**
     * Get environment variable with fallback
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = NULL) {
        $value = getenv($key);
        
        if ($value === FALSE) {
            return $default;
        }
        
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return TRUE;
            case 'false':
            case '(false)':
                return FALSE;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return NULL;
        }
        
        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Get configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = NULL) {
        $CI =& get_instance();
        
        if ($CI->config->item($key) !== FALSE) {
            return $CI->config->item($key);
        }
        
        return $default;
    }
}

if (!function_exists('is_environment')) {
    /**
     * Check if current environment matches
     *
     * @param string $environment
     * @return bool
     */
    function is_environment($environment) {
        return ENVIRONMENT === $environment;
    }
}

if (!function_exists('is_development')) {
    /**
     * Check if in development environment
     *
     * @return bool
     */
    function is_development() {
        return is_environment('development');
    }
}

if (!function_exists('is_production')) {
    /**
     * Check if in production environment
     *
     * @return bool
     */
    function is_production() {
        return is_environment('production');
    }
}

if (!function_exists('is_testing')) {
    /**
     * Check if in testing environment
     *
     * @return bool
     */
    function is_testing() {
        return is_environment('testing');
    }
}

if (!function_exists('asset_url')) {
    /**
     * Get asset URL with versioning for cache busting
     *
     * @param string $path
     * @return string
     */
    function asset_url($path) {
        $CI =& get_instance();
        $base_url = $CI->config->item('base_url');
        
        // Add version parameter for cache busting in production
        if (is_production()) {
            $version = config('asset_version', '1.0.0');
            $separator = (strpos($path, '?') !== FALSE) ? '&' : '?';
            $path .= $separator . 'v=' . $version;
        }
        
        return $base_url . 'assets/' . ltrim($path, '/');
    }
}

if (!function_exists('upload_url')) {
    /**
     * Get upload URL
     *
     * @param string $path
     * @return string
     */
    function upload_url($path) {
        $CI =& get_instance();
        $base_url = $CI->config->item('base_url');
        
        return $base_url . 'uploads/' . ltrim($path, '/');
    }
}
