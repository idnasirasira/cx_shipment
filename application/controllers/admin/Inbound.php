<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbound extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
        $this->load->model('User_model');
        $this->load->model('Courier_model');
        $this->load->model('Inbound_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $userId = $this->session->userdata('user_id');
        $data = [
            'user'          => $this->User_model->getUserById($userId),
            'inbounds'      => $this->Inbound_model->getAllInbound($userId),
            'couriers'      => $this->Courier_model->getAllCourier($userId),
            'section_title' => 'All Inbound'
        ];

        $this->pageScripts = [
            'assets/js/global.js',
            'assets/extensions/datatables.net/js/jquery.dataTables.min.js',
            'assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
            'assets/js/admin/inbound/index.js'
        ];

        $this->pageStyles = [
            'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
            'assets/compiled/css/table-datatable-jquery.css'
        ];

        $this->loadView('admin/inbound/index', 'Inbound Management', $data);
    }

    public function create()
    {
        $userId = $this->session->userdata('user_id');
        $data = [
            'user'          => $this->User_model->getUserById($userId),
            'couriers'      => $this->Courier_model->getAllCourier($userId),
            'section_title' => 'Create Inbound'
        ];

        $this->pageScripts = ['assets/js/global.js'];
        $this->pageStyles  = [];

        $this->loadView('admin/inbound/create', 'Create Inbound', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('courier_id', 'Courier', 'required');
        $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
        $this->form_validation->set_rules('sender_phone', 'Sender Phone', 'required');
        $this->form_validation->set_rules('sender_address', 'Sender Address', 'required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
        $this->form_validation->set_rules('receiver_phone', 'Receiver Phone', 'required');
        $this->form_validation->set_rules('receiver_address', 'Receiver Address', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required|numeric');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/inbound/create');
        }

        // Generate AWB number
        if ($this->input->post('awb_number') == null) {
            $awbNumber = 'AWB-' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        } else {
            $awbNumber = $this->input->post('awb_number');
        }

        $checkAwb = $this->Inbound_model->checkAwb($awbNumber);

        if (count($checkAwb) > 0) {
            redirect('admin/inbound/create');
            $this->session->set_flashdata('dannger', 'Awb Number sudah digunakan.');
        }

        $data = [
            'awb_number'          => $awbNumber,
            'courier_id'          => $this->input->post('courier_id'),
            'sender_name'         => $this->input->post('sender_name'),
            'sender_phone'        => $this->input->post('sender_phone'),
            'sender_address'      => $this->input->post('sender_address'),
            'receiver_name'       => $this->input->post('receiver_name'),
            'receiver_phone'      => $this->input->post('receiver_phone'),
            'receiver_address'    => $this->input->post('receiver_address'),
            'package_description' => $this->input->post('description'),
            'package_weight'      => $this->input->post('weight'),
            'notes'               => $this->input->post('notes'),
            'status'              => $this->input->post('status'),
        ];

        $this->Inbound_model->insertInbound($data);

        $this->session->set_flashdata('success', 'Inbound berhasil ditambahkan.');
        redirect('admin/inbound');
    }

    public function edit($id)
    {
        $inbound = $this->Inbound_model->getInboundById($id);
        $userId = $this->session->userdata('user_id');

        $data = [
            'inbound' => $inbound,
            'couriers' => $this->Courier_model->getAllCourier($userId)
        ];

        $this->pageScripts = [
            'assets/js/global.js',
        ];
        $this->pageStyles = [];

        $this->loadView('admin/inbound/edit', 'Edit Inbond', $data);
    }

    public function update($id)
    {
        // Set validation rules
        $this->form_validation->set_rules('courier_id', 'Courier', 'required');
        $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
        $this->form_validation->set_rules('sender_phone', 'Sender Phone', 'required');
        $this->form_validation->set_rules('sender_address', 'Sender Address', 'required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
        $this->form_validation->set_rules('receiver_phone', 'Receiver Phone', 'required');
        $this->form_validation->set_rules('receiver_address', 'Receiver Address', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required|numeric');
        $this->form_validation->set_rules('notes', 'Notes', 'trim');

        $awb_number = 'AWB-' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        // Password validation (optional for updates)

        if ($this->form_validation->run() === FALSE) {
            $inbound = $this->Inbound_model->getInboundById($id);

            $data = [
                'inbound' => $inbound,
                'validation_errors' => validation_errors()
            ];

            $this->pageScripts = [
                'assets/js/global.js',
            ];
            $this->pageStyles = [];

            $this->loadView('admin/inbound/edit', 'Edit Inbound', $data);
        } else {
            // Validation passed, update user
            $data = [
                'courier_id'          => $this->input->post('courier_id'),
                'status'              => $this->input->post('status'),
                'sender_name'         => $this->input->post('sender_name'),
                'sender_phone'        => $this->input->post('sender_phone'),
                'sender_address'      => $this->input->post('sender_address'),
                'receiver_name'       => $this->input->post('receiver_name'),
                'receiver_phone'      => $this->input->post('receiver_phone'),
                'receiver_address'    => $this->input->post('receiver_address'),
                'package_description' => $this->input->post('description'),
                'package_weight'      => $this->input->post('weight'),
                'notes'               => $this->input->post('notes'),
            ];

            $updated = $this->Inbound_model->updateInbound($id, $data);

            if ($updated) {
                $this->session->set_flashdata('success', 'User updated successfully!');
                redirect('admin/inbound');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user. Please try again.');
                redirect('admin/inbound/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        $this->Inbound_model->delete($id);
        $this->session->set_flashdata('success', 'Inbound berhasil dihapus.');
        redirect('admin/inbound');
    }
}
