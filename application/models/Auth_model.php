<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_users()
    {
        $query = $this->db->get('users');
        $data['users'] = $query->result_array();
    }

    public function create_users()
    {
        $data = [
            'role_id' => 1,
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),

        ];
        return $this->db->insert('users', $data);
    }

    // public function get_users_by_id($id)
    // {
    //     // Logika untuk mengambil produk berdasarkan ID
    // }