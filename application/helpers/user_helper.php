<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Helper Functions
 * 
 * Provides utility functions for user management
 * 
 * @author CX Shipment System
 * @version 1.0
 */

/**
 * Get user's full name
 * 
 * @param object $user User object
 * @return string Full name
 */
function get_user_full_name($user)
{
    if (!$user) {
        return 'Unknown User';
    }

    $firstName = isset($user->first_name) ? trim($user->first_name) : '';
    $lastName = isset($user->last_name) ? trim($user->last_name) : '';

    if (empty($firstName) && empty($lastName)) {
        return isset($user->username) ? $user->username : 'Unknown User';
    }

    return trim($firstName . ' ' . $lastName);
}

/**
 * Get user's display name (first name + last initial)
 * 
 * @param object $user User object
 * @return string Display name
 */
function get_user_display_name($user)
{
    if (!$user) {
        return 'Unknown User';
    }

    $firstName = isset($user->first_name) ? trim($user->first_name) : '';
    $lastName = isset($user->last_name) ? trim($user->last_name) : '';

    if (empty($firstName) && empty($lastName)) {
        return isset($user->username) ? $user->username : 'Unknown User';
    }

    if (empty($lastName)) {
        return $firstName;
    }

    return $firstName . ' ' . substr($lastName, 0, 1) . '.';
}

/**
 * Get user's initials for avatar
 * 
 * @param object $user User object
 * @return string User initials
 */
function get_user_initials($user)
{
    if (!$user) {
        return 'U';
    }

    $firstName = isset($user->first_name) ? trim($user->first_name) : '';
    $lastName = isset($user->last_name) ? trim($user->last_name) : '';

    if (empty($firstName) && empty($lastName)) {
        return isset($user->username) ? strtoupper(substr($user->username, 0, 2)) : 'U';
    }

    $initials = '';
    if (!empty($firstName)) {
        $initials .= strtoupper(substr($firstName, 0, 1));
    }
    if (!empty($lastName)) {
        $initials .= strtoupper(substr($lastName, 0, 1));
    }

    return $initials;
}

/**
 * Get user status badge HTML
 * 
 * @param bool $isActive User active status
 * @return string HTML badge
 */
function get_user_status_badge($isActive)
{
    if ($isActive) {
        return '<span class="badge bg-success">Active</span>';
    } else {
        return '<span class="badge bg-danger">Inactive</span>';
    }
}

/**
 * Get user role badge HTML
 * 
 * @param string $roleName Role name
 * @return string HTML badge
 */
function get_user_role_badge($roleName)
{
    $roleName = ucfirst(strtolower($roleName));

    $badgeClasses = [
        'admin' => 'bg-danger',
        'staff' => 'bg-warning',
        'driver' => 'bg-info',
        'customer' => 'bg-primary'
    ];

    $badgeClass = isset($badgeClasses[strtolower($roleName)]) ? $badgeClasses[strtolower($roleName)] : 'bg-secondary';

    return '<span class="badge ' . $badgeClass . '">' . $roleName . '</span>';
}

/**
 * Format user's last login time
 * 
 * @param string $lastLogin Last login timestamp
 * @return string Formatted time
 */
function format_last_login($lastLogin)
{
    if (!$lastLogin) {
        return 'Never';
    }

    $lastLoginTime = strtotime($lastLogin);
    $now = time();
    $diff = $now - $lastLoginTime;

    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 2592000) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M d, Y H:i', $lastLoginTime);
    }
}

/**
 * Check if user has specific role
 * 
 * @param object $user User object
 * @param string $roleName Role name to check
 * @return bool True if user has role
 */
function user_has_role($user, $roleName)
{
    if (!$user || !isset($user->role_name)) {
        return false;
    }

    return strtolower($user->role_name) === strtolower($roleName);
}

/**
 * Check if user is admin
 * 
 * @param object $user User object
 * @return bool True if user is admin
 */
function user_is_admin($user)
{
    return user_has_role($user, 'admin');
}

/**
 * Check if user is staff
 * 
 * @param object $user User object
 * @return bool True if user is staff
 */
function user_is_staff($user)
{
    return user_has_role($user, 'staff');
}

/**
 * Check if user is driver
 * 
 * @param object $user User object
 * @return bool True if user is driver
 */
function user_is_driver($user)
{
    return user_has_role($user, 'driver');
}

/**
 * Check if user is customer
 * 
 * @param object $user User object
 * @return bool True if user is customer
 */
function user_is_customer($user)
{
    return user_has_role($user, 'customer');
}

/**
 * Get user profile picture URL
 * 
 * @param object $user User object
 * @param string $defaultImage Default image path
 * @return string Profile picture URL
 */
function get_user_profile_picture($user, $defaultImage = 'assets/compiled/images/default-avatar.png')
{
    if (!$user || !isset($user->profile_picture) || empty($user->profile_picture)) {
        return base_url($defaultImage);
    }

    $profilePath = 'uploads/profiles/' . $user->profile_picture;

    if (file_exists(FCPATH . $profilePath)) {
        return base_url($profilePath);
    }

    return base_url($defaultImage);
}

/**
 * Validate username format
 * 
 * @param string $username Username to validate
 * @return bool True if valid
 */
function is_valid_username($username)
{
    return preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username);
}

/**
 * Validate email format
 * 
 * @param string $email Email to validate
 * @return bool True if valid
 */
function is_valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number format
 * 
 * @param string $phone Phone number to validate
 * @return bool True if valid
 */
function is_valid_phone($phone)
{
    // Remove all non-digit characters
    $phone = preg_replace('/\D/', '', $phone);

    // Check if it's a valid phone number (7-15 digits)
    return preg_match('/^[1-9]\d{6,14}$/', $phone);
}

/**
 * Format phone number for display
 * 
 * @param string $phone Phone number to format
 * @return string Formatted phone number
 */
function format_phone_number($phone)
{
    // Remove all non-digit characters
    $phone = preg_replace('/\D/', '', $phone);

    if (strlen($phone) === 10) {
        return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
    } elseif (strlen($phone) === 11 && substr($phone, 0, 1) === '1') {
        return '+1 (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7);
    }

    return $phone;
}

/**
 * Get user creation date formatted
 * 
 * @param string $createdAt Creation timestamp
 * @return string Formatted date
 */
function get_user_created_date($createdAt)
{
    if (!$createdAt) {
        return 'Unknown';
    }

    return date('F d, Y \a\t g:i A', strtotime($createdAt));
}

/**
 * Get user update date formatted
 * 
 * @param string $updatedAt Update timestamp
 * @return string Formatted date
 */
function get_user_updated_date($updatedAt)
{
    if (!$updatedAt) {
        return 'Never';
    }

    return date('F d, Y \a\t g:i A', strtotime($updatedAt));
}

/**
 * Check if user account is active
 * 
 * @param object $user User object
 * @return bool True if active
 */
function is_user_active($user)
{
    return isset($user->is_active) && $user->is_active == 1;
}

/**
 * Get user account age in days
 * 
 * @param string $createdAt Creation timestamp
 * @return int Age in days
 */
function get_user_account_age($createdAt)
{
    if (!$createdAt) {
        return 0;
    }

    $created = new DateTime($createdAt);
    $now = new DateTime();
    $diff = $now->diff($created);

    return $diff->days;
}
