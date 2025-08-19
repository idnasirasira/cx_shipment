<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
        $this->load->model('User_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $userId = $this->session->userdata('user_id');
        $data = ['user' => $this->User_model->getUserById($userId)];
        $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
        $this->pageStyles =  [];
        $this->loadView('admin/profile/index', 'Profile', $data);
    }

    public function reset()
    {
        $userId = $this->session->userdata('user_id');
        $data = ['user' => $this->User_model->getUserById($userId)];
        $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
        $this->pageStyles =  [];
        $this->loadView('admin/profile/reset', 'Reset Password', $data);
    }

    public function edit_process()
    {
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('phoneNum', 'Phone Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() == false) {
            $userId = $this->session->userdata('user_id');
            $data = ['user' => $this->User_model->getUserById($userId)];
            $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
            $this->pageStyles =  [];
            $this->loadView('admin/profile/index', 'Profile', $data);
        } else {
            $userId = $this->session->userdata('user_id');
            $data = [
                'first_name' => htmlspecialchars($this->input->post('firstName', true)),
                'last_name' => htmlspecialchars($this->input->post('lastName', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'phone' => htmlspecialchars($this->input->post('phoneNum', true)),
                'address' => htmlspecialchars($this->input->post('address', true)),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->User_model->updateUser($userId, $data);
            $this->session->set_flashdata('success', '<div class="alert alert-success"> Success edit profile', '</div>');
            redirect('admin/profile');
        }
    }

    public function reset_process()
    {
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required|min_length[4]');
        $this->form_validation->set_rules('passconf', 'Password Confrimation', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $userId = $this->session->userdata('user_id');
            $data = ['user' => $this->User_model->getUserById($userId)];
            $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
            $this->pageStyles =  [];
            $this->loadView('admin/profile/reset', 'Reset Password', $data);
        } else {
            $userId = $this->session->userdata('user_id');
            $user = $this->db->get_where('users', ['id' => $userId])->row();
            $password = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);

            if (!password_verify($password, $user->password)) {
                $userId = $this->session->userdata('user_id');
                $data = ['user' => $this->User_model->getUserById($userId)];
                $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
                $this->pageStyles =  [];
                $this->loadView('admin/profile/reset', 'Reset Password', $data);
                $this->session->set_flashdata('success', '<div class="alert alert-success"> Wrong Password!', '</div>');
            }

            $data = ['password' => $password];
            $this->User_model->updateUser($userId, $data);
            $this->session->set_flashdata('success', '<div class="alert alert-success"> Success change new password', '</div>');
            redirect('admin/profile');
        }
    }
}
