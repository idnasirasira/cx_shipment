<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
            array(
                'name' => 'Shipments',
                'icon' => 'bi bi-box-seam',
                'permission' => 'manage_shipments',
                'submenu' => array(
                    array('name' => 'All Shipments', 'url' => 'admin/shipments', 'permission' => 'view_shipments'),
                    array('name' => 'Create Shipment', 'url' => 'admin/shipments/create', 'permission' => 'create_shipments'),
                    array('name' => 'Pending', 'url' => 'admin/shipments/pending', 'permission' => 'view_shipments'),
                    array('name' => 'In Transit', 'url' => 'admin/shipments/in-transit', 'permission' => 'view_shipments'),
                    array('name' => 'Delivered', 'url' => 'admin/shipments/delivered', 'permission' => 'view_shipments'),
                    array('name' => 'Cancelled', 'url' => 'admin/shipments/cancelled', 'permission' => 'view_shipments')
                )
            ),
            array(
                'name' => 'Tracking',
                'icon' => 'bi bi-geo-alt',
                'permission' => 'manage_tracking',
                'submenu' => array(
                    array('name' => 'Track Shipment', 'url' => 'admin/tracking', 'permission' => 'view_tracking'),
                    array('name' => 'Update Location', 'url' => 'admin/tracking/update', 'permission' => 'update_tracking'),
                    array('name' => 'Tracking History', 'url' => 'admin/tracking/history', 'permission' => 'view_tracking')
                )
            ),
            array(
                'name' => 'Reports',
                'icon' => 'bi bi-file-earmark-text',
                'permission' => 'view_reports',
                'submenu' => array(
                    array('name' => 'Shipment Reports', 'url' => 'admin/reports/shipments', 'permission' => 'view_reports'),
                    array('name' => 'Revenue Reports', 'url' => 'admin/reports/revenue', 'permission' => 'view_reports'),
                    array('name' => 'Performance Reports', 'url' => 'admin/reports/performance', 'permission' => 'view_reports')
                )
            )
        )
    ),
    array(
        'title' => 'Settings',
        'items' => array(
            // Menu baru untuk Kurir
            array(
                'name' => 'Courier Management',
                'url' => 'admin/courier',
                'icon' => 'bi bi-truck',
                'permission' => 'manage_couriers'
            ),
            array(
                'name' => 'Shipping Rates',
                'url' => 'admin/settings/rates',
                'icon' => 'bi bi-currency-dollar',
                'permission' => 'manage_settings'
            ),
            array(
                'name' => 'Service Areas',
                'url' => 'admin/settings/areas',
                'icon' => 'bi bi-map',
                'permission' => 'manage_settings'
            ),
            array(
                'name' => 'User Management',
                'icon' => 'bi bi-people',
                'url' => 'admin/users',
                'permission' => 'manage_users',
                'submenu' => array(
                    array('name' => 'All Users', 'url' => 'admin/users/index', 'permission' => 'view_users'),
                    array('name' => 'Create User', 'url' => 'admin/users/create', 'permission' => 'create_users'),
                    array('name' => 'Staff', 'url' => 'admin/users/staff', 'permission' => 'view_users'),
                    array('name' => 'Customers', 'url' => 'admin/users/customers', 'permission' => 'view_users')
                )
            ),
            array(
                'name' => 'Role Management',
                'icon' => 'bi bi-shield-check',
                'url' => 'admin/roles',
                'permission' => 'manage_roles',
                'submenu' => array(
                    array('name' => 'All Roles', 'url' => 'admin/roles', 'permission' => 'view_roles'),
                    array('name' => 'Create Role', 'url' => 'admin/roles/create', 'permission' => 'create_roles'),
                    array('name' => 'Permissions', 'url' => 'admin/permissions', 'permission' => 'manage_permissions'),
                    array('name' => 'Bulk Assign', 'url' => 'admin/permissions/bulk_assign', 'permission' => 'manage_permissions')
                )
            ),
            array(
                'name' => 'Developer Settings',
                'icon' => 'bi bi-gear',
                'url' => 'admin/settings/developer',
                'permission' => 'manage_developer_settings',
                'submenu' => array(
                    array('name' => 'Developer Settings', 'url' => 'admin/settings/developer', 'permission' => 'manage_developer_settings'),
                )
            ),
        )
    )
);
