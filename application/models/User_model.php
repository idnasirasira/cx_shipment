<?php

class User_model extends CI_Model
{
    public function getUserByUsername($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }
}
