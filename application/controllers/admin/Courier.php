<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller untuk mengelola CRUD Kurir.
 * Terintegrasi dengan layout dan sistem otentikasi admin.
 */
class Courier extends MY_Controller
{
    /**
     * Constructor.
     * Memuat model, library, dan memastikan otentikasi pengguna.
     */
    public function __construct()
    {
        parent::__construct();

        // Mengatur layout default untuk controller ini
        $this->defaultLayout = 'layouts/app';

        // Memuat model Courier
        $this->load->model('Courier_model');

        // Memuat library yang dibutuhkan
        $this->load->library(['form_validation', 'session']);
    }

    /**
     * Menampilkan daftar semua kurir yang tidak dihapus.
     */
    public function index()
    {
        $data = [
            'couriers' => $this->Courier_model->get_all_couriers(),
            'section_title' => 'Courier Management'
        ];

        // Memuat script dan style tambahan jika ada
        $this->pageScripts = [
            'assets/js/global.js',
            // Tambahkan script datatable jika diperlukan
        ];
        $this->pageStyles = [];

        // Gunakan metode loadView dari MY_Controller
        $this->loadView('courier/index', 'Courier List', $data);
    }

    public function create()
    {
        $data = [
            'section_title' => 'Add New Courier'
        ];

        $this->pageScripts = ['assets/js/global.js'];
        $this->pageStyles = [];

        $this->loadView('courier/create', 'Create Courier', $data);
    }

    /**
     * Menyimpan data kurir baru dari formulir.
     */
    public function store()
    {
        // Atur aturan validasi
        $this->form_validation->set_rules('name', 'Nama Kurir', 'required|max_length[255]');
        $this->form_validation->set_rules('code', 'Kode Kurir', 'required|is_unique[courier.code]|max_length[255]');

        // Pesan error kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('is_unique', '{field} ini sudah ada, harus unik.');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, tampilkan kembali form dengan error
            $data = ['section_title' => 'Add New Courier'];
            $this->loadView('courier/create', 'Create Courier', $data);
        } else {

            // Validasi berhasil, siapkan data
            date_default_timezone_set('Asia/Jakarta');
            $user_id = $this->session->userdata('user_id');
            $data = array(
                'name'        => $this->input->post('name'),
                'code'        => $this->input->post('code'),
                'description' => $this->input->post('description'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
                'created_by'  => $user_id,
                'updated_by'  => $user_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            );

            if ($this->Courier_model->create_courier($data)) {
                $this->session->set_flashdata('success', 'Kurir berhasil ditambahkan!');
                redirect('admin/courier');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan kurir. Silakan coba lagi.');
                redirect('admin/courier/create');
            }
        }
    }

    /**
     * Menampilkan formulir untuk mengedit data kurir.
     * @param int $id ID kurir
     */
    public function edit($id = null)
    {
        $courier = $this->Courier_model->get_courier_by_id($id);

        // Jika kurir tidak ditemukan atau sudah dihapus
        if (!$courier || $courier->is_deleted) {
            show_404();
        }

        $data = [
            'courier' => $courier,
            'section_title' => 'Edit Courier'
        ];

        $this->pageScripts = ['assets/js/global.js'];
        $this->pageStyles = [];

        $this->loadView('courier/edit', 'Edit Courier', $data);
    }

    /**
     * Memperbarui data kurir.
     * @param int $id ID kurir
     */
    public function update($id = null)
    {
        // Ambil data kurir saat ini untuk perbandingan validasi
        $courier = $this->Courier_model->get_courier_by_id($id);
        if (!$courier) {
            show_404();
        }

        // Atur aturan validasi. Cek unik untuk 'code'
        $is_code_unique_rule = ($this->input->post('code') != $courier->code) ? '|is_unique[courier.code]' : '';
        $this->form_validation->set_rules('name', 'Nama Kurir', 'required|max_length[255]');
        $this->form_validation->set_rules('code', 'Kode Kurir', 'required|max_length[255]' . $is_code_unique_rule);

        // Pesan error kustom
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('is_unique', '{field} ini sudah ada, harus unik.');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, tampilkan kembali form dengan error
            $data = [
                'courier' => $courier,
                'section_title' => 'Edit Courier'
            ];
            $this->loadView('admin/courier/edit', 'Edit Courier', $data);
        } else {
            // Validasi berhasil, siapkan data update
            date_default_timezone_set('Asia/Jakarta');
            $user_id = $this->session->userdata('user_id');
            $data = array(
                'name'        => $this->input->post('name'),
                'code'        => $this->input->post('code'),
                'description' => $this->input->post('description'),
                'is_active'   => $this->input->post('is_active') ? 1 : 0,
                'updated_by'  => $user_id,
                'updated_at'  => date('Y-m-d H:i:s')
            );

            if ($this->Courier_model->update_courier($id, $data)) {
                $this->session->set_flashdata('success', 'Kurir berhasil diperbarui!');
                redirect('admin/courier');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui kurir. Silakan coba lagi.');
                redirect('admin/courier/edit/' . $id);
            }
        }
    }

    /**
     * Melakukan soft delete pada data kurir.
     * @param int $id ID kurir
     */
    public function delete($id = null)
    {
        $courier = $this->Courier_model->get_courier_by_id($id);
        if (!$courier || $courier->is_deleted) {
            show_404();
        }

        // Siapkan data untuk soft delete
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $user_id,
            'deleted_at' => date('Y-m-d H:i:s')
        );

        if ($this->Courier_model->soft_delete_courier($id, $data)) {
            $this->session->set_flashdata('success', 'Kurir berhasil dihapus (soft delete)!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kurir. Silakan coba lagi.');
        }

        redirect('admin/courier');
    }
}
