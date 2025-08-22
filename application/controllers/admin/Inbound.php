<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbound extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inbound_model');
        $this->load->model('Courier_model');
        $this->defaultLayout = 'layouts/app';
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['inbound'] = $this->Inbound_model->getAllInbound();
        $this->pageStyles =  [];
        $this->loadView('admin/inbound/index', 'Inbound', $data);
    }

    public function show($id)
    {
        $data['inbound'] = $this->Inbound_model->getInboundById($id);
        $this->pageStyles =  [];
        $this->loadView('admin/inbound/show', 'Show Inbound', $data);
    }
    public function create()
    {
        $data = [
            'courier' => $this->Courier_model->getAllCouriers()
        ];
        $this->loadView('admin/inbound/create', 'Create Inbound', $data);
    }
    public function store()
    {
        $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
        $this->form_validation->set_rules('sender_phone', 'Sender Phone', 'required|numeric');
        $this->form_validation->set_rules('sender_address', 'Sender Address', 'required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
        $this->form_validation->set_rules('receiver_phone', 'Receiver Phone', 'required|numeric');
        $this->form_validation->set_rules('receiver_address', 'Receiver Address', 'required');
        $this->form_validation->set_rules('courier', 'Courier', 'required');
        $this->form_validation->set_rules('package_description', 'Package Description', 'required');
        $this->form_validation->set_rules('package_weight', 'Package Weight', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $data = [
                'courier' => $this->Courier_model->getAllCouriers()
            ];
            $this->loadView('admin/inbound/create', 'Create Inbound', $data);
        } else {
            $data = [
                'sender_name'         => $this->input->post('sender_name'),
                'sender_phone'        => $this->input->post('sender_phone'),
                'sender_address'      => $this->input->post('sender_address'),
                'receiver_name'       => $this->input->post('receiver_name'),
                'receiver_phone'      => $this->input->post('receiver_phone'),
                'receiver_address'    => $this->input->post('receiver_address'),
                'received_by'         => $this->input->post('received_by'),
                'courier_id'          => $this->input->post('courier'),
                'package_description' => $this->input->post('package_description'),
                'package_weight'      => $this->input->post('package_weight'),
                'notes'               => $this->input->post('notes'),
                'status'              => $this->input->post('status'),
                'created_by' => $this->session->userdata('user_id'),
                'created_at'          => date('Y-m-d H:i:s'),
                'awb_number' => "CEX" . rand(0000000000, 9999999999)
            ];

            $create = $this->Inbound_model->addNewInbound($data);


            if ($create) {
                $this->session->set_flashdata('success', 'Inbound created successfully!');
                redirect('admin/inbound');
            } else {
                $this->session->set_flashdata('error', 'Failed to created Inbound. Please try again.');
                redirect('admin/inbound');
            }
        }
    }
    public function edit($id)
    {
        $data = [
            'courier' => $this->Courier_model->getAllCouriers(),
            'inbound' => $this->Inbound_model->getInboundById($id)
        ];
        $this->loadView('admin/inbound/edit', 'Edit Inbound', $data);
    }
    public function update($id)
    {
        $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
        $this->form_validation->set_rules('sender_phone', 'Sender Phone', 'required|numeric');
        $this->form_validation->set_rules('sender_address', 'Sender Address', 'required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
        $this->form_validation->set_rules('receiver_phone', 'Receiver Phone', 'required|numeric');
        $this->form_validation->set_rules('receiver_address', 'Receiver Address', 'required');
        $this->form_validation->set_rules('courier', 'Courier', 'required');
        $this->form_validation->set_rules('package_description', 'Package Description', 'required');
        $this->form_validation->set_rules('package_weight', 'Package Weight', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $data = [
                'courier' => $this->Courier_model->getAllCouriers()
            ];
            $this->loadView('admin/inbound/create', 'Create Inbound', $data);
        } else {
            $data = [
                'sender_name'         => $this->input->post('sender_name'),
                'sender_phone'        => $this->input->post('sender_phone'),
                'sender_address'      => $this->input->post('sender_address'),
                'receiver_name'       => $this->input->post('receiver_name'),
                'receiver_phone'      => $this->input->post('receiver_phone'),
                'receiver_address'    => $this->input->post('receiver_address'),
                'received_by'         => $this->input->post('received_by'),
                'courier_id'          => $this->input->post('courier'),
                'package_description' => $this->input->post('package_description'),
                'package_weight'      => $this->input->post('package_weight'),
                'notes'               => $this->input->post('notes'),
                'status'              => $this->input->post('status'),
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ];

            $update = $this->Inbound_model->updateInbound($id, $data);

            if ($update) {
                $this->session->set_flashdata('success', 'Inbound edited successfully!');
                redirect('admin/inbound');
            } else {
                $this->session->set_flashdata('error', 'Failed to update Inbound. Please try again.');
                redirect('admin/inbound');
            }
        }
    }
    public function delete($id)
    {
        $delete = $this->Inbound_model->deleteInbound($id);

        if ($delete) {
            $this->session->set_flashdata('error', 'You have deleted one of the inbound data!');
            redirect('admin/inbound');
        } else {
            $this->session->set_flashdata('error', 'Failed to update Inbound. Please try again.');
            redirect('admin/inbound');
        }
    }
}
