<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{

    public function __construct()
    {

        parent::__construct();

    }
    
    public function show_404($page = '', $log_error = TRUE)
    {

        $CI =& get_instance();
        $output = '';
        $data['title'] = '404';

        $output .= $CI->load->view('partials/header', $data, true);
        $output .= $CI->load->view('my404', '', true);
        $output .= $CI->load->view('partials/footer', '', true);
        
        set_status_header(404);
        echo $output;
        exit;

    }

}
