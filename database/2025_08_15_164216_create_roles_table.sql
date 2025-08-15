-- Migration: create_roles_table
-- Created at: 2025_08_15_164216
-- SQL here
-- Drop table if exists
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);
-- Insert default roles
INSERT INTO roles (name, description)
VALUES ('admin', 'Administrator with full access'),
    ('staff', 'Staff with limited access'),
    ('driver', 'Delivery driver'),
    ('customer', 'Customer/client user');