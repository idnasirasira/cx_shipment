<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courier extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';

        // Load required models
        $this->load->model('courier_model');
        // Session Library
        $this->load->library('session');

        // Load form validation library
        $this->load->library('form_validation');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $data = ['role' => $this->session->userdata('role')];


        $data['courier'] = $this->courier_model->getAllcourier($user_id);
        $data['title'] = 'All Courier';


        $this->pageScripts = [
            'assets/js/global.js',
            'assets/extensions/datatables.net/js/jquery.dataTables.min.js',
            'assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
            'assets/js/admin/users/index.js'
        ];


        $this->pageStyles = [
            'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'assets/compiled/css/table-datatable-jquery.css'
        ];

        $this->loadView('courier/index', 'User Management', $data);
    }

    public function create()
    {
        $data = [];
        $data['title'] = 'Create Courier';
        $this->pageScripts = ['assets/js/courier/create.js'];
        $this->pageStyles = [];

        $this->loadView('courier/create', 'Create Courier', $data);
    }

    public function store()
    {
        $data = [];
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required');
        $this->form_validation->set_rules('description', 'Description',);
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'store Courier';
            $data['errors'] = validation_errors();
            $this->loadView('courier', $data);
        } else {
            $this->db->insert('courier', [
                'name'   => htmlspecialchars($this->input->post('name')),
                'code'  => htmlspecialchars($this->input->post('code')),
                'description' => htmlspecialchars($this->input->post('description')),
                'is_active'  => 1, // Active status
                'is_deleted' => 0, // Active status
                'deleted_by' => 0, // Active status
                'created_by' => $user_id,
                'updated_by' => 0,
                'deleted_at' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            redirect('courier');
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required');
        $this->form_validation->set_rules('description', 'Description');

        if ($this->form_validation->run() == FALSE) {
            $data = ['courier' => $this->courier_model->getCourierById($id)];
            $data['errors'] = validation_errors();
            $data['courier'] = $this->courier_model->getCourierById($id);
            $data['title'] = 'Edit Courier';
            $this->loadView('courier/edit', 'Edit Courier', $data);
        } else {
            $courierData = [
                'name'        => htmlspecialchars($this->input->post('name')),
                'code'        => htmlspecialchars($this->input->post('code')),
                'description' => htmlspecialchars($this->input->post('description')),
                'updated_by'  => $user_id,
                'updated_at'  => date('Y-m-d H:i:s')
            ];

            $this->courier_model->updateCourier($id, $courierData);
            $this->session->set_flashdata('success', 'Courier updated successfully');
            redirect('courier');
        }
    }

    public function Delete($id = null)
    {
        if (!$id) {
            show_404();
        }

        $user_id = $this->session->userdata('user_id');
        $this->courier_model->softDeleteCourier($id, $user_id);
        $this->session->set_flashdata('success', 'Courier deleted successfully');
        redirect('courier');
    }
}
