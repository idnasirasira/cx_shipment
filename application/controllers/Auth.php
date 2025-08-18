<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/guest';
        $this->load->model('User_model');
    }

    public function index()
    {
        // Redirect to login page
        redirect('auth/login');
    }

    public function login()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/auth/login.js'];
        $this->pageStyles =  [];
        $this->loadView('auth/login', 'Login', $data);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
    }


    public function forgot_password()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/auth/forgot-password.js'];
        $this->pageStyles =  [];
        $this->loadView('auth/forgot-password', 'Forgot Password', $data);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
    }

    public function register()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/auth/register.js'];
        $this->pageStyles =  [];
        $this->loadView('auth/register', 'Register', []);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
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
        // TODO: Implement register process
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|alpha_dash|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $this->pageScripts =  ['assets/js/auth/register.js'];
            $this->pageStyles =  [];
            $this->loadView('auth/register', 'Register', []);
        } else {
            $this->User_model->create_users();
            redirect('admin/dashboard');
        }

        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
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
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $this->pageScripts =  ['assets/js/auth/login.js'];
            $this->pageStyles =  [];
            $this->loadView('auth/login', 'Login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Ambil user dari database
            $user = $this->db->get_where('users', ['username' => $username])->row_array();

            if ($user) {
                // Verifikasi password hash
                if (password_verify($password, $user['password'])) {
                    // Set session
                    $this->session->set_userdata([
                        'user_id'   => $user['id'],
                        'username'  => $user['username'],
                        'role_id'   => $user['role_id'],
                        'logged_in' => TRUE
                    ]);
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username tidak ditemukan!');
                redirect('auth/login');
            }
        }
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
    }

    public function logout()
    {
        // TODO: Implement logout process
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
