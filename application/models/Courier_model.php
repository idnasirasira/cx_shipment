<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
    public function getAllCouriers()
    {
        $this->db->select('courier.*,u1.username AS created_by_name, u2.username AS updated_by_name');
        $this->db->from('courier');
        $this->db->join('users u1', 'u1.id = courier.created_by', 'left');
        $this->db->join('users u2', 'u2.id = courier.updated_by', 'left');

        $this->db->where('courier.is_deleted', FALSE);
        $query = $this->db->get();
        return $query->result();
    }
    //get by id
    public function getCourierById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('courier');
        return $query->row();
    }
    //create
    public function addNewCourier($data)
    {
        return $this->db->insert($this->table, $data);
    }


    //update
    public function updateCourier($id, $data)
    {

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }
}
