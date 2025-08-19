<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('upload');
        $this->load->library('form_validation');

        $this->defaultLayout = 'layouts/app';
    }

    // Metode untuk menampilkan halaman profil (hanya view)
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getUserById($user_id);

        if (!$data['user']) {
            redirect('admin/dashboard');
        }

        $this->pageScripts = []; // Tidak perlu skrip JS di sini karena tidak ada form
        $this->pageStyles = [];

        // Muat view profil yang hanya menampilkan data
        $this->loadView('admin/users/profile', 'My Profile', $data);
    }

    // Metode untuk menampilkan form edit profil (dengan form upload foto)
    public function edit()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getUserById($user_id);

        if (!$data['user']) {
            redirect('admin/dashboard');
        }

        // Skrip JS untuk mengelola form dan upload gambar
        $this->pageScripts = ['assets/js/admin/profile/edit.js'];
        $this->pageStyles = [];

        // Muat view edit_profile yang berisi form
        $this->loadView('admin/users/edit_profile', 'Edit Profile', $data);
    }

    // Metode untuk memproses update data profil dan unggah foto
    // Metode ini akan dipanggil dari form edit_profile
    public function update()
    {
        // Ambil ID user yang sedang login
        $user_id = $this->session->userdata('user_id');
        // Dapatkan data user saat ini untuk referensi
        $user = $this->User_model->getUserById($user_id);

        // --- LOGIKA UNTUK UNGGAH FOTO VIA AJAX ---
        if ($this->input->is_ajax_request()) {
            $response = ['status' => 'error', 'message' => 'Gagal memperbarui foto profil.'];

            if (!empty($_FILES['profile_picture']['name'])) {
                $config['upload_path']   = './assets/uploads/profile_pictures/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['file_name']     = 'user_profile_' . $user_id . '_' . time();

                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_picture')) {
                    $upload_data = $this->upload->data();
                    $new_profile_picture = $upload_data['file_name'];

                    if (!empty($user->profile_picture) && file_exists($config['upload_path'] . $user->profile_picture)) {
                        unlink($config['upload_path'] . $user->profile_picture);
                    }

                    $update_data = ['profile_picture' => $new_profile_picture];
                    if ($this->User_model->updateUser($user_id, $update_data)) {
                        $this->session->set_userdata('profile_picture', $new_profile_picture);
                        $response = [
                            'status' => 'success',
                            'message' => 'Foto profil berhasil diperbarui!',
                            'new_image_url' => base_url('assets/uploads/profile_pictures/' . $new_profile_picture)
                        ];
                    }
                } else {
                    $response = ['status' => 'error', 'message' => $this->upload->display_errors('', '')];
                }
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));

            return;
        }

        // --- LOGIKA UNTUK UPDATE DATA PROFIL NON-AJAX (Form Biasa) ---
        // Jika validasi gagal, kembalikan ke halaman edit
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[10]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit(); // Panggil metode edit() untuk menampilkan kembali form dengan error
        } else {
            $update_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
            );

            if ($this->User_model->updateUser($user_id, $update_data)) {
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
            }
            redirect('admin/profile'); // Arahkan kembali ke halaman profil (view saja)
        }
    }
}
