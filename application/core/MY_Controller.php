<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $defaultLayout = 'layouts/guest';
    public $pageScripts = [];
    public $pageStyles = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('layout');
        $this->mockupSession();
    }

    public function loadView($view, $title, $data = [])
    {
        // Set Data Title
        $data['title'] = $title;

        // Set view dan data ke library layout
        $this->layout->set_view($view, $data);
        $this->layout->set_title($title);
        $this->layout->set_layout($this->defaultLayout);

        // Ambil scripts dari properti controller atau dari data yang dikirim
        $scripts = isset($data['scripts']) ? $data['scripts'] : $this->pageScripts;
        $this->layout->set_scripts($scripts);

        // Ambil styles dari properti controller atau dari data yang dikirim
        $styles = isset($data['styles']) ? $data['styles'] : $this->pageStyles;
        $this->layout->set_styles($styles);

        // Langsung muat layout dengan data yang sudah disiapkan
        $this->load->view($this->defaultLayout, $this->layout->data);
    }

    public function mockupSession()
    {
        // // User Model -> getUserById
        // // Load User Model
        // $this->load->model('User_model', 'user_model');
        // $user = $this->user_model->getUserById(1);

        // if ($user) {
        //     // Check session if not set then set session
        //     if (!$this->session->userdata('user_id')) {
        //         // logged_in
        //         $this->session->set_userdata('logged_in', true);
        //         $this->session->set_userdata('user_id', $user->id);
        //         $this->session->set_userdata('user_name', $user->first_name . ' ' . $user->last_name);
        //         $this->session->set_userdata('user_email', $user->email);
        //         $this->session->set_userdata('user_role', $user->role);
        //     }
        // }
    }
}
