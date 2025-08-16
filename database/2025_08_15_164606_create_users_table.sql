-- Migration: create_users_table (combined)
-- Created at: 2025-08-15 16:46:06
-- Purpose: Fresh create users table with indexes + seed default admin
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `role_id` INT NOT NULL,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(50),
    `last_name` VARCHAR(50),
    `phone` VARCHAR(20),
    `address` TEXT,
    `profile_picture` VARCHAR(255),
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` TIMESTAMP NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_username` (`username`),
    UNIQUE KEY `uq_users_email` (`email`),
    KEY `idx_users_role_id` (`role_id`),
    KEY `idx_users_is_active` (`is_active`),
    KEY `idx_users_created_at` (`created_at`),
    KEY `idx_users_last_login` (`last_login`),
    CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Seed admin (hanya insert jika role 'admin' ada; kalau belum ada, SELECT ini nol baris)
INSERT INTO `users` (
        `role_id`,
        `username`,
        `email`,
        `password`,
        `first_name`,
        `last_name`,
        `is_active`
    )
SELECT r.`id`,
    'admin',
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    -- admin123
    'System',
    'Administrator',
    1
FROM `roles` r
WHERE r.`name` = 'admin'
    AND NOT EXISTS (
        SELECT 1
        FROM `users` u
        WHERE u.`username` = 'admin'
    );
-- (opsional) lengkapi field admin jika kosong
UPDATE `users`
SET `phone` = '+1234567890',
    `address` = 'System Administrator Address',
    `updated_at` = CURRENT_TIMESTAMP
WHERE `username` = 'admin'
    AND `phone` IS NULL;