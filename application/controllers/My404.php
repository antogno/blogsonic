<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Error 404 Controller Class
 * 
 * @author  Antonio Granaldi
 */
class My404 extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    /**
     * Shows a custom created page in case of a 404 error
     * 
     * @return  void
     */
    public function index()
    {

        $this->output->set_status_header('404');
        $data['title'] = '404';
        
        $this->load->view('partials/header', $data);
        $this->load->view('my404');
        $this->load->view('partials/footer');

    }

}
