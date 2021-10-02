<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blogs Controller Class
 * 
 * @author  Antonio Granaldi
 */
class Blogs extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    /**
     * Shows all the Blogs
     * 
     * @param   string  $limit      the maximum number of Blogs to show.
     * @param   string  $order      the order in which the Blogs are showed. 'desc' for descending order and 'asc' for ascending order.
     * @param   string  $date_min   the minimum date in which to start showing Blogs.
     * @param   string  $date_max   the maximum date of Blogs to show.
     * @return  void
     */
    public function all(string $limit = '5', string $order = 'desc', string $date_min = null, string $date_max = null)
    {

        $this->load->model('Blogs_model');

        $data = array(
            'blogs' => false,
            'title' => $this->lang->line('blogs_title'),
            'meta_description' => $this->lang->line('blogs_meta_description'),
            'blogs_title' => $this->lang->line('blogs_actual_title'),
            'user' => $this->lang->line('blogs_user'),
            'created_at' => $this->lang->line('blogs_created_at'),
            'view' => $this->lang->line('blogs_view')
        );

        if ((is_numeric($limit) && $limit > 0 && $limit <= 20) && ($order == 'desc' || $order == 'asc')) {
            if (isset($date_min)) {
                $date_min = date('Y-m-d H:i:s', strtotime($date_min));
            }
            if (isset($date_max)) {
                $date_max = date('Y-m-d H:i:s', strtotime($date_max . ' 23:59:59'));
            }

            $blogs = $this->Blogs_model->getBlog($limit, $order, $date_min, $date_max, null, $this->input->get('search'));

            if ($blogs) {
                $data['blogs'] = true;
                
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');

                if ($this->input->get('search')) {
                    $this->load->view('blogs/search');
                }

                foreach ($blogs as $blog) {
                    $data['blog_id'] = $blog->id;
                    $data['blog_title'] = $blog->title;
                    $data['blog_user'] = $this->Blogs_model->getUser($blog->user_id);
                    $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                    $this->load->view('blogs/index', $data);
                }

                $this->load->view('partials/footer');
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');
                $this->load->view('blogs/index', $data);
                $this->load->view('partials/footer');
            }
        } else {
            redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all', 'refresh');
        }

    }

    /**
     * Shows all the Blogs of the logged-in user
     * 
     * @param   string  $limit      the maximum number of Blogs to show.
     * @param   string  $order      the order in which the Blogs are showed. 'desc' for descending order and 'asc' for ascending order.
     * @param   string  $date_min   the minimum date in which to start showing Blogs.
     * @param   string  $date_max   the maximum date of showed Blogs.
     * @return  void
     */
    public function myblogs(string $limit = '5', string $order = 'desc', string $date_min = null, string $date_max = null)
    {

        $this->load->model('Blogs_model');

        $data = array(
            'blogs' => false,
            'myblogs' => false,
            'title' => $this->lang->line('myblogs_title'),
            'meta_description' => $this->lang->line('myblogs_meta_description'),
            'blogs_title' => $this->lang->line('blogs_actual_title'),
            'user' => $this->lang->line('blogs_user'),
            'created_at' => $this->lang->line('blogs_created_at'),
            'view' => $this->lang->line('blogs_view')
        );

        if ((is_numeric($limit) && $limit > 0 && $limit <= 20) && ($order == 'desc' || $order == 'asc')) {
            if (isset($date_min)) {
                $date_min = date('Y-m-d H:i:s', strtotime($date_min));
            }
            if (isset($date_max)) {
                $date_max = date('Y-m-d H:i:s', strtotime($date_max . ' 23:59:59'));
            }
            
            $blogs = $this->Blogs_model->getBlog($this->Blogs_model->blogsNumber(), $order, $date_min, $date_max);

            if ($blogs) {
                $data['blogs'] = true;
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');

                foreach ($blogs as $key => $blog) {
                    $user = $this->Blogs_model->getUser($blog->user_id);
                    if ((strtolower($user) == strtolower($this->encryption->decrypt($this->session->userdata('username')))) && ($limit > 0)) {
                        $data['myblogs'] = true;
                        $data['blog_id'] = $blog->id;
                        $data['blog_title'] = $blog->title;
                        $data['blog_user'] = $user;
                        $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                        $this->load->view('blogs/myblogs', $data);
                        $limit--;
                    } elseif ($key === array_key_last($blogs) && $data['myblogs'] === false) {
                        $this->load->view('blogs/myblogs', $data);
                    }
                }

                $this->load->view('partials/footer');
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');
                $this->load->view('blogs/myblogs', $data);
                $this->load->view('partials/footer');
            }
        } else {
            redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs', 'refresh');
        }

    }

    /**
     * Creates a new Blog
     * 
     * @return  void
     */
    public function newblog()
    {

        $this->load->model('Blogs_model');

        $data = array(
            'title' => $this->lang->line('newblog_title'),
            'meta_description' => $this->lang->line('newblog_meta_description'),
            'form_title' => $this->lang->line('newblog_actual_title'),
            'form_body' => $this->lang->line('newblog_body'),
            'form_button' => $this->lang->line('newblog_button'),
            'form_reset' => $this->lang->line('newblog_reset')
        );

        $this->form_validation->set_rules('title', $data['form_title'], 'ltrim|required|max_length[20]');
        $this->form_validation->set_rules('body', $data['form_body'], 'required');

        if ($this->form_validation->run()) {
            $data = array(
                'title' => $this->input->post('title'),
                'body' => $this->input->post('body'),
                'user_id' => $this->Blogs_model->getUserId($this->encryption->decrypt($this->session->userdata('username')))
            );
            $this->Blogs_model->insertBlog($data);

            redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs');
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('blogs/newblog', $data);
            $this->load->view('partials/footer');
        }

    }

    /**
     * View a particular Blog
     * 
     * @return  void
     */
    public function view()
    {

        $this->load->model('Blogs_model');

        $id = $this->uri->segment(4);

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($this->Blogs_model->blogsNumber(), 'desc', false, false, $id);

            if ($blog) {

                $data = array(
                    'title' => $this->lang->line('view_title'),
                    'meta_description' => $this->lang->line('view_meta_description'),
                    'view_title' => $blog->title,
                    'user' => $this->lang->line('blogs_user'),
                    'created_at' => $this->lang->line('blogs_created_at'),
                    'body' => $this->lang->line('blogs_body'),
                    'id' => $blog->id,
                    'view_user' => $this->Blogs_model->getUser($blog->user_id),
                    'view_created_at' => date('d-m-Y H:i', strtotime($blog->created_at)),
                    'view_body' => $blog->body,
                    'delete' => $this->lang->line('view_delete'),
                    'edit' => $this->lang->line('view_edit')
                );

                $this->form_validation->set_rules('id', '', 'required');

                if ($this->form_validation->run()) {
                    $this->Blogs_model->deleteBlog($data['id']);
                    redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all');
                } else {
                    $this->load->view('partials/header', $data);
                    $this->load->view('blogs/view', $data);
                    $this->load->view('partials/footer');
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }

    }

    /**
     * Edits a particular Blog
     * 
     * @return  void
     */
    public function edit()
    {

        $this->load->model('Blogs_model');

        $id = $this->uri->segment(4);

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($this->Blogs_model->blogsNumber(), 'desc', false, false, $id);

            if ($blog) {
                $user = $this->Blogs_model->getUser($blog->user_id);

                if ((strtolower($user) == strtolower($this->encryption->decrypt($this->session->userdata('username'))))) {
                    
                    $data = array(
                        'title' => $this->lang->line('edit_title'),
                        'meta_description' => $this->lang->line('edit_meta_description'),
                        'form_title' => $this->lang->line('newblog_actual_title'),
                        'form_body' => $this->lang->line('newblog_body'),
                        'form_button' => $this->lang->line('newblog_button'),
                        'form_reset' => $this->lang->line('newblog_reset'),
                        'edit_title' => $blog->title,
                        'edit_body' => $blog->body,
                        'id' => $blog->id
                    );

                    $this->form_validation->set_rules('title', $data['form_title'], 'ltrim|required|max_length[20]');
                    $this->form_validation->set_rules('body', $data['form_body'], 'required');

                    if ($this->form_validation->run()) {
                        $data = array(
                            'id' => $id,
                            'title' => $this->input->post('title'),
                            'body' => $this->input->post('body')
                        );
                        $this->Blogs_model->updateBlog($data);
                        
                        redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs');
                    } else {
                        $this->load->view('partials/header', $data);
                        $this->load->view('blogs/edit', $data);
                        $this->load->view('partials/footer');
                    }
                } else {
                    show_404();
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }

    }
    
}
