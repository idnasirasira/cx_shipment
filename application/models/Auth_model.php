<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    private $table = 'users';
    const SESSION_KEY = 'user_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function register($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function login($username, $password)
    {
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if (!$user) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Account is not registed!</div>');
            redirect('auth/login');
        }
        if (!password_verify($password, $user['password'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong Password!</div>');
            redirect('auth/login');
        }
        if ($user['is_active'] == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Account has not been Activated! Please activated</div>');
            redirect('auth/login');
        }

        $data = [
            'username' => $user['username'],
            'role_id' => $user['role_id'],
            'logged_in' => TRUE
        ];

        $this->session->set_userdata($data);
        redirect('admin/dashboard');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success">You have been logged out!</div>');
    }
}
