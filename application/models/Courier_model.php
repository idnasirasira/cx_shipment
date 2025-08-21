<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Model
 * 
 * Handles all database operations related to courier
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
     * Get all courier with role information
     * 
     * @return array Array of user objects
     */
    public function getAllcourier()
    {
        $this->db->select('courier.*, u1.username as created_name, u2.username as updated_by');
        $this->db->from($this->table);
        $this->db->join('users u1', 'u1.id = courier.created_by', 'left');
        $this->db->join('users u2', 'u2.id = courier.updated_by', 'left');
        $this->db->where('courier.is_deleted', 0);
        $this->db->order_by('courier.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    public function getCourierById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getAllActive()
    {
        $this->db->where('is_deleted', 0);
        return $this->db->get('courier')->result();
    }

    public function createCourier($data)
    {
        return $this->db->insert('courier', $data);
    }

    public function updateCourier($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('courier', $data);
    }

    public function softDeleteCourier($id, $user_id)
    {
        $this->db->where('id', $id);
        return $this->db->update('courier', [
            'is_deleted' => 1,
            'deleted_by' => $user_id,
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
    }
}
