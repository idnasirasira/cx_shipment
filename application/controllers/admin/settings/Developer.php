<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Developer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->defaultLayout = 'layouts/app';
    }

    public function index()
    {
        $data = [];
        $this->pageScripts =  ['assets/js/admin/settings/developer/index.js'];
        $this->pageStyles =  [];

        $this->loadView('admin/settings/developer/index', 'Developer Settings', $data);
    }
}
