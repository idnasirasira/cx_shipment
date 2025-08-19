<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/admin/dashboard/index.js'];
        $this->pageStyles =  [];

        $this->loadView('admin/dashboard/index', 'Dashboard', $data);
    }
}
