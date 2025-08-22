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
class Inbound_model extends CI_Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'inbound';
    }

    /**
     * Get all courier with role information
     * 
     * @return array Array of user objects
     */
    public function getAllinbound()
    {
        $this->db->select('inbound.*, c1.name as courier_id');
        $this->db->from($this->table);
        $this->db->join('courier c1', 'c1.id = inbound.courier_id', 'left');
        $this->db->order_by('inbound.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }
}
