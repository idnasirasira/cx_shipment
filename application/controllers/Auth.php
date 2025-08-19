<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/guest';
        $this->load->model('Auth_model');
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
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]|max_length[12]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('passconf', 'Password Confrimation', 'required|trim|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $this->pageScripts =  ['assets/js/auth/register.js'];
            $this->pageStyles =  [];
            $this->loadView('auth/register', 'Register', []);
        } else {
            $data = [
                'role_id' => 1,
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->Auth_model->register($data);
            $this->session->set_flashdata('success', 'Registration success! Please Login');
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
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $this->pageScripts =  ['assets/js/auth/login.js'];
            $this->pageStyles =  [];
            $this->loadView('auth/login', 'Login', $data);
        } else {
            $this->Auth_model->login($username, $password);
            redirect('auth/login');
        }
    }

    public function logout()
    {
        // TODO: Implement logout process
        $this->Auth_model->logout();
        redirect('auth/login');
    }
}
