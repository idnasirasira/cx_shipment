<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation'); // Tambahkan ini
        $this->defaultLayout = 'layouts/app';
    }

    public function security()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getUserById($user_id);
        if (!$data['user']) {
            redirect('admin/dashboard');
        }
        $this->loadView('admin/users/account_security', 'Account Security', $data);
    }

    public function reset_password()
    {
        // Ambil ID user yang sedang login
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->getUserById($user_id);

        // Atur aturan validasi
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        // Mengatur pesan error kustom
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('matches', 'Konfirmasi password tidak cocok.');

        // Jalankan validasi
        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, kembalikan ke halaman security dengan error
            $this->security(); // Memanggil metode security() untuk memuat ulang view
        } else {
            // Jika validasi berhasil
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            if ($user && password_verify($current_password, $user->password)) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_data = ['password' => $hashed_password];

                if ($this->User_model->updateUser($user_id, $update_data)) {
                    $this->session->set_flashdata('success_security', 'Password berhasil diperbarui!');
                } else {
                    $this->session->set_flashdata('error_security', 'Gagal memperbarui password.');
                }
            } else {
                $this->session->set_flashdata('error_security', 'Password saat ini salah.');
            }
            redirect('admin/account/security');
        }
    }
}
