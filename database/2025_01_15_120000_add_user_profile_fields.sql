-- Migration: add_user_profile_fields
-- Created at: 2025_01_15_120000
-- Description: Add additional profile fields to users table for enhanced user management
-- Add profile picture field if not exists
ALTER TABLE users
ADD COLUMN IF NOT EXISTS profile_picture VARCHAR(255) NULL COMMENT 'Profile picture filename';
-- Add phone field if not exists
ALTER TABLE users
ADD COLUMN IF NOT EXISTS phone VARCHAR(20) NULL COMMENT 'User phone number';
-- Add address field if not exists
ALTER TABLE users
ADD COLUMN IF NOT EXISTS address TEXT NULL COMMENT 'User address';
-- Add last_login field if not exists
ALTER TABLE users
ADD COLUMN IF NOT EXISTS last_login TIMESTAMP NULL COMMENT 'Last login timestamp';
-- Add indexes for better performance
CREATE INDEX IF NOT EXISTS idx_users_username ON users(username);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_role_id ON users(role_id);
CREATE INDEX IF NOT EXISTS idx_users_is_active ON users(is_active);
CREATE INDEX IF NOT EXISTS idx_users_created_at ON users(created_at);
-- Add foreign key constraint for role_id if not exists
-- Note: This assumes the roles table exists and has an 'id' column
-- ALTER TABLE users 
-- ADD CONSTRAINT fk_users_role_id 
-- FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT;
-- Update existing admin user with additional fields if needed
UPDATE users
SET phone = '+1234567890',
    address = 'System Administrator Address',
    updated_at = CURRENT_TIMESTAMP
WHERE username = 'admin'
    AND phone IS NULL;