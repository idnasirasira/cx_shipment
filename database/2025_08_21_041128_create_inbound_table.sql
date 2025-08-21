-- Migration: create_inbound_table
-- Created at: 2025_08_21_041128
-- SQL here
CREATE TABLE inbound (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    awb_number VARCHAR(50) NOT NULL UNIQUE,
    courier_id BIGINT NOT NULL,
    status ENUM('pending', 'received', 'problem', 'cancelled') NOT NULL DEFAULT 'pending',
    sender_name VARCHAR(100) NOT NULL,
    sender_phone VARCHAR(20),
    sender_address TEXT,
    receiver_name VARCHAR(100) NOT NULL,
    receiver_phone VARCHAR(20),
    receiver_address TEXT,
    package_description TEXT,
    package_weight DECIMAL(10, 2),
    received_by VARCHAR(100),
    received_at TIMESTAMP,
    notes TEXT,
    created_by BIGINT,
    updated_by BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (courier_id) REFERENCES couriers(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;