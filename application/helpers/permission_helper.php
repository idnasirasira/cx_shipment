<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permission Helper
 * 
 * Provides helper functions for permission checking in views and controllers
 * 
 * @author CX Shipment System
 * @version 1.0
 */

/**
 * Check if current user has a specific permission
 * 
 * @param string $permissionName Permission name to check
 * @return bool True if user has permission, false otherwise
 */
function has_permission($permissionName)
{
    $CI = &get_instance();

    // Check if user is logged in
    if (!$CI->session->userdata('logged_in')) {
        return false;
    }

    $userId = $CI->session->userdata('user_id');

    // Load permission model if not already loaded
    if (!isset($CI->Permission_model)) {
        $CI->load->model('Permission_model');
    }

    return $CI->Permission_model->userHasPermission($userId, $permissionName);
}

/**
 * Check if current user has any of the specified permissions
 * 
 * @param array $permissions Array of permission names to check
 * @return bool True if user has any of the permissions, false otherwise
 */
function has_any_permission($permissions)
{
    foreach ($permissions as $permission) {
        if (has_permission($permission)) {
            return true;
        }
    }
    return false;
}

/**
 * Check if current user has all of the specified permissions
 * 
 * @param array $permissions Array of permission names to check
 * @return bool True if user has all permissions, false otherwise
 */
function has_all_permissions($permissions)
{
    foreach ($permissions as $permission) {
        if (!has_permission($permission)) {
            return false;
        }
    }
    return true;
}

/**
 * Get current user's permissions
 * 
 * @return array Array of permission names
 */
function get_user_permissions()
{
    $CI = &get_instance();

    // Check if user is logged in
    if (!$CI->session->userdata('logged_in')) {
        return [];
    }

    $userId = $CI->session->userdata('user_id');

    // Load permission model if not already loaded
    if (!isset($CI->Permission_model)) {
        $CI->load->model('Permission_model');
    }

    return $CI->Permission_model->getUserPermissionNames($userId);
}

/**
 * Get current user's role name
 * 
 * @return string|null Role name or null if not found
 */
function get_user_role()
{
    $CI = &get_instance();

    // Check if user is logged in
    if (!$CI->session->userdata('logged_in')) {
        return null;
    }

    $userId = $CI->session->userdata('user_id');

    // Load user model if not already loaded
    if (!isset($CI->User_model)) {
        $CI->load->model('User_model');
    }

    $user = $CI->User_model->getUserById($userId);
    return $user ? $user->role_name : null;
}

/**
 * Check if current user is admin
 * 
 * @return bool True if user is admin, false otherwise
 */
function is_admin()
{
    return has_permission('manage_roles') || get_user_role() === 'admin';
}

/**
 * Display content only if user has permission
 * 
 * @param string $permission Permission name to check
 * @param string $content Content to display if user has permission
 * @return string Content or empty string
 */
function permission_content($permission, $content)
{
    return has_permission($permission) ? $content : '';
}

/**
 * Display content only if user has any of the permissions
 * 
 * @param array $permissions Array of permission names to check
 * @param string $content Content to display if user has any permission
 * @return string Content or empty string
 */
function permission_content_any($permissions, $content)
{
    return has_any_permission($permissions) ? $content : '';
}

/**
 * Display content only if user has all permissions
 * 
 * @param array $permissions Array of permission names to check
 * @param string $content Content to display if user has all permissions
 * @return string Content or empty string
 */
function permission_content_all($permissions, $content)
{
    return has_all_permissions($permissions) ? $content : '';
}

/**
 * Generate permission-based CSS class
 * 
 * @param string $permission Permission name to check
 * @param string $class CSS class to apply if user has permission
 * @return string CSS class or empty string
 */
function permission_class($permission, $class)
{
    return has_permission($permission) ? $class : '';
}

/**
 * Generate permission-based HTML attributes
 * 
 * @param string $permission Permission name to check
 * @param array $attributes HTML attributes to apply if user has permission
 * @return string HTML attributes or empty string
 */
function permission_attributes($permission, $attributes)
{
    if (!has_permission($permission)) {
        return '';
    }

    $attr_string = '';
    foreach ($attributes as $key => $value) {
        $attr_string .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
    }

    return $attr_string;
}

/**
 * Check if user can access a specific route/action
 * 
 * @param string $action Action name (e.g., 'admin/users/create')
 * @return bool True if user can access, false otherwise
 */
function can_access($action)
{
    // Define permission mappings for actions
    $action_permissions = [
        'admin/users' => 'manage_users',
        'admin/users/create' => 'manage_users',
        'admin/users/edit' => 'manage_users',
        'admin/users/delete' => 'manage_users',
        'admin/roles' => 'manage_roles',
        'admin/roles/create' => 'manage_roles',
        'admin/roles/edit' => 'manage_roles',
        'admin/roles/delete' => 'manage_roles',
        'admin/permissions' => 'manage_roles',
        'admin/permissions/create' => 'manage_roles',
        'admin/permissions/edit' => 'manage_roles',
        'admin/permissions/delete' => 'manage_roles',
        'admin/settings' => 'manage_settings',
        'admin/reports' => 'view_reports',
        'admin/orders' => 'manage_orders',
        'admin/customers' => 'manage_customers',
        'admin/drivers' => 'manage_drivers'
    ];

    // Check if action has a specific permission requirement
    if (isset($action_permissions[$action])) {
        return has_permission($action_permissions[$action]);
    }

    // For admin actions without specific mapping, require admin role
    if (strpos($action, 'admin/') === 0) {
        return is_admin();
    }

    // Default to allowing access for non-admin actions
    return true;
}

/**
 * Generate navigation menu items based on permissions
 * 
 * @return array Array of menu items user can access
 */
function get_navigation_menu()
{
    $menu = [];

    // Dashboard - always accessible
    $menu[] = [
        'url' => 'admin/dashboard',
        'title' => 'Dashboard',
        'icon' => 'bi bi-speedometer2',
        'active' => false
    ];

    // Users management
    if (has_permission('manage_users')) {
        $menu[] = [
            'url' => 'admin/users',
            'title' => 'Users',
            'icon' => 'bi bi-people',
            'active' => false
        ];
    }

    // Roles and permissions
    if (has_permission('manage_roles')) {
        $menu[] = [
            'url' => 'admin/roles',
            'title' => 'Roles',
            'icon' => 'bi bi-shield',
            'active' => false
        ];

        $menu[] = [
            'url' => 'admin/permissions',
            'title' => 'Permissions',
            'icon' => 'bi bi-key',
            'active' => false
        ];
    }

    // Orders management
    if (has_permission('manage_orders')) {
        $menu[] = [
            'url' => 'admin/orders',
            'title' => 'Orders',
            'icon' => 'bi bi-box',
            'active' => false
        ];
    }

    // Customers management
    if (has_permission('manage_customers')) {
        $menu[] = [
            'url' => 'admin/customers',
            'title' => 'Customers',
            'icon' => 'bi bi-person-badge',
            'active' => false
        ];
    }

    // Drivers management
    if (has_permission('manage_drivers')) {
        $menu[] = [
            'url' => 'admin/drivers',
            'title' => 'Drivers',
            'icon' => 'bi bi-truck',
            'active' => false
        ];
    }

    // Reports
    if (has_permission('view_reports')) {
        $menu[] = [
            'url' => 'admin/reports',
            'title' => 'Reports',
            'icon' => 'bi bi-graph-up',
            'active' => false
        ];
    }

    // Settings
    if (has_permission('manage_settings')) {
        $menu[] = [
            'url' => 'admin/settings',
            'title' => 'Settings',
            'icon' => 'bi bi-gear',
            'active' => false
        ];
    }

    return $menu;
}
