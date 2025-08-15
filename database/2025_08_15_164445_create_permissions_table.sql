-- Migration: create_permissions_table
-- Created at: 2025_08_15_164445
-- SQL here
-- Drop table if exists
DROP TABLE IF EXISTS permissions;
CREATE TABLE permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);
-- Create role_permissions pivot table
DROP TABLE IF EXISTS role_permissions;
CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);
-- Insert default permissions
INSERT INTO permissions (name, description)
VALUES (
        'manage_users',
        'Create, read, update and delete users'
    ),
    (
        'manage_roles',
        'Manage user roles and permissions'
    ),
    (
        'manage_orders',
        'Handle delivery orders and tracking'
    ),
    (
        'view_reports',
        'Access to system reports and analytics'
    ),
    (
        'manage_customers',
        'Manage customer information'
    ),
    (
        'manage_drivers',
        'Manage driver assignments and schedules'
    ),
    ('manage_settings', 'Configure system settings');
-- Assign permissions to admin role
INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id,
    p.id
FROM roles r
    CROSS JOIN permissions p
WHERE r.name = 'admin';
-- Assign relevant permissions to staff role
INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id,
    p.id
FROM roles r
    CROSS JOIN permissions p
WHERE r.name = 'staff'
    AND p.name IN (
        'manage_orders',
        'view_reports',
        'manage_customers',
        'manage_drivers'
    );
-- Assign minimal permissions to driver role
INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id,
    p.id
FROM roles r
    CROSS JOIN permissions p
WHERE r.name = 'driver'
    AND p.name IN ('manage_orders');