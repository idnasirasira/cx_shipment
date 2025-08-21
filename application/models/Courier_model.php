<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Model
 * 
 * Handles all database operations related to users
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Courier_model extends CI_Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'courier';
    }

    /**
     * Get all users with role information
     * 
     * @return array Array of user objects
     */
    public function getAllCourier($userId)
    {
        $this->db->select('courier.*, users.username as user_name');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = "' . $userId . '"', 'left');
        $this->db->where('courier.is_deleted', 0);
        $this->db->order_by('courier.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    public function getCourierById($userId, $id)
    {
        $this->db->select('courier.*, users.username as user_name');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = "' . $userId . '"', 'left');
        $this->db->where('courier.id', $id);
        $this->db->order_by('courier.created_at', 'DESC');

        $query = $this->db->get();
        return $query->row();
    }

    public function createCourier($data)
    {
        $data['deleted_at'] = null;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert($this->table, $data);
    }

    public function updateCourier($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function softDelete($id, $data = [])
    {
        $userId = $this->session->userdata('user_id');

        $data = [
            'is_deleted' => 1,
            'deleted_by' => $userId,
            'deleted_at' => date('Y-m-d H:i:s')
        ];


        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}
