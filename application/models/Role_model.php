<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Role Model
 * 
 * Handles all database operations related to roles
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Role_model extends CI_Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'roles';
    }

    /**
     * Get all roles
     * 
     * @return array Array of role objects
     */
    public function getAllRoles()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get role by ID
     * 
     * @param int $id Role ID
     * @return object|null Role object or null if not found
     */
    public function getRoleById($id)
    {
        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');

        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get role by name
     * 
     * @param string $name Role name
     * @return object|null Role object or null if not found
     */
    public function getRoleByName($name)
    {
        $this->db->where('name', $name);
        $this->db->where('deleted_at IS NULL');

        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Create new role
     * 
     * @param array $data Role data
     * @return int|bool Role ID on success, false on failure
     */
    public function createRole($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Update role
     * 
     * @param int $id Role ID
     * @param array $data Role data to update
     * @return bool True on success, false on failure
     */
    public function updateRole($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');
        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete role (soft delete)
     * 
     * @param int $id Role ID
     * @return bool True on success, false on failure
     */
    public function deleteRole($id)
    {
        $data = [
            'deleted_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');
        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Get active roles only
     * 
     * @return array Array of active role objects
     */
    public function getActiveRoles()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Check if role name exists
     * 
     * @param string $name Role name to check
     * @param int $excludeId Role ID to exclude from check (for updates)
     * @return bool True if exists, false otherwise
     */
    public function roleNameExists($name, $excludeId = null)
    {
        $this->db->where('name', $name);
        $this->db->where('deleted_at IS NULL');

        if ($excludeId) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get total role count
     * 
     * @return int Total number of roles
     */
    public function getTotalRoleCount()
    {
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results($this->table);
    }
}
