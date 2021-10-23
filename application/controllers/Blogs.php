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

        $this->load->model('Blogs_model');
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
        $data = [
            'blogs' => false,
            'title' => $this->lang->line('blogs'),
            'meta_title' => $this->lang->line('blogs_meta_title'),
            'meta_description' => $this->lang->line('blogs_meta_description'),
            'blogs_title' => $this->lang->line('title'),
            'user' => $this->lang->line('user'),
            'created_at' => $this->lang->line('created_at'),
            'view' => $this->lang->line('view')
        ];

        if ((is_numeric($limit) && $limit > 0 && $limit <= 20) && ($order == 'desc' || $order == 'asc')) {
            if (isset($date_min)) {
                $date_min = date('Y-m-d H:i:s', strtotime($date_min));
            }
            if (isset($date_max)) {
                $date_max = date('Y-m-d H:i:s', strtotime($date_max . ' 23:59:59'));
            }

            if ( ! $search = trim($this->input->get('search'))) {
                $search = null;
            }

            $blogs = $this->Blogs_model->getBlog($limit, $order, $date_min, $date_max, null, $search);

            if ($blogs) {
                $data['blogs'] = true;
                
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');

                if ($search) {
                    $this->load->view('blogs/search');
                }

                foreach ($blogs as $blog) {
                    $data['blog_id'] = $blog->id;
                    $data['blog_title'] = html_escape($blog->title);
                    $data['blog_user'] = $this->Blogs_model->getUser($blog->user_id);
                    $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                    $this->load->view('blogs/index', $data);
                }
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');

                if ($search) {
                    $this->load->view('blogs/search');
                }

                $this->load->view('blogs/index', $data);
            }

            $this->load->view('partials/footer');
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
        $data = [
            'blogs' => false,
            'myblogs' => false,
            'title' => $this->lang->line('my_blogs'),
            'meta_title' => $this->lang->line('myblogs_meta_title'),
            'meta_description' => $this->lang->line('myblogs_meta_description'),
            'blogs_title' => $this->lang->line('title'),
            'user' => $this->lang->line('user'),
            'created_at' => $this->lang->line('created_at'),
            'view' => $this->lang->line('view')
        ];

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
                        $data['blog_title'] = html_escape($blog->title);
                        $data['blog_user'] = $user;
                        $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                        $this->load->view('blogs/myblogs', $data);
                        $limit--;
                    } elseif ($key === array_key_last($blogs) && $data['myblogs'] === false) {
                        $this->load->view('blogs/myblogs', $data);
                    }
                }
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/options');
                $this->load->view('blogs/myblogs', $data);
            }

            $this->load->view('partials/footer');
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
        $data = [
            'title' => $this->lang->line('new_blog'),
            'meta_title' => $this->lang->line('newblog_meta_title'),
            'meta_description' => $this->lang->line('newblog_meta_description'),
            'form_title' => $this->lang->line('title'),
            'form_body' => $this->lang->line('body'),
            'form_button' => $this->lang->line('post'),
            'form_reset' => $this->lang->line('reset')
        ];

        $this->form_validation->set_rules('blog_title', $data['form_title'], 'ltrim|required|max_length[20]');
        $this->form_validation->set_rules('blog_body', $data['form_body'], 'required');

        if ($this->form_validation->run()) {
            $data = [
                'title' => $this->input->post('blog_title'),
                'body' => $this->input->post('blog_body'),
                'user_id' => $this->Blogs_model->getUserId($this->encryption->decrypt($this->session->userdata('username')))
            ];
            $this->Blogs_model->insertBlog($data);

            redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs');
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('blogs/newblog', array_merge($data, $this->input->post()));
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
        $id = $this->uri->segment(4);

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($this->Blogs_model->blogsNumber(), 'desc', false, false, $id);

            if ($blog) {
                $data = [
                    'title' => $this->lang->line('view_blog'),
                    'meta_title' => $this->lang->line('view_meta_title'),
                    'meta_description' => $this->lang->line('view_meta_description'),
                    'view_title' => html_escape($blog->title),
                    'user' => $this->lang->line('user'),
                    'created_at' => $this->lang->line('created_at'),
                    'body' => $this->lang->line('body'),
                    'id' => $blog->id,
                    'view_user' => $this->Blogs_model->getUser($blog->user_id),
                    'view_created_at' => date('d-m-Y H:i', strtotime($blog->created_at)),
                    'view_body' => html_escape($blog->body),
                    'delete' => $this->lang->line('delete'),
                    'edit' => $this->lang->line('edit_blog')
                ];

                $this->form_validation->set_rules('id', '', 'required');

                if ($this->form_validation->run()) {
                    $this->Blogs_model->deleteBlog($data['id']);
                    redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all');
                } else {
                    $this->load->view('partials/header', $data);
                    $this->load->view('blogs/view', $data);
                    $this->load->view('partials/footer');
                }

                return;
            }
        }
        
        show_404();
    }

    /**
     * Edits a particular Blog
     * 
     * @return  void
     */
    public function edit()
    {
        $id = $this->uri->segment(4);

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($this->Blogs_model->blogsNumber(), 'desc', false, false, $id);

            if ($blog) {
                $user = $this->Blogs_model->getUser($blog->user_id);

                if ((strtolower($user) == strtolower($this->encryption->decrypt($this->session->userdata('username'))))) {
                    $data = [
                        'title' => $this->lang->line('edit_blog'),
                        'meta_title' => $this->lang->line('edit_meta_title'),
                        'meta_description' => $this->lang->line('edit_meta_description'),
                        'form_title' => $this->lang->line('title'),
                        'form_body' => $this->lang->line('body'),
                        'form_button' => $this->lang->line('post'),
                        'form_reset' => $this->lang->line('reset'),
                        'edit_title' => $blog->title,
                        'edit_body' => $blog->body,
                        'id' => $blog->id
                    ];

                    $this->form_validation->set_rules('blog_title', $data['form_title'], 'ltrim|required|max_length[20]');
                    $this->form_validation->set_rules('blog_body', $data['form_body'], 'required');

                    if ($this->form_validation->run()) {
                        $data = [
                            'id' => $id,
                            'title' => $this->input->post('blog_title'),
                            'body' => $this->input->post('blog_body')
                        ];
                        $this->Blogs_model->updateBlog($data);
                        
                        redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs');
                    } else {
                        $this->load->view('partials/header', $data);
                        $this->load->view('blogs/edit', array_merge($data, $this->input->post()));
                        $this->load->view('partials/footer');
                    }

                    return;
                }
            }
        }

        show_404();
    }
}
