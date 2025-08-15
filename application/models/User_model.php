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
class User_model extends CI_Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * Get all users with role information
     * 
     * @return array Array of user objects
     */
    public function getAllUsers()
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.deleted_at IS NULL');
        $this->db->order_by('users.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get user by ID
     * 
     * @param int $id User ID
     * @return object|null User object or null if not found
     */
    public function getUserById($id)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.id', $id);
        $this->db->where('users.deleted_at IS NULL');

        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Get user by username
     * 
     * @param string $username Username
     * @return object|null User object or null if not found
     */
    public function getUserByUsername($username)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.username', $username);
        $this->db->where('users.deleted_at IS NULL');

        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Get user by email
     * 
     * @param string $email Email address
     * @return object|null User object or null if not found
     */
    public function getUserByEmail($email)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.email', $email);
        $this->db->where('users.deleted_at IS NULL');

        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Create new user
     * 
     * @param array $data User data
     * @return int|bool User ID on success, false on failure
     */
    public function createUser($data)
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
     * Update user
     * 
     * @param int $id User ID
     * @param array $data User data to update
     * @return bool True on success, false on failure
     */
    public function updateUser($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');
        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete user (soft delete)
     * 
     * @param int $id User ID
     * @return bool True on success, false on failure
     */
    public function deleteUser($id)
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
     * Hard delete user
     * 
     * @param int $id User ID
     * @return bool True on success, false on failure
     */
    public function hardDeleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Get users by role
     * 
     * @param int $roleId Role ID
     * @return array Array of user objects
     */
    public function getUsersByRole($roleId)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.role_id', $roleId);
        $this->db->where('users.deleted_at IS NULL');
        $this->db->where('users.is_active', 1);
        $this->db->order_by('users.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get active users only
     * 
     * @return array Array of active user objects
     */
    public function getActiveUsers()
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_active', 1);
        $this->db->where('users.deleted_at IS NULL');
        $this->db->order_by('users.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Search users
     * 
     * @param string $search Search term
     * @return array Array of user objects
     */
    public function searchUsers($search)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.deleted_at IS NULL');
        $this->db->group_start();
        $this->db->like('users.username', $search);
        $this->db->or_like('users.email', $search);
        $this->db->or_like('users.first_name', $search);
        $this->db->or_like('users.last_name', $search);
        $this->db->or_like('roles.name', $search);
        $this->db->group_end();
        $this->db->order_by('users.created_at', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get user count by role
     * 
     * @return array Array with role counts
     */
    public function getUserCountByRole()
    {
        $this->db->select('roles.name as role_name, COUNT(users.id) as user_count');
        $this->db->from('roles');
        $this->db->join('users', 'users.role_id = roles.id AND users.deleted_at IS NULL', 'left');
        $this->db->group_by('roles.id, roles.name');
        $this->db->order_by('roles.name');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get total user count
     * 
     * @return int Total number of users
     */
    public function getTotalUserCount()
    {
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get active user count
     * 
     * @return int Number of active users
     */
    public function getActiveUserCount()
    {
        $this->db->where('is_active', 1);
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results($this->table);
    }

    /**
     * Update last login timestamp
     * 
     * @param int $id User ID
     * @return bool True on success, false on failure
     */
    public function updateLastLogin($id)
    {
        $data = [
            'last_login' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Check if username exists
     * 
     * @param string $username Username to check
     * @param int $excludeId User ID to exclude from check (for updates)
     * @return bool True if exists, false otherwise
     */
    public function usernameExists($username, $excludeId = null)
    {
        $this->db->where('username', $username);
        $this->db->where('deleted_at IS NULL');

        if ($excludeId) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Check if email exists
     * 
     * @param string $email Email to check
     * @param int $excludeId User ID to exclude from check (for updates)
     * @return bool True if exists, false otherwise
     */
    public function emailExists($email, $excludeId = null)
    {
        $this->db->where('email', $email);
        $this->db->where('deleted_at IS NULL');

        if ($excludeId) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get users with pagination
     * 
     * @param int $limit Number of records per page
     * @param int $offset Offset for pagination
     * @return array Array of user objects
     */
    public function getUsersWithPagination($limit = 10, $offset = 0)
    {
        $this->db->select('users.*, roles.name as role_name, roles.description as role_description');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.deleted_at IS NULL');
        $this->db->order_by('users.created_at', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return $query->result();
    }
}
