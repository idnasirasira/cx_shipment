<?php

class Layout
{
    public $data = [];

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function set_layout($layout)
    {
        $this->defaultLayout = $layout;
    }

    public function set_title($title)
    {
        $this->data['title'] = $title;
    }

    public function set_view($view, $data = [])
    {
        $this->data['contents'] = $this->CI->load->view($view, $data, true);
    }

    public function set_scripts($scripts)
    {
        $this->data['scripts'] = $scripts;
    }

    public function set_styles($styles)
    {
        $this->data['styles'] = $styles;
    }
}
