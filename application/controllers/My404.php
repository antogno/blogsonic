<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends MY_Controller
{

    public function __construct() {

        parent::__construct();

    }
    public function index()
    {

        $this->output->set_status_header('404');
        $data['title'] = '404';
        
        $this->load->view('partials/header', $data);
        $this->load->view('my404');
        $this->load->view('partials/footer');

    }

}
