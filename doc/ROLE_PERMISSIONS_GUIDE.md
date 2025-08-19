# Role and Permissions Management System

## Overview

The CX Shipment Management System includes a comprehensive role-based access control (RBAC) system that allows administrators to manage user roles and permissions effectively. This system provides granular control over what users can access and perform within the application.

## Features

- **Role Management**: Create, edit, and delete user roles
- **Permission Management**: Define granular permissions for different actions
- **Role-Permission Assignment**: Assign multiple permissions to roles
- **User-Role Assignment**: Assign roles to users
- **Permission Checking**: Check user permissions in controllers and views
- **Bulk Operations**: Bulk assign permissions to roles
- **Export Functionality**: Export roles and permissions to CSV
- **Real-time Validation**: AJAX-based name availability checking

## Database Structure

### Tables

1. **roles** - Stores role information

   - `id` (Primary Key)
   - `name` (Unique role name)
   - `description` (Role description)
   - `created_at`, `updated_at`, `deleted_at` (Timestamps)

2. **permissions** - Stores permission information

   - `id` (Primary Key)
   - `name` (Unique permission name)
   - `description` (Permission description)
   - `created_at`, `updated_at`, `deleted_at` (Timestamps)

3. **role_permissions** - Junction table for role-permission relationships

   - `role_id` (Foreign Key to roles.id)
   - `permission_id` (Foreign Key to permissions.id)
   - `created_at` (Timestamp)

4. **users** - User table with role assignment
   - `role_id` (Foreign Key to roles.id)

## Default Roles and Permissions

### Default Roles

- **admin**: Full system access
- **staff**: Limited administrative access
- **driver**: Delivery driver access
- **customer**: Customer/client access

### Default Permissions

- `manage_users`: Create, read, update, delete users
- `manage_roles`: Manage user roles and permissions
- `manage_orders`: Handle delivery orders and tracking
- `view_reports`: Access system reports and analytics
- `manage_customers`: Manage customer information
- `manage_drivers`: Manage driver assignments and schedules
- `manage_settings`: Configure system settings

## Usage Guide

### 1. Checking Permissions in Controllers

```php
// Load the permission helper
$this->load->helper('permission');

// Check if user has a specific permission
if (!has_permission('manage_users')) {
    $this->session->set_flashdata('error', 'Access denied.');
    redirect('admin/dashboard');
}

// Check if user has any of multiple permissions
if (!has_any_permission(['manage_users', 'manage_roles'])) {
    redirect('admin/dashboard');
}

// Check if user has all permissions
if (!has_all_permissions(['manage_users', 'manage_roles'])) {
    redirect('admin/dashboard');
}
```

### 2. Checking Permissions in Views

```php
<?php $this->load->helper('permission'); ?>

<!-- Show content only if user has permission -->
<?php if (has_permission('manage_users')): ?>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">Create User</a>
<?php endif; ?>

<!-- Alternative syntax using helper function -->
<?= permission_content('manage_users', '<a href="' . base_url('admin/users/create') . '" class="btn btn-primary">Create User</a>') ?>

<!-- Show content if user has any of the permissions -->
<?= permission_content_any(['manage_users', 'manage_roles'], '<div class="alert alert-info">You have administrative access</div>') ?>
```

### 3. Using Permission Classes and Attributes

```php
<!-- Apply CSS class based on permission -->
<div class="<?= permission_class('manage_users', 'admin-section') ?>">
    User management content
</div>

<!-- Apply HTML attributes based on permission -->
<button <?= permission_attributes('manage_users', ['href' => base_url('admin/users/create'), 'class' => 'btn btn-primary']) ?>>
    Create User
</button>
```

### 4. Navigation Menu Based on Permissions

```php
<?php $this->load->helper('permission'); ?>
<?php $menu = get_navigation_menu(); ?>

<nav class="sidebar">
    <?php foreach ($menu as $item): ?>
        <a href="<?= base_url($item['url']) ?>" class="nav-link">
            <i class="<?= $item['icon'] ?>"></i>
            <span><?= $item['title'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>
```

### 5. Creating Custom Permissions

```php
// In your controller
$this->load->model('Permission_model');

$permissionData = [
    'name' => 'manage_shipments',
    'description' => 'Create, edit, and delete shipment records'
];

$permissionId = $this->Permission_model->createPermission($permissionData);
```

### 6. Assigning Permissions to Roles

```php
// Assign permissions to a role
$roleId = 1; // Admin role
$permissionIds = [1, 2, 3]; // Permission IDs to assign

$this->Permission_model->assignPermissionsToRole($roleId, $permissionIds);
```

### 7. Checking User Permissions Programmatically

```php
$this->load->model('Permission_model');

$userId = $this->session->userdata('user_id');
$permissionName = 'manage_users';

if ($this->Permission_model->userHasPermission($userId, $permissionName)) {
    // User has permission
    echo "User can manage users";
} else {
    // User doesn't have permission
    echo "Access denied";
}
```

## Admin Panel Usage

### Managing Roles

1. **Access Roles**: Navigate to Admin → Roles
2. **Create Role**: Click "Create New Role" button
3. **Edit Role**: Click the edit icon on any role
4. **Delete Role**: Click the delete icon (only if no users are assigned)
5. **View Role Details**: Click the view icon to see role information and assigned users

### Managing Permissions

1. **Access Permissions**: Navigate to Admin → Permissions
2. **Create Permission**: Click "Create New Permission" button
3. **Edit Permission**: Click the edit icon on any permission
4. **Delete Permission**: Click the delete icon (only if not assigned to any roles)
5. **Bulk Assign**: Use "Bulk Assign" to assign multiple permissions to a role

### Permission Naming Convention

- Use lowercase letters only
- Separate words with underscores
- Be descriptive but concise
- Examples: `manage_users`, `view_reports`, `edit_shipments`

## Security Best Practices

### 1. Always Check Permissions on Both Frontend and Backend

```php
// Frontend (for user experience)
<?php if (has_permission('manage_users')): ?>
    <a href="<?= base_url('admin/users/create') ?>">Create User</a>
<?php endif; ?>

// Backend (for security)
public function create() {
    if (!has_permission('manage_users')) {
        redirect('admin/dashboard');
    }
    // ... rest of the method
}
```

### 2. Use Permission Helpers in Views

```php
// Good - Using helper functions
<?= permission_content('manage_users', '<a href="create">Create</a>') ?>

// Avoid - Direct permission checking in views
<?php if ($this->Permission_model->userHasPermission($userId, 'manage_users')): ?>
```

### 3. Validate Permission Names

```php
// Always validate permission names before creating
$permissionName = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $inputName));
```

### 4. Use Soft Deletes

The system uses soft deletes for roles and permissions to maintain data integrity and allow for recovery if needed.

### 5. Check for Dependencies Before Deletion

```php
// Check if role has users before deleting
$users = $this->User_model->getUsersByRole($roleId);
if (!empty($users)) {
    // Cannot delete role with assigned users
}

// Check if permission is assigned to roles before deleting
$assignedRoles = $this->getRolesWithPermission($permissionId);
if (!empty($assignedRoles)) {
    // Cannot delete permission assigned to roles
}
```

## API Endpoints

### Roles API

- `GET /admin/roles` - List all roles
- `POST /admin/roles/create` - Create new role
- `GET /admin/roles/edit/{id}` - Edit role form
- `POST /admin/roles/edit/{id}` - Update role
- `GET /admin/roles/view/{id}` - View role details
- `GET /admin/roles/delete/{id}` - Delete role
- `POST /admin/roles/check_role_name` - Check role name availability
- `GET /admin/roles/export` - Export roles to CSV

### Permissions API

- `GET /admin/permissions` - List all permissions
- `POST /admin/permissions/create` - Create new permission
- `GET /admin/permissions/edit/{id}` - Edit permission form
- `POST /admin/permissions/edit/{id}` - Update permission
- `GET /admin/permissions/view/{id}` - View permission details
- `GET /admin/permissions/delete/{id}` - Delete permission
- `POST /admin/permissions/check_permission_name` - Check permission name availability
- `GET /admin/permissions/export` - Export permissions to CSV
- `GET /admin/permissions/bulk_assign` - Bulk assign permissions form
- `POST /admin/permissions/bulk_assign` - Process bulk assignment

## Troubleshooting

### Common Issues

1. **Permission Not Working**

   - Check if user is assigned to a role
   - Verify the role has the required permission
   - Ensure permission name matches exactly (case-sensitive)

2. **Role Cannot Be Deleted**

   - Check if users are assigned to the role
   - Remove user assignments first

3. **Permission Cannot Be Deleted**

   - Check if permission is assigned to any roles
   - Remove role assignments first

4. **AJAX Calls Not Working**
   - Ensure CSRF token is included
   - Check browser console for JavaScript errors
   - Verify AJAX endpoints are accessible

### Debugging

```php
// Debug user permissions
$userId = $this->session->userdata('user_id');
$permissions = $this->Permission_model->getUserPermissionNames($userId);
echo "User permissions: " . implode(', ', $permissions);

// Debug role assignments
$user = $this->User_model->getUserById($userId);
echo "User role: " . $user->role_name;
```

## Performance Considerations

1. **Cache Permission Results**: Consider caching user permissions in session
2. **Optimize Database Queries**: Use eager loading for related data
3. **Index Database**: Ensure proper indexes on role_permissions table
4. **Limit Permission Checks**: Avoid checking permissions in loops

## Future Enhancements

- Permission inheritance (role hierarchies)
- Time-based permissions
- Permission groups/categories
- Advanced permission rules (conditions)
- Permission audit logging
- API-based permission management
- Mobile app permission support

## Support

For technical support or questions about the role and permissions system, please refer to the system documentation or contact the development team.
