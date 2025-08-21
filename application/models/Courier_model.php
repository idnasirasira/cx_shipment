<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model untuk mengelola data kurir (courier).
 * Bertanggung jawab untuk semua operasi database terkait tabel 'courier'.
 */
class Courier_model extends CI_Model
{
    /**
     * Nama tabel di database.
     * @var string
     */
    private $table = 'courier';

    /**
     * Mengambil semua data kurir yang TIDAK DIHAPUS (soft deleted).
     *
     * @return array Array objek kurir
     */
    public function get_all_couriers()
    {
        // Hanya ambil data yang is_deleted = FALSE
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Mengambil data kurir berdasarkan ID.
     *
     * @param int $id ID kurir
     * @return object|null Objek kurir jika ditemukan, null jika tidak
     */
    public function get_courier_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Memeriksa apakah 'code' kurir sudah ada di database.
     * Digunakan untuk validasi unik.
     *
     * @param string $code Kode kurir
     * @param int|null $id ID kurir yang dikecualikan (untuk update)
     * @return bool True jika kode sudah ada, false jika tidak
     */
    public function is_code_exists($code, $id = null)
    {
        $this->db->where('code', $code);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    /**
     * Menyimpan data kurir baru ke database.
     *
     * @param array $data Data yang akan disimpan
     * @return int|bool ID kurir yang baru atau false jika gagal
     */
    public function create_courier($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Memperbarui data kurir yang sudah ada.
     *
     * @param int $id ID kurir yang akan diperbarui
     * @param array $data Data baru
     * @return bool True jika berhasil, false jika gagal
     */
    public function update_courier($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Melakukan soft delete pada data kurir.
     *
     * @param int $id ID kurir yang akan dihapus
     * @param array $data Data untuk soft delete (is_deleted, deleted_at, deleted_by)
     * @return bool True jika berhasil, false jika gagal
     */
    public function soft_delete_courier($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}
