<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Management Controller
 * 
 * Handles all user-related operations in the admin panel
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Users extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';

        // Load required models
        $this->load->model('User_model');
        $this->load->model('Role_model');

        // Session Library
        $this->load->library('session');

        // Load form validation library
        $this->load->library('form_validation');
    }

    /**
     * Display list of all users
     * 
     * @return void
     */
    public function index()
    {
        $data = [
            'users' => $this->User_model->getAllUsers(),
            'roles' => $this->Role_model->getAllRoles()
        ];

        $this->pageScripts = [
            'assets/js/global.js',
            'assets/extensions/datatables.net/js/jquery.dataTables.min.js',
            'assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
            'assets/js/admin/users/index.js'
        ];


        $this->pageStyles = [
            'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'assets/compiled/css/table-datatable-jquery.css'
        ];

        $this->loadView('admin/users/index', 'User Management', $data);
    }

    /**
     * Show create user form
     * 
     * @return void
     */
    public function create()
    {
        $data = [
            'roles' => $this->Role_model->getAllRoles()
        ];

        $this->pageScripts = [
            'assets/js/global.js',
            'assets/js/admin/users/form.js'
        ];
        $this->pageStyles = [];

        $this->loadView('admin/users/create', 'Create New User', $data);
    }

    /**
     * Store new user
     * 
     * @return void
     */
    public function store()
    {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[50]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
        $this->form_validation->set_rules('phone', 'Phone', 'max_length[20]');
        $this->form_validation->set_rules('address', 'Address', 'max_length[500]');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, show form again with errors
            $data = [
                'roles' => $this->Role_model->getAllRoles(),
                'validation_errors' => validation_errors()
            ];

            $this->pageScripts = [
                'assets/js/global.js',
                'assets/js/admin/users/form.js'
            ];
            $this->pageStyles = [];

            $this->loadView('admin/users/create', 'Create New User', $data);
        } else {
            // Validation passed, create user
            $userData = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'role_id' => $this->input->post('role_id'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];

            $userId = $this->User_model->createUser($userData);

            if ($userId) {
                $this->session->set_flashdata('success', 'User created successfully!');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user. Please try again.');
                redirect('admin/users/create');
            }
        }
    }

    /**
     * Show user details
     * 
     * @param int $id User ID
     * @return void
     */
    public function show($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user = $this->User_model->getUserById($id);

        if (!$user) {
            show_404();
        }

        $data = [
            'user' => $user,
            'role' => $this->Role_model->getRoleById($user->role_id)
        ];

        $this->pageScripts = [];
        $this->pageStyles = [];

        $this->loadView('admin/users/show', 'User Details', $data);
    }

    /**
     * Show edit user form
     * 
     * @param int $id User ID
     * @return void
     */
    public function edit($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user = $this->User_model->getUserById($id);

        if (!$user) {
            show_404();
        }

        $data = [
            'user' => $user,
            'roles' => $this->Role_model->getAllRoles()
        ];

        $this->pageScripts = [
            'assets/js/global.js',
            'assets/js/admin/users/form.js'
        ];
        $this->pageStyles = [];

        $this->loadView('admin/users/edit', 'Edit User', $data);
    }

    /**
     * Update user
     * 
     * @param int $id User ID
     * @return void
     */
    public function update($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user = $this->User_model->getUserById($id);

        if (!$user) {
            show_404();
        }

        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[50]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
        $this->form_validation->set_rules('phone', 'Phone', 'max_length[20]');
        $this->form_validation->set_rules('address', 'Address', 'max_length[500]');

        // Check for unique username and email (excluding current user)
        $username_unique = $this->input->post('username') !== $user->username ? '|is_unique[users.username]' : '';
        $email_unique = $this->input->post('email') !== $user->email ? '|is_unique[users.email]' : '';

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]' . $username_unique);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email' . $email_unique);

        // Password validation (optional for updates)
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, show form again with errors
            $data = [
                'user' => $user,
                'roles' => $this->Role_model->getAllRoles(),
                'validation_errors' => validation_errors()
            ];

            $this->pageScripts = [
                'assets/js/global.js',
                'assets/js/admin/users/form.js'
            ];
            $this->pageStyles = [];

            $this->loadView('admin/users/edit', 'Edit User', $data);
        } else {
            // Validation passed, update user
            $userData = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'role_id' => $this->input->post('role_id'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];

            // Update password only if provided
            if ($this->input->post('password')) {
                $userData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $updated = $this->User_model->updateUser($id, $userData);

            if ($updated) {
                $this->session->set_flashdata('success', 'User updated successfully!');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user. Please try again.');
                redirect('admin/users/edit/' . $id);
            }
        }
    }

    /**
     * Delete user
     * 
     * @param int $id User ID
     * @return void
     */
    public function destroy($id = null)
    {
        if (!$id) {
            show_404();
        }

        // Prevent deleting the current user
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You cannot delete your own account.');
            redirect('admin/users');
        }

        $user = $this->User_model->getUserById($id);

        if (!$user) {
            show_404();
        }

        $deleted = $this->User_model->deleteUser($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'User deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user. Please try again.');
        }

        redirect('admin/users');
    }

    /**
     * Toggle user active status
     * 
     * @param int $id User ID
     * @return void
     */
    public function toggle_status($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user = $this->User_model->getUserById($id);

        if (!$user) {
            show_404();
        }

        $newStatus = $user->is_active ? 0 : 1;
        $updated = $this->User_model->updateUser($id, ['is_active' => $newStatus]);

        if ($updated) {
            $statusText = $newStatus ? 'activated' : 'deactivated';
            $this->session->set_flashdata('success', 'User ' . $statusText . ' successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update user status. Please try again.');
        }

        redirect('admin/users');
    }
}
