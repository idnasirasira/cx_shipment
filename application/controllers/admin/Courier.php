 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Courier extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();

            $this->defaultLayout = 'layouts/app';

            // Load required models
            $this->load->model('User_model');
            $this->load->model('Courier_model');

            // Session Library
            $this->load->library('session');

            // Load form validation library
            $this->load->library('form_validation');

            date_default_timezone_set('Asia/Jakarta');
        }

        public function index()
        {
            $data = [
                'couriers' => $this->Courier_model->getAllCouriers()
            ];

            $this->pageStyles = [
                'assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/compiled/css/table-datatable-jquery.css'
            ];

            $this->loadView('admin/courier/index', 'courier', $data);
        }

        public function create()
        {
            $data = [];
            $this->pageStyles = [];
            $this->loadView('admin/courier/create', 'Create New Courier', $data);
        }

        public function store()
        {
            $data = [];
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('code', 'Code', 'required|is_unique[courier.code]');
            if ($this->form_validation->run() == FALSE) {
                $this->pageStyles =  [];
                $this->loadView('admin/courier/create', 'Create New Courier', $data);
            } else {
                $data = [
                    'name' => $this->input->post('name'),
                    'code' => $this->input->post('code'),
                    'description' => $this->input->post('description'),
                    'is_active' =>  $this->input->post('is_active'),
                    'created_by' => $this->session->userdata('user_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => null,
                    'deleted_at' => null
                ];
                $create = $this->Courier_model->addNewCourier($data);
                if ($create) {
                    $this->session->set_flashdata('success', 'Courier created successfully!');
                    redirect('admin/courier');
                } else {
                    $this->session->set_flashdata('error', 'Failed to created Courier. Please try again.');
                    redirect('admin/courier');
                }
            }
        }

        public function edit($id)
        {
            $data = [
                'courier' => $this->Courier_model->getCourierById($id),
                'id' => $id
            ];
            $this->pageStyles = [];
            $this->loadView('admin/courier/edit', 'Edit Courier', $data);
        }

        public function update($id)
        {
            $data = [
                'courier' => $this->Courier_model->getCourierById($id),
                'id' => $id
            ];
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('code', 'Code', 'required|callback_email_unique[' . $id . ']');
            if ($this->form_validation->run() == FALSE) {
                $this->pageStyles =  [];
                $this->loadView('admin/courier/edit', 'Edit Courier', $data);
            } else {
                $data = [
                    'name' => $this->input->post('name'),
                    'code' => $this->input->post('code'),
                    'description' => $this->input->post('description'),
                    'is_active' =>  $this->input->post('is_active'),
                    'updated_by' => $this->session->userdata('user_id'),
                    'updated_at' =>  date('Y-m-d H:i:s')

                ];
                $update = $this->Courier_model->updateCourier($id, $data);

                if ($update) {
                    $this->session->set_flashdata('success', 'Courier edited successfully!');
                    redirect('admin/courier');
                } else {
                    $this->session->set_flashdata('error', 'Failed to edited Courier. Please try again.');
                    redirect('admin/courier');
                }
            }
        }

        public function delete($id)
        {
            $data = [
                'is_active' =>  FALSE,
                'is_deleted' =>  TRUE,
                'deleted_by' => $this->session->userdata('user_id'),
                'deleted_at' => date('Y-m-d H:i:s')

            ];
            $this->Courier_model->updateCourier($id, $data);
            redirect('admin/courier');
        }

        //CALLBACK
        public function email_unique($code, $id)
        {
            $this->db->where('code', $code);
            $this->db->where('id !=', $id);
            $query = $this->db->get('courier');

            if ($query->num_rows() > 0) {
                $this->form_validation->set_message('email_unique', 'The Code field must contain a unique value.');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
