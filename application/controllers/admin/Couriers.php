<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Couriers extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
        $this->load->model('User_model');
        $this->load->model('Courier_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $userId = $this->session->userdata('user_id');
        $data = [
            'user' => $this->User_model->getUserById($userId),
            'couriers' => $this->Courier_model->getAllCourier($userId),
            'section_title' => 'All Couriers'
        ];

        $this->pageScripts =  [
            'assets/js/global.js',
            'assets/extensions/datatables.net/js/jquery.dataTables.min.js',
            'assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
            'assets/js/admin/couriers/index.js'
        ];

        $this->pageStyles =  [
            'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'assets/compiled/css/table-datatable-jquery.css'
        ];

        $this->loadView('admin/couriers/index', 'Courier Management', $data);
    }

    public function create()
    {
        $userId = $this->session->userdata('user_id');


        $data = [
            'user' => $this->User_model->getUserById($userId),
            'couriers' => $this->Courier_model->getAllCourier($userId),
            'section_title' => 'All Couriers'
        ];

        $this->pageScripts =  [
            'assets/js/global.js',
            'assets/js/admin/couriers/index.js'
        ];

        $this->pageStyles =  [];

        $this->loadView('admin/couriers/create', 'Create New Courier', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data = [];

            $this->pageScripts =  [
                'assets/js/global.js',
                'assets/js/admin/couriers/index.js'
            ];

            $this->pageStyles =  [];

            $this->loadView('admin/couriers/index', 'Create new Courier', $data);
        } else {
            $userId = $this->session->userdata('user_id');

            $data = [
                'name' => htmlspecialchars($this->input->post('name')),
                'code' => str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'description' => htmlspecialchars($this->input->post('description')),
                'is_active' => $this->input->post('status'),
                'created_by' => $userId,
                'updated_by' => $userId
            ];

            $this->Courier_model->createCourier($data);

            $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissible show fade">Success Create Courier<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>', '</div>');
            redirect('admin/couriers');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', 'Courier Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/couriers');
        } else {
            $dataUpdate = [
                'name'        => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'is_active'   => $this->input->post('status'),
            ];

            $this->Courier_model->updateCourier($id, $dataUpdate);

            $this->session->set_flashdata('success', 'Courier updated successfully!');
            redirect('admin/couriers');
        }
    }

    public function modal_edit($id)
    {
        $userId = $this->session->userdata('user_id');

        $courier =  $this->Courier_model->getCourierById($userId, $id);


        $data = [
            'courier' => $courier
        ];

        $this->load->view('admin/couriers/modal_edit', $data);
    }

    public function delete($id)
    {
        if (!$id) {
            show_404();
        }

        $userId = $this->session->userdata('user_id');

        $data = [
            'delete_by' => $userId
        ];

        $deleted = $this->Courier_model->softDelete($id, $data);

        if ($deleted) {
            $this->session->set_flashdata('success', 'User deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user. Please try again.');
        }

        redirect('admin/couriers');
    }
}
