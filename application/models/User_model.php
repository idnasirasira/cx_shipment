<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }
    public function register()
    {
        $data = array(
            'role_id' => 2, // Default role for new users
            'email' => htmlspecialchars($this->input->post('email'), true),
            'username' => htmlspecialchars($this->input->post('username'), true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ); {
            return $this->db->insert($this->table, $data);
        }
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get($this->table)->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
