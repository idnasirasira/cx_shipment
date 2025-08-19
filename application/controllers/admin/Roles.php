<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Roles Controller
 * 
 * Handles role management in the admin panel
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Roles extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // Set default layout for admin
        $this->defaultLayout = 'layouts/app';

        // Load required models
        $this->load->model('Role_model');
        $this->load->model('Permission_model');
        $this->load->model('User_model');

        // Load helpers
        $this->load->helper(['url', 'form', 'security', 'permission']);

        // Set page scripts and styles
        $this->pageScripts = [
            'assets/js/admin/utils/datatable-helper.js',
            'assets/js/admin/roles/index.js'
        ];

        // Check if user is logged in and has admin access
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Check if user has permission to manage roles
        if (!has_permission('manage_roles')) {
            $this->session->set_flashdata('error', 'You do not have permission to access this page.');
            redirect('admin/dashboard');
        }
    }

    /**
     * Index - List all roles
     */
    public function index()
    {
        $data['roles'] = $this->Role_model->getAllRoles();
        $data['total_roles'] = $this->Role_model->getTotalRoleCount();

        // Get user count for each role
        $data['role_user_counts'] = $this->User_model->getUserCountByRole();

        $this->loadView('admin/roles/index', 'Manage Roles', $data);
    }

    /**
     * Create new role
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Role Name', 'required|trim|max_length[50]|is_unique[roles.name]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');
            $this->form_validation->set_rules('permissions[]', 'Permissions', 'required');

            if ($this->form_validation->run() === TRUE) {
                $roleData = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];

                $roleId = $this->Role_model->createRole($roleData);

                if ($roleId) {
                    // Assign permissions to role
                    $permissions = $this->input->post('permissions');
                    $this->Permission_model->assignPermissionsToRole($roleId, $permissions);

                    $this->session->set_flashdata('success', 'Role created successfully.');
                    redirect('admin/roles');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create role.');
                }
            }
        }

        $data['permissions'] = $this->Permission_model->getAllPermissions();

        $this->loadView('admin/roles/create', 'Create New Role', $data);
    }

    /**
     * Edit role
     */
    public function edit($id = null)
    {
        if (!$id) {
            redirect('admin/roles');
        }

        $data['role'] = $this->Role_model->getRoleById($id);
        if (!$data['role']) {
            $this->session->set_flashdata('error', 'Role not found.');
            redirect('admin/roles');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Role Name', 'required|trim|max_length[50]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');
            $this->form_validation->set_rules('permissions[]', 'Permissions', 'required');

            // Check if name is unique (excluding current role)
            $existingRole = $this->Role_model->getRoleByName($this->input->post('name'));
            if ($existingRole && $existingRole->id != $id) {
                $this->form_validation->set_rules('name', 'Role Name', 'is_unique[roles.name]');
            }

            if ($this->form_validation->run() === TRUE) {
                $roleData = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];

                if ($this->Role_model->updateRole($id, $roleData)) {
                    // Update role permissions
                    $permissions = $this->input->post('permissions');
                    $this->Permission_model->assignPermissionsToRole($id, $permissions);

                    $this->session->set_flashdata('success', 'Role updated successfully.');
                    redirect('admin/roles');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update role.');
                }
            }
        }

        $data['permissions'] = $this->Permission_model->getAllPermissions();
        $data['role_permissions'] = $this->Permission_model->getPermissionIdsByRole($id);

        $this->loadView('admin/roles/edit', 'Edit Role: ' . $data['role']->name, $data);
    }

    /**
     * View role details
     */
    public function view($id = null)
    {
        if (!$id) {
            redirect('admin/roles');
        }

        $data['role'] = $this->Role_model->getRoleById($id);
        if (!$data['role']) {
            $this->session->set_flashdata('error', 'Role not found.');
            redirect('admin/roles');
        }

        $data['permissions'] = $this->Permission_model->getPermissionsByRole($id);
        $data['users'] = $this->User_model->getUsersByRole($id);

        $this->loadView('admin/roles/view', 'Role Details: ' . $data['role']->name, $data);
    }

    /**
     * Delete role
     */
    public function delete($id = null)
    {
        if (!$id) {
            redirect('admin/roles');
        }

        // Check if role has users
        $users = $this->User_model->getUsersByRole($id);
        if (!empty($users)) {
            $this->session->set_flashdata('error', 'Cannot delete role. There are users assigned to this role.');
            redirect('admin/roles');
        }

        if ($this->Role_model->deleteRole($id)) {
            $this->session->set_flashdata('success', 'Role deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete role.');
        }

        redirect('admin/roles');
    }

    /**
     * AJAX: Get role permissions
     */
    public function get_role_permissions()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $roleId = $this->input->post('role_id');
        if (!$roleId) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Role ID is required']));
            return;
        }

        $permissions = $this->Permission_model->getPermissionIdsByRole($roleId);
        $this->output->set_content_type('application/json')->set_output(json_encode(['permissions' => $permissions]));
    }

    /**
     * AJAX: Check role name availability
     */
    public function check_role_name()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $name = $this->input->post('name');
        $excludeId = $this->input->post('exclude_id');

        if ($this->Role_model->roleNameExists($name, $excludeId)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['available' => false]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['available' => true]));
        }
    }

    /**
     * Export roles to CSV
     */
    public function export()
    {
        $roles = $this->Role_model->getAllRoles();

        $filename = 'roles_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Add headers
        fputcsv($output, ['ID', 'Name', 'Description', 'Created At', 'Updated At']);

        // Add data
        foreach ($roles as $role) {
            fputcsv($output, [
                $role->id,
                $role->name,
                $role->description,
                $role->created_at,
                $role->updated_at
            ]);
        }

        fclose($output);
        exit;
    }
}
