<?php defined('BASEPATH') or exit('No direct script access allowed'); {
    /**
     * Inbound Controller
     * 
     * Handles inbound shipment management
     */
    class Inbound extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->defaultLayout = 'layouts/app';
            $this->load->model('inbound_model');
            $this->load->model('courier_model');
            $this->load->library('form_validation');
        }

        public function index()
        {
            $data = [];
            $data['title'] = 'Inbound Shipments';
            $data['inbounds'] = $this->inbound_model->getAllInbound();
            $this->pageStyles = ['assets/css/inbound.css'];
            $this->pageScripts = ['assets/js/inbound/index.js'];


            $this->loadView('admin/inbound/index', 'Inbound Shipments', $data);
        }
        public function create()
        {
            $data = [];
            $data['title'] = 'Create Inbound Shipment';
            $data['couriers'] = $this->courier_model->getAllCourier();
            $this->pageScripts = ['assets/js/inbound/create.js'];
            $this->pageStyles = [];

            $this->loadView('admin/inbound/create', 'Create Inbound Shipment', $data);
        }

        public function store()
        {
            $this->form_validation->set_rules('courier_id', 'Courier', 'required');
            $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
            $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == false) {
                $data = [];
                $data['title'] = 'Create Inbound Shipment';
                $data['couriers'] = $this->courier_model->getAllCourier();
                $this->pageStyles = ['assets/css/inbound.css'];
                $this->pageScripts = ['assets/js/inbound/index.js'];
                $this->loadView('admin/inbound/create', 'Create Inbound Shipment', $data);
            } else {
                $user_id = $this->session->userdata('user_id');

                $insertData = [
                    'awb_number'        => rand(100000, 999999),
                    'courier_id'        => $this->input->post('courier_id', true),
                    'status'            => $this->input->post('status', true),
                    'sender_name'       => $this->input->post('sender_name', true),
                    'sender_phone'      => $this->input->post('sender_phone', true),
                    'sender_address'    => $this->input->post('sender_address', true),
                    'receiver_name'     => $this->input->post('receiver_name', true),
                    'receiver_phone'    => $this->input->post('receiver_phone', true),
                    'receiver_address'  => $this->input->post('receiver_address', true),
                    'package_description' => $this->input->post('package_description', true),
                    'package_weight'    => $this->input->post('package_weight', true),
                    'notes'             => $this->input->post('notes', true),
                    'created_by'        => $user_id,
                    'updated_by'        => 0,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                ];

                $this->db->insert('inbound', $insertData);

                redirect('admin/inbound');
            }
        }
        public function edit($id)
        {
            $shipment = $this->db->get_where('inbound', ['id' => $id])->row();

            if (!$shipment) {
                $this->session->set_flashdata('error', 'Inbound shipment not found.');
                redirect('admin/inbound');
            }

            $data = [];
            $data['title'] = 'Edit Inbound';
            $data['shipment'] = $shipment;
            $data['couriers'] = $this->courier_model->getAllCourier();
            $this->pageScripts = ['assets/js/inbound/edit.js'];
            $this->pageStyles = [];

            $this->loadView('admin/inbound/edit', 'Edit Inbound Shipment', $data);
        }

        public function update($id)
        {
            $this->form_validation->set_rules('courier_id', 'Courier', 'required');
            $this->form_validation->set_rules('sender_name', 'Sender Name', 'required');
            $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == false) {
                $this->edit($id);
            } else {
                $user_id = $this->session->userdata('user_id');

                $updateData = [
                    'courier_id'        => $this->input->post('courier_id', true),
                    'status'            => $this->input->post('status', true),
                    'sender_name'       => $this->input->post('sender_name', true),
                    'sender_phone'      => $this->input->post('sender_phone', true),
                    'sender_address'    => $this->input->post('sender_address', true),
                    'receiver_name'     => $this->input->post('receiver_name', true),
                    'receiver_phone'    => $this->input->post('receiver_phone', true),
                    'receiver_address'  => $this->input->post('receiver_address', true),
                    'package_description' => $this->input->post('package_description', true),
                    'package_weight'    => $this->input->post('package_weight', true),
                    'notes'             => $this->input->post('notes', true),
                    'updated_by'        => $user_id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ];

                $this->db->where('id', $id);
                $this->db->update('inbound', $updateData);

                $this->session->set_flashdata('success', 'Inbound shipment updated successfully.');
                redirect('admin/inbound');
            }
        }

        public function delete($id)
        {
            $shipment = $this->db->get_where('inbound', ['id' => $id])->row();

            if (!$shipment) {
                $this->session->set_flashdata('error', 'Inbound shipment not found.');
                redirect('admin/inbound');
            }
            $this->db->delete('inbound', ['id' => $id]);

            $this->session->set_flashdata('success', 'Inbound shipment deleted successfully.');
            redirect('admin/inbound');
        }
    }
}
