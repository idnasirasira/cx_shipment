   <?php
    defined('BASEPATH') or exit('No direct script access allowed');

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

        public function getAllInbound()
        {
            $this->db->select('inbound.*,u1.username AS created_by_name, u2.username AS updated_by_name, c1.name AS courier_name, c2.code AS courier_code ');
            $this->db->from('inbound');
            $this->db->join('users u1', 'u1.id = inbound.created_by', 'left');
            $this->db->join('users u2', 'u2.id = inbound.updated_by', 'left');
            $this->db->join('courier c1', 'c1.id = inbound.courier_id', 'left');
            $this->db->join('courier c2', 'c2.id = inbound.courier_id', 'left');

            // $this->db->where('courier.is_deleted', FALSE);
            $query = $this->db->get();
            return $query->result();
        }
        public function getInboundById($id)
        {

            $this->db->select('inbound.*,u1.username AS created_by_name, u2.username AS updated_by_name');
            $this->db->from('inbound');
            $this->db->join('users u1', 'u1.id = inbound.created_by', 'left');
            $this->db->join('users u2', 'u2.id = inbound.updated_by', 'left');
            $this->db->where('inbound.id', $id);
            $query = $this->db->get();
            return $query->row();
        }

        public function addNewInbound($data)
        {
            return $this->db->insert($this->table, $data);
            return TRUE;
        }

        public function updateInbound($id, $data)
        {
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            return TRUE;
        }

        public function deleteInbound($id)
        {
            $this->db->where('id', $id);
            $this->db->delete($this->table);
            return TRUE;
        }
    }
