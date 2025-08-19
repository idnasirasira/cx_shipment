<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permission Model
 * 
 * Handles all database operations related to permissions
 * 
 * @author CX Shipment System
 * @version 1.0
 */
class Permission_model extends CI_Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'permissions';
        $this->role_permissions_table = 'role_permissions';
    }

    /**
     * Get all permissions
     * 
     * @return array Array of permission objects
     */
    public function getAllPermissions()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get permission by ID
     * 
     * @param int $id Permission ID
     * @return object|null Permission object or null if not found
     */
    public function getPermissionById($id)
    {
        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');

        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get permission by name
     * 
     * @param string $name Permission name
     * @return object|null Permission object or null if not found
     */
    public function getPermissionByName($name)
    {
        $this->db->where('name', $name);
        $this->db->where('deleted_at IS NULL');

        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Create new permission
     * 
     * @param array $data Permission data
     * @return int|bool Permission ID on success, false on failure
     */
    public function createPermission($data)
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
     * Update permission
     * 
     * @param int $id Permission ID
     * @param array $data Permission data to update
     * @return bool True on success, false on failure
     */
    public function updatePermission($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('deleted_at IS NULL');
        $this->db->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete permission (soft delete)
     * 
     * @param int $id Permission ID
     * @return bool True on success, false on failure
     */
    public function deletePermission($id)
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
     * Get permissions by role ID
     * 
     * @param int $roleId Role ID
     * @return array Array of permission objects
     */
    public function getPermissionsByRole($roleId)
    {
        $this->db->select('permissions.*');
        $this->db->from($this->table);
        $this->db->join($this->role_permissions_table, 'role_permissions.permission_id = permissions.id');
        $this->db->where('role_permissions.role_id', $roleId);
        $this->db->where('permissions.deleted_at IS NULL');
        $this->db->order_by('permissions.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get permission IDs by role ID
     * 
     * @param int $roleId Role ID
     * @return array Array of permission IDs
     */
    public function getPermissionIdsByRole($roleId)
    {
        $this->db->select('permission_id');
        $this->db->from($this->role_permissions_table);
        $this->db->where('role_id', $roleId);

        $query = $this->db->get();
        $result = $query->result();

        $permissionIds = [];
        foreach ($result as $row) {
            $permissionIds[] = $row->permission_id;
        }

        return $permissionIds;
    }

    /**
     * Assign permissions to role
     * 
     * @param int $roleId Role ID
     * @param array $permissionIds Array of permission IDs
     * @return bool True on success, false on failure
     */
    public function assignPermissionsToRole($roleId, $permissionIds)
    {
        // First, remove all existing permissions for this role
        $this->db->where('role_id', $roleId);
        $this->db->delete($this->role_permissions_table);

        // Then, insert new permissions
        if (!empty($permissionIds)) {
            $data = [];
            foreach ($permissionIds as $permissionId) {
                $data[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            $this->db->insert_batch($this->role_permissions_table, $data);
        }

        return true;
    }

    /**
     * Check if user has permission
     * 
     * @param int $userId User ID
     * @param string $permissionName Permission name
     * @return bool True if user has permission, false otherwise
     */
    public function userHasPermission($userId, $permissionName)
    {
        $this->db->select('permissions.id');
        $this->db->from($this->table);
        $this->db->join($this->role_permissions_table, 'role_permissions.permission_id = permissions.id');
        $this->db->join('users', 'users.role_id = role_permissions.role_id');
        $this->db->where('users.id', $userId);
        $this->db->where('permissions.name', $permissionName);
        $this->db->where('permissions.deleted_at IS NULL');
        $this->db->where('users.deleted_at IS NULL');

        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    /**
     * Get all permissions for a user
     * 
     * @param int $userId User ID
     * @return array Array of permission objects
     */
    public function getUserPermissions($userId)
    {
        $this->db->select('permissions.*');
        $this->db->from($this->table);
        $this->db->join($this->role_permissions_table, 'role_permissions.permission_id = permissions.id');
        $this->db->join('users', 'users.role_id = role_permissions.role_id');
        $this->db->where('users.id', $userId);
        $this->db->where('permissions.deleted_at IS NULL');
        $this->db->where('users.deleted_at IS NULL');
        $this->db->order_by('permissions.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get permission names for a user
     * 
     * @param int $userId User ID
     * @return array Array of permission names
     */
    public function getUserPermissionNames($userId)
    {
        $this->db->select('permissions.name');
        $this->db->from($this->table);
        $this->db->join($this->role_permissions_table, 'role_permissions.permission_id = permissions.id');
        $this->db->join('users', 'users.role_id = role_permissions.role_id');
        $this->db->where('users.id', $userId);
        $this->db->where('permissions.deleted_at IS NULL');
        $this->db->where('users.deleted_at IS NULL');

        $query = $this->db->get();
        $result = $query->result();

        $permissionNames = [];
        foreach ($result as $row) {
            $permissionNames[] = $row->name;
        }

        return $permissionNames;
    }

    /**
     * Check if permission name exists
     * 
     * @param string $name Permission name to check
     * @param int $excludeId Permission ID to exclude from check (for updates)
     * @return bool True if exists, false otherwise
     */
    public function permissionNameExists($name, $excludeId = null)
    {
        $this->db->where('name', $name);
        $this->db->where('deleted_at IS NULL');

        if ($excludeId) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get total permission count
     * 
     * @return int Total number of permissions
     */
    public function getTotalPermissionCount()
    {
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get permissions with role assignment info
     * 
     * @return array Array of permission objects with role info
     */
    public function getPermissionsWithRoleInfo()
    {
        $this->db->select('permissions.*, GROUP_CONCAT(roles.name) as assigned_roles');
        $this->db->from($this->table);
        $this->db->join($this->role_permissions_table, 'role_permissions.permission_id = permissions.id', 'left');
        $this->db->join('roles', 'roles.id = role_permissions.role_id', 'left');
        $this->db->where('permissions.deleted_at IS NULL');
        $this->db->group_by('permissions.id');
        $this->db->order_by('permissions.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
}
