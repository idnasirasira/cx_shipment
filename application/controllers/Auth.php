<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/guest';
        $this->load->model('User_model');
        $this->load->library('form_validation');
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
    }

    public function forgot_password()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/auth/forgot-password.js'];
        $this->pageStyles =  [];

        $this->loadView('auth/forgot-password', 'Forgot Password', $data);
    }

    public function register()
    {
        $data = [];
        $data['title'] = 'Register';
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
        // TODO: Implement register process
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('Password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Register';
            $data['errors'] = validation_errors();
            $this->loadView('auth/register', $data);
        } else {
            $this->User_model->register();
            redirect('auth/login');
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
        // TODO: Implement login process
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->loadView('auth/login', 'Login', ['errors' => validation_errors()]);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->login($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'role_id'   => $user->role_id,
                    'logged_in' => TRUE
                ]);
                redirect('admin/dashboard');
            } else {
                $this->loadView('auth/login', 'Login', ['errors' => 'Invalid credentials']);
            }
        }
    }

    public function logout()
    {
        // TODO: Implement logout process
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
