# Sidebar Permissions Guide

This document explains the updated sidebar structure with permission-based visibility for the CX Shipment Management System.

## Overview

The sidebar now supports permission-based menu visibility, ensuring that users only see menu items they have permission to access. This enhances security and provides a better user experience by hiding irrelevant options.

## Permission Structure

### Menu Item Permissions

Each menu item can have a `permission` attribute that specifies the required permission to view that item:

```php
array(
    'name' => 'Role Management',
    'icon' => 'bi bi-shield-check',
    'url' => 'admin/roles',
    'permission' => 'manage_roles',  // Required permission
    'submenu' => array(
        array('name' => 'All Roles', 'url' => 'admin/roles', 'permission' => 'view_roles'),
        array('name' => 'Create Role', 'url' => 'admin/roles/create', 'permission' => 'create_roles'),
        // ...
    )
)
```

### Permission Hierarchy

The system uses a hierarchical permission structure:

#### **Dashboard**

- `view_dashboard` - Access to main dashboard

#### **Shipments**

- `manage_shipments` - Main shipment management permission
  - `view_shipments` - View all shipment lists
  - `create_shipments` - Create new shipments

#### **Tracking**

- `manage_tracking` - Main tracking management permission
  - `view_tracking` - View tracking information
  - `update_tracking` - Update shipment locations

#### **Reports**

- `view_reports` - Access to all reports

#### **User Management**

- `manage_users` - Main user management permission
  - `view_users` - View user lists
  - `create_users` - Create new users

#### **Role Management** ⭐ **NEW**

- `manage_roles` - Main role management permission
  - `view_roles` - View role lists
  - `create_roles` - Create new roles
  - `manage_permissions` - Manage permissions and bulk assignments

#### **Settings**

- `manage_settings` - Access to shipping rates and service areas
- `manage_developer_settings` - Access to developer settings

## Implementation Details

### Sidebar Configuration

The sidebar configuration is located in `application/config/sidebar.php`:

```php
$config['menu'] = array(
    array(
        'title' => 'Menu',
        'items' => array(
            array(
                'name' => 'Dashboard',
                'url' => 'admin/dashboard',
                'icon' => 'bi bi-grid-fill',
                'permission' => 'view_dashboard',
            ),
            // ... more menu items
        )
    )
);
```

### Permission Checking

The sidebar automatically checks permissions using the `has_permission()` helper function:

```php
// Check if user has permission to view this menu item
$requiredPermission = isset($item['permission']) ? $item['permission'] : null;
if ($requiredPermission && !has_permission($requiredPermission)) {
    continue; // Skip this menu item if user doesn't have permission
}
```

### Active State Detection

The sidebar also includes improved active state detection:

```php
// Check if any submenu item is active
if ($hasSubmenu) {
    foreach ($item['submenu'] as $submenu) {
        $submenuUrl = isset($submenu['url']) ? base_url($submenu['url']) : '#';
        if (is_menu_active($submenuUrl)) {
            $submenu_active = true;
            break;
        }
    }
}
```

## Role Management Menu Structure

### Main Menu Item

- **Name**: Role Management
- **Icon**: `bi bi-shield-check`
- **URL**: `admin/roles`
- **Permission**: `manage_roles`

### Submenu Items

#### 1. All Roles

- **URL**: `admin/roles`
- **Permission**: `view_roles`
- **Description**: View and manage all roles

#### 2. Create Role

- **URL**: `admin/roles/create`
- **Permission**: `create_roles`
- **Description**: Create new roles

#### 3. Permissions

- **URL**: `admin/permissions`
- **Permission**: `manage_permissions`
- **Description**: Manage individual permissions

#### 4. Bulk Assign

- **URL**: `admin/permissions/bulk_assign`
- **Permission**: `manage_permissions`
- **Description**: Bulk assign permissions to roles

## Usage Examples

### Adding a New Menu Item with Permissions

```php
array(
    'name' => 'New Feature',
    'icon' => 'bi bi-star',
    'url' => 'admin/new-feature',
    'permission' => 'manage_new_feature',
    'submenu' => array(
        array('name' => 'View', 'url' => 'admin/new-feature', 'permission' => 'view_new_feature'),
        array('name' => 'Create', 'url' => 'admin/new-feature/create', 'permission' => 'create_new_feature'),
        array('name' => 'Settings', 'url' => 'admin/new-feature/settings', 'permission' => 'manage_new_feature_settings'),
    )
)
```

### Menu Item Without Permissions

```php
array(
    'name' => 'Public Page',
    'url' => 'admin/public',
    'icon' => 'bi bi-globe'
    // No permission required - visible to all users
)
```

### Submenu Only with Permissions

```php
array(
    'name' => 'Management',
    'icon' => 'bi bi-gear',
    'url' => 'admin/management',
    'submenu' => array(
        array('name' => 'Admin Only', 'url' => 'admin/management/admin', 'permission' => 'admin_access'),
        array('name' => 'Public', 'url' => 'admin/management/public'), // No permission required
    )
)
```

## Security Benefits

### 1. **Access Control**

- Users only see menu items they can actually access
- Prevents confusion and reduces support requests
- Improves user experience

### 2. **Security by Obscurity**

- Hidden menu items reduce attack surface
- Users can't attempt to access unauthorized features
- Cleaner interface for different user roles

### 3. **Role-Based UI**

- Different user roles see different interfaces
- Admins see full functionality
- Regular users see limited options

## Best Practices

### 1. **Permission Naming**

- Use descriptive permission names
- Follow consistent naming conventions
- Group related permissions logically

### 2. **Menu Structure**

- Organize menu items logically
- Use appropriate icons
- Keep submenu items relevant

### 3. **Permission Hierarchy**

- Use parent permissions for main menu items
- Use specific permissions for submenu items
- Avoid overly granular permissions

### 4. **Testing**

- Test with different user roles
- Verify permission checks work correctly
- Ensure menu items appear/disappear as expected

## Troubleshooting

### Menu Item Not Visible

1. Check if the user has the required permission
2. Verify the permission name is correct
3. Ensure the permission helper is loaded
4. Check for typos in the permission name

### Active State Not Working

1. Verify the URL structure matches
2. Check the `is_menu_active()` function
3. Ensure proper base URL configuration

### Permission Check Failing

1. Verify the user is logged in
2. Check if the user has the assigned role
3. Ensure the role has the required permission
4. Verify the permission exists in the database

## Migration from Old Sidebar

### Before (No Permissions)

```php
array(
    'name' => 'Users',
    'url' => 'admin/users',
    'icon' => 'bi bi-people'
)
```

### After (With Permissions)

```php
array(
    'name' => 'User Management',
    'url' => 'admin/users',
    'icon' => 'bi bi-people',
    'permission' => 'manage_users',
    'submenu' => array(
        array('name' => 'All Users', 'url' => 'admin/users', 'permission' => 'view_users'),
        array('name' => 'Create User', 'url' => 'admin/users/create', 'permission' => 'create_users')
    )
)
```

## Future Enhancements

### 1. **Dynamic Menu Loading**

- Load menu items based on user permissions dynamically
- Cache menu structure for performance
- Support for AJAX menu updates

### 2. **Menu Customization**

- Allow users to customize their menu layout
- Drag-and-drop menu reordering
- Personal menu favorites

### 3. **Advanced Permissions**

- Time-based permissions
- Location-based access
- Conditional menu items

### 4. **Menu Analytics**

- Track menu usage
- Identify unused menu items
- Optimize menu structure based on usage

## Support

For issues or questions about the sidebar permissions:

1. Check the permission helper documentation
2. Verify user role assignments
3. Review the menu configuration
4. Test with different user accounts
5. Check browser console for JavaScript errors

---

**Note**: This sidebar implementation works in conjunction with the role and permissions management system. Ensure that users have the appropriate roles and permissions assigned to see the menu items.
