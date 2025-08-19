<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permissions Controller
 * 
 * Handles permission management in the admin panel
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Permissions extends MY_Controller
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
        $this->load->model('Permission_model');
        $this->load->model('Role_model');

        // Load helpers
        $this->load->helper(['url', 'form', 'security', 'permission']);

        // Set page scripts and styles
        $this->pageScripts = [
            'assets/js/admin/utils/datatable-helper.js',
            'assets/js/admin/permissions/index.js'
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
     * Index - List all permissions
     */
    public function index()
    {
        $data['permissions'] = $this->Permission_model->getPermissionsWithRoleInfo();
        $data['total_permissions'] = $this->Permission_model->getTotalPermissionCount();

        $this->loadView('admin/permissions/index', 'Manage Permissions', $data);
    }

    /**
     * Create new permission
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Permission Name', 'required|trim|max_length[50]|is_unique[permissions.name]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $permissionData = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];

                $permissionId = $this->Permission_model->createPermission($permissionData);

                if ($permissionId) {
                    $this->session->set_flashdata('success', 'Permission created successfully.');
                    redirect('admin/permissions');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create permission.');
                }
            }
        }

        $this->loadView('admin/permissions/create', 'Create New Permission', []);
    }

    /**
     * Edit permission
     */
    public function edit($id = null)
    {
        if (!$id) {
            redirect('admin/permissions');
        }

        $data['permission'] = $this->Permission_model->getPermissionById($id);
        if (!$data['permission']) {
            $this->session->set_flashdata('error', 'Permission not found.');
            redirect('admin/permissions');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Permission Name', 'required|trim|max_length[50]');
            $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');

            // Check if name is unique (excluding current permission)
            $existingPermission = $this->Permission_model->getPermissionByName($this->input->post('name'));
            if ($existingPermission && $existingPermission->id != $id) {
                $this->form_validation->set_rules('name', 'Permission Name', 'is_unique[permissions.name]');
            }

            if ($this->form_validation->run() === TRUE) {
                $permissionData = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];

                if ($this->Permission_model->updatePermission($id, $permissionData)) {
                    $this->session->set_flashdata('success', 'Permission updated successfully.');
                    redirect('admin/permissions');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update permission.');
                }
            }
        }

        $this->loadView('admin/permissions/edit', 'Edit Permission: ' . $data['permission']->name, $data);
    }

    /**
     * View permission details
     */
    public function view($id = null)
    {
        if (!$id) {
            redirect('admin/permissions');
        }

        $data['permission'] = $this->Permission_model->getPermissionById($id);
        if (!$data['permission']) {
            $this->session->set_flashdata('error', 'Permission not found.');
            redirect('admin/permissions');
        }

        // Get roles that have this permission
        $data['assigned_roles'] = $this->getRolesWithPermission($id);

        $this->loadView('admin/permissions/view', 'Permission Details: ' . $data['permission']->name, $data);
    }

    /**
     * Delete permission
     */
    public function delete($id = null)
    {
        if (!$id) {
            redirect('admin/permissions');
        }

        // Check if permission is assigned to any roles
        $assignedRoles = $this->getRolesWithPermission($id);
        if (!empty($assignedRoles)) {
            $this->session->set_flashdata('error', 'Cannot delete permission. It is assigned to one or more roles.');
            redirect('admin/permissions');
        }

        if ($this->Permission_model->deletePermission($id)) {
            $this->session->set_flashdata('success', 'Permission deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete permission.');
        }

        redirect('admin/permissions');
    }

    /**
     * Get roles that have a specific permission
     */
    private function getRolesWithPermission($permissionId)
    {
        $this->db->select('roles.*');
        $this->db->from('roles');
        $this->db->join('role_permissions', 'role_permissions.role_id = roles.id');
        $this->db->where('role_permissions.permission_id', $permissionId);
        $this->db->where('roles.deleted_at IS NULL');
        $this->db->order_by('roles.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * AJAX: Check permission name availability
     */
    public function check_permission_name()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $name = $this->input->post('name');
        $excludeId = $this->input->post('exclude_id');

        if ($this->Permission_model->permissionNameExists($name, $excludeId)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['available' => false]));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['available' => true]));
        }
    }

    /**
     * Export permissions to CSV
     */
    public function export()
    {
        $permissions = $this->Permission_model->getAllPermissions();

        $filename = 'permissions_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Add headers
        fputcsv($output, ['ID', 'Name', 'Description', 'Created At', 'Updated At']);

        // Add data
        foreach ($permissions as $permission) {
            fputcsv($output, [
                $permission->id,
                $permission->name,
                $permission->description,
                $permission->created_at,
                $permission->updated_at
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Bulk assign permissions to roles
     */
    public function bulk_assign()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
            $this->form_validation->set_rules('permissions[]', 'Permissions', 'required');

            if ($this->form_validation->run() === TRUE) {
                $roleId = $this->input->post('role_id');
                $permissions = $this->input->post('permissions');

                if ($this->Permission_model->assignPermissionsToRole($roleId, $permissions)) {
                    $this->session->set_flashdata('success', 'Permissions assigned successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to assign permissions.');
                }
            }
        }

        $data['roles'] = $this->Role_model->getAllRoles();
        $data['permissions'] = $this->Permission_model->getAllPermissions();

        $this->loadView('admin/permissions/bulk_assign', 'Bulk Assign Permissions', $data);
    }
}
