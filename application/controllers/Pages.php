<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    public function view($page = 'home')
    {

        if (file_exists(APPPATH.'views/pages/'.$page.'.php')) {
            $data['title'] = $this->lang->line($page.'_static_page_title');
            
            $this->load->view('partials/header', $data);
            $this->load->view('pages/'.$page);
            $this->load->view('partials/footer');
        } else {
            show_404();
        }

    }

}
