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
VALUES ('view_dashboard', 'View dashboard overview'),
    ('manage_shipments', 'Manage all shipments'),
    (
        'view_shipments',
        'View shipment list and details'
    ),
    ('create_shipments', 'Create new shipments'),
    ('manage_tracking', 'Manage shipment tracking'),
    ('view_tracking', 'View shipment tracking'),
    (
        'update_tracking',
        'Update shipment tracking location'
    ),
    (
        'view_reports',
        'Access to system reports and analytics'
    ),
    ('manage_settings', 'Configure system settings'),
    (
        'manage_users',
        'Create, read, update and delete users'
    ),
    ('view_users', 'View user list and details'),
    ('create_users', 'Create new users'),
    ('manage_roles', 'Manage user roles'),
    ('view_roles', 'View user roles'),
    ('create_roles', 'Create new roles'),
    (
        'manage_permissions',
        'Manage permission assignments'
    ),
    (
        'manage_developer_settings',
        'Access and configure developer settings'
    );
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