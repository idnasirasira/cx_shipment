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
    }

    public function loadView($view, $title, $data = [])
    {
        $this->layout->set_title($title);
        $this->layout->set_layout($this->defaultLayout);
        $this->layout->set_view($view, $data);

        if (isset($data['scripts'])) {
            $this->layout->set_scripts($data['scripts']);
        } else {
            $this->layout->set_scripts($this->pageScripts);
        }

        if (isset($data['styles'])) {
            $this->layout->set_styles($data['styles']);
        } else {
            $this->layout->set_styles($this->pageStyles);
        }

        $this->load->view($this->defaultLayout, $this->layout->data);
    }
}
