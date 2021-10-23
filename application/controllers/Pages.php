<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Static pages Controller Class
 * 
 * @author  Antonio Granaldi
 */
class Pages extends MY_Controller
{
    /**
     * View a particular static pages
     * 
     * @param   string  $page   the name of the page to view.
     * @return  void
     */
    public function view(string $page = 'home')
    {
        if (file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            $data['title'] = $this->lang->line($page . '_static_page_title');
            $data['meta_title'] = $this->lang->line($page . '_static_page_meta_title');
            $data['meta_description'] = $this->lang->line($page . '_static_page_meta_description');
            
            $this->load->view('partials/header', $data);
            $this->load->view('pages/' . $page);
            $this->load->view('partials/footer');
        } else {
            show_404();
        }
    }
}
