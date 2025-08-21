<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->defaultLayout = 'layouts/app';
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getUserById($id);
        $this->pageStyles =  [];
        $this->loadView('admin/profile/index', 'Profile', $data);
    }

    public function edit()
    {
        $data = [];
        $id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->getUserById($id);

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|alpha_dash|callback_email_unique[' . $id . ']');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_unique[' . $id . ']');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('address', 'Address', 'required');



        if ($this->form_validation->run() == FALSE) {
            $this->pageStyles =  [];
            $this->loadView('admin/profile/edit', 'Edit Profile', $data);
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
            ];

            $this->User_model->updateUser($id, $data);
            redirect('admin/profile');
        }
    }

    public function reset_password()
    {
        $data = [];
        $id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_check_current_password[' . $id . ']');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->pageStyles =  [];
            $this->loadView('admin/profile/reset_password', 'Edit Profile', $data);
        } else {
            $data = [
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),

            ];

            $this->User_model->updateUser($id, $data);
            redirect('admin/profile');
        }
    }



    //CALLBACK  
    public function email_unique($email, $id)
    {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_unique', 'The Email field must contain a unique value.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function username_unique($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_unique', 'The Username field must contain a unique value.');
            return FALSE;
        }
        return TRUE;
    }
    public function check_current_password($input_password, $id)
    {

        $user = $this->db->get_where('users', ['id' => $id])->row();

        if ($user) {

            if (password_verify($input_password, $user->password)) {
                return TRUE;
            }
        }

        $this->form_validation->set_message('check_current_password', 'The Current Password is incorrect');
        return FALSE;
    }
}
