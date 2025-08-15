<?php
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('is_menu_active')) {

    // Check menu by current url
    function is_menu_active($menu_url)
    {
        $current_url = current_url();

        if (strpos($menu_url, 'http') !== 0) {
            $menu_url = base_url($menu_url);
        }

        return strpos($current_url, $menu_url) !== false ? 'active' : '';
    }
}
