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
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        // Mengatur pesan error kustom untuk setiap aturan
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('valid_email', 'Silakan masukkan email yang valid.');
        $this->form_validation->set_message('is_unique', '{field} ini sudah terdaftar.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('matches', 'Konfirmasi password tidak cocok.');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman register dengan input dan error sebelumnya
            $this->loadView('auth/register', 'Register', []);
        } else {
            // Jika validasi berhasil
            $data = array(
                'email'    => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role_id'  => 2,
                'is_active' => 1
            );

            $this->load->model('User_model');
            $this->User_model->insert_user($data);

            $this->session->set_flashdata('success_message', 'Registrasi berhasil! Silakan login.');
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
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Mengatur pesan error kustom
        $this->form_validation->set_message('required', '{field} harus diisi.');

        if ($this->form_validation->run() == FALSE) {
            $this->loadView('auth/login', 'Login', []);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->load->model('User_model');
            $user = $this->User_model->getUserByUsername($username);

            if ($user && password_verify($password, $user->password)) {
                // ... (kode login berhasil, tidak ada perubahan)
                $user_data = array(
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($user_data);

                $this->session->set_flashdata('success_message', 'Login berhasil!');
                redirect('admin/dashboard');
            } else {
                // **PERUBAHAN DI SINI**
                // Login gagal, kirim pesan error spesifik ke view
                $data['error_login'] = 'Username atau Password salah';
                $this->loadView('auth/login', 'Login', $data);
            }
        }
    }

    public function logout()
    {
        // TODO: Implement logout process

        redirect('auth/login');
    }
}
