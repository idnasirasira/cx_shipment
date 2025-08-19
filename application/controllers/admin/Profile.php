<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation', 'session');
        $this->defaultLayout = 'layouts/app';
    }

    public function index()
    {
        $data = [];
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getuserbyid($user_id);
        $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
        $this->pageStyles =  [];

        $this->loadView('admin/profile/index', 'profile', $data);
    }

    public function update()
    {
        $id = $this->session->userdata('user_id');

        $user_data = $this->User_model->getuserbyid($id);
        if (!$user_data) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">User not found.</div>');
            redirect('admin/profile');
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [];
            $user_id = $this->session->userdata('user_id');
            $data['user'] = $this->User_model->getuserbyid($user_id);
            $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
            $this->pageStyles =  [];

            $this->loadView('admin/profile/index', 'profile', $data);
        } else {
            $id = $this->session->userdata('user_id');

            $data = [
                'first_name' => htmlspecialchars($this->input->post('first_name')),
                'last_name'  => htmlspecialchars($this->input->post('last_name')),
                'email'      => htmlspecialchars($this->input->post('email')),
                'phone'      => htmlspecialchars($this->input->post('phone')),
                'address'    => htmlspecialchars($this->input->post('address')),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->User_model->updateUser($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">Profile updated successfully.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Failed to update profile.</div>');
            }
            redirect('admin/profile');
        }
    }

    public function change_password()
    {
        $id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->User_model->getuserbyid($id);
            $this->loadView('admin/profile/index', 'profile', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password     = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $user = $this->User_model->getuserbyid($id);

            if ($user && (password_verify($current_password, $user->password) || $current_password === $user->password)) {
                $this->db->where('id', $id)->update('users', ['password' => $new_password]);
                $this->session->set_flashdata('message', '<div class="alert alert-success">Password changed successfully.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Current password is incorrect.</div>');
            }

            redirect('admin/profile');
        }
    }
}
