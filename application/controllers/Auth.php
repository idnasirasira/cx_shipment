<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/guest';
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

        redirect('admin/dashboard');
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

        redirect('admin/dashboard');
    }

    public function logout()
    {
        // TODO: Implement logout process

        redirect('auth/login');
    }
}
