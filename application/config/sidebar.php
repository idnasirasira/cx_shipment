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
            ),
            array(
                'name' => 'Shipments',
                'icon' => 'bi bi-box-seam',
                'submenu' => array(
                    array('name' => 'All Shipments', 'url' => 'admin/shipments'),
                    array('name' => 'Create Shipment', 'url' => 'admin/shipments/create'),
                    array('name' => 'Pending', 'url' => 'admin/shipments/pending'),
                    array('name' => 'In Transit', 'url' => 'admin/shipments/in-transit'),
                    array('name' => 'Delivered', 'url' => 'admin/shipments/delivered'),
                    array('name' => 'Cancelled', 'url' => 'admin/shipments/cancelled')
                )
            ),
            array(
                'name' => 'Tracking',
                'icon' => 'bi bi-geo-alt',
                'submenu' => array(
                    array('name' => 'Track Shipment', 'url' => 'admin/tracking'),
                    array('name' => 'Update Location', 'url' => 'admin/tracking/update'),
                    array('name' => 'Tracking History', 'url' => 'admin/tracking/history')
                )
            ),
            array(
                'name' => 'Reports',
                'icon' => 'bi bi-file-earmark-text',
                'submenu' => array(
                    array('name' => 'Shipment Reports', 'url' => 'admin/reports/shipments'),
                    array('name' => 'Revenue Reports', 'url' => 'admin/reports/revenue'),
                    array('name' => 'Performance Reports', 'url' => 'admin/reports/performance')
                )
            )
        )
    ),
    array(
        'title' => 'Settings',
        'items' => array(
            array(
                'name' => 'Shipping Rates',
                'url' => 'admin/settings/rates',
                'icon' => 'bi bi-currency-dollar'
            ),
            array(
                'name' => 'Service Areas',
                'url' => 'admin/settings/areas',
                'icon' => 'bi bi-map'
            ),
            array(
                'name' => 'User Management',
                'icon' => 'bi bi-people',
                'submenu' => array(
                    array('name' => 'Staff', 'url' => 'admin/users/staff'),
                    array('name' => 'Customers', 'url' => 'admin/users/customers'),
                    array('name' => 'Roles', 'url' => 'admin/users/roles')
                )
            ),
            array(
                'name' => 'Developer Settings',
                'icon' => 'bi bi-gear',
                'url' => 'admin/settings/developer',
                'submenu' => array(
                    array('name' => 'Developer Settings', 'url' => 'admin/settings/developer'),
                )
            ),
        )
    )
);
