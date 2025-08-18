<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/guest';
    }

    public function check_login()
    {
        // Check if user is logged in
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
    }

    public function index()
    {
        // Redirect to login page
        redirect('auth/login');
    }

    public function login()
    {
        $this->check_login();

        $data = [];
        $this->pageScripts =  ['assets/js/auth/login.js'];
        $this->pageStyles =  [];

        $this->loadView('auth/login', 'Login', $data);
    }


    public function forgot_password()
    {
        $this->check_login();

        $data = [];
        $this->pageScripts =  ['assets/js/auth/forgot-password.js'];
        $this->pageStyles =  [];

        $this->loadView('auth/forgot-password', 'Forgot Password', $data);
    }

    public function register()
    {
        $this->check_login();

        $data = [];
        $this->pageScripts =  ['assets/js/auth/register.js'];
        $this->pageStyles =  [];

        $this->loadView('auth/register', 'Register', []);
    }

    /**
     * Process user registration form submission
     * 
     * Handles validation and creation of new user accounts. Validates email,
     * username, and password fields. Creates new user record if validation passes.
     * Redirects to login page on success, shows error messages on failure.
     *
     * @return void
     */
    public function register_process()
    {
        $this->check_login();

        // Validation
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/register');
        }
        // generate hash password
        $hashPassword = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => $hashPassword,
            'role_id' => 2,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Insert user
        $this->db->insert('users', $data);

        // Send session notification
        $this->session->set_flashdata('success', 'Registration successful');

        redirect('auth/login');
    }

    /**
     * Process user login form submission
     * 
     * Handles validation and authentication of user login attempts. Validates 
     * username and password fields. Authenticates user credentials against database.
     * Creates session and redirects to dashboard on success, shows error on failure.
     *
     * @return void
     */
    public function login_process()
    {
        $this->check_login();

        // Validation
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/login');
        }

        // Load User Model
        $this->load->model('User_model', 'user_model');
        $user = $this->user_model->getUserByUsername($this->input->post('username'));

        if (!$user) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/login');
        }

        // Check password
        if (!password_verify($this->input->post('password'), $user->password)) {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/login');
        }

        // Set session
        $this->session->set_userdata('logged_in', true);
        $this->session->set_userdata('user_id', $user->id);
        $this->session->set_userdata('user_name', $user->username);
        $this->session->set_userdata('user_email', $user->email);
        $this->session->set_userdata('user_role', $user->role_id);

        redirect('admin/dashboard');
    }

    public function logout()
    {
        // TODO: Implement logout process
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_role');
        $this->session->sess_destroy();

        redirect('auth/login');
    }
}
