<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbound_model extends CI_Model
{
    protected $table = 'inbound';

    public function __construct()
    {
        parent::__construct();
    }

    // Ambil semua inbound
    public function getAllInbound($userId)
    {
        $this->db->select('inbound.*, c1.name as courier_name, u1.username as created_by, u2.username as updated_by');
        $this->db->from($this->table);
        $this->db->join('courier c1', 'c1.id = inbound.courier_id', 'left');
        $this->db->join('users u1', 'u1.id =  inbound.created_by', 'left');
        $this->db->join('users u2', 'u2.id =  inbound.updated_by', 'left');
        $this->db->order_by('inbound.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function checkAwb($awbNumber)
    {
        $this->db->select('inbound.*');
        $this->db->from($this->table);
        $this->db->where('awb_number', $awbNumber);

        return $this->db->get()->result();
    }

    // Ambil inbound by ID
    public function getInboundById($id)
    {
        $this->db->select('inbound.*, courier.name as courier_name');
        $this->db->from($this->table);
        $this->db->join('courier', 'courier.id = inbound.courier_id', 'left');
        $this->db->where('inbound.id', $id);
        return $this->db->get()->row();
    }

    // Insert inbound baru
    public function insertInbound($data)
    {
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = 0;
        $data['updated_by'] = 0;
        return $this->db->insert($this->table, $data);
    }

    // Update inbound
    public function updateInbound($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Hard delete inbound (hapus permanen)
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
