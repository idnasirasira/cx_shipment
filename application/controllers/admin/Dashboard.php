<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
    }

    public function index()
    {
        $data = [];
        $this->pageScripts =  ['assets/pages/admin/dashboard/index.js'];
        $this->pageStyles =  [];

        $this->loadView('admin/dashboard/index', 'Dashboard', $data);
    }
}
