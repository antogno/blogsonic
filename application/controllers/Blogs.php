<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blogs Controller Class
 * 
 * @author Antonio Granaldi <tonio.granaldi@gmail.com>
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
     * @return void
     */
    public function all()
    {
        $this->showBlogs('all');
    }

    /**
     * Shows all the Blogs of the logged-in user
     * 
     * @return void
     */
    public function myblogs()
    {
        $this->showBlogs('myblogs');
    }

    /**
     * Creates a new Blog
     * 
     * @return void
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
     * Shows a particular Blog
     * 
     * @return void
     */
    public function view()
    {
        $id = $this->input->get('id') ?: $this->input->post('id');

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($id);

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
                    redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs');
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
     * @return void
     */
    public function edit()
    {
        $id = $this->input->get('id') ?: $this->input->post('id');

        if (is_numeric($id)) {
            $blog = $this->Blogs_model->getBlog($id);

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
                        
                        redirect($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/view?id=' . $id);
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

    /**
     * Method used for managing the display of Blogs
     * 
     * @param string $type the type of Blogs list to show. 'all' to show all the Blogs or 'myblogs' to show all the Blogs of the logged-in user.
     * @return void
     * @throws InvalidArgumentException if `$type` is neither 'all' or 'myblogs'.
     */
    private function showBlogs($type)
    {
        if ($type != 'all' && $type != 'myblogs') {
            throw new InvalidArgumentException('The type of Blogs list to show is invalid.');
        }

        $data = [
            'blogs' => false,
            'blogs_title' => $this->lang->line('title'),
            'user' => $this->lang->line('user'),
            'created_at' => $this->lang->line('created_at'),
            'view' => $this->lang->line('view')
        ];

        if ($type == 'all') {
            $data['title'] = $this->lang->line('blogs');
            $data['meta_title'] = $this->lang->line('blogs_meta_title');
            $data['meta_description'] = $this->lang->line('blogs_meta_description');
        } else {
            $data['myblogs'] = false;
            $data['title'] = $this->lang->line('my_blogs');
            $data['meta_title'] = $this->lang->line('myblogs_meta_title');
            $data['meta_description'] = $this->lang->line('myblogs_meta_description');
        }

        $limit = $this->input->get('limit');
        $order = $this->input->get('order');
        $date_min = $this->input->get('date_min') ?: null;
        $date_max = $this->input->get('date_max') ?: null;

        $max_limit = 100;

        if ( ! is_numeric($limit) || $limit < 0 || $limit > $max_limit) {
            $limit = 5;
        }

        if ($order != 'desc' && $order != 'asc') {
            $order = 'desc';
        }

        $options_data = [
            'limit' => $limit,
            'max_limit' => $max_limit,
            'order' => $order
        ];

        if (DateTime::createFromFormat('Y-m-d', $date_min) !== false) {
            $date_min = DateTime::createFromFormat('Y-m-d', $date_min);
            $date_min->setTime(0, 0, 0);

            $options_data['date_min'] = $date_min->format('Y-m-d');
        }

        if (DateTime::createFromFormat('Y-m-d', $date_max) !== false) {
            $date_max = DateTime::createFromFormat('Y-m-d', $date_max);
            $date_max->setTime(23, 59, 59);

            $options_data['date_max'] = $date_max->format('Y-m-d');
        }

        $search = trim($this->input->get('search'));

        $blogs = false;
        if ($type == 'all') {
            $blogs = $this->Blogs_model->getBlogs($limit, $order, $date_min, $date_max, $search);
        } else {
            if ($this->session->userdata('logged_in')) {
                $blogs = $this->Blogs_model->getBlogs($limit, $order, $date_min, $date_max, null, $this->Blogs_model->getUserId($this->encryption->decrypt($this->session->userdata('username'))));
            }
        }

        if ($blogs) {
            $data['blogs'] = true;
            
            $this->load->view('partials/header', $data);
            $this->load->view('blogs/options', $options_data);

            if ($search && $type == 'all') {
                $this->load->view('blogs/search');
            }

            foreach ($blogs as $blog) {
                if ($type == 'myblogs') {
                    $data['myblogs'] = true;
                }

                $data['blog_id'] = $blog->id;
                $data['blog_title'] = html_escape($blog->title);
                $data['blog_user'] = $this->Blogs_model->getUser($blog->user_id);
                $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                
                if ($type == 'all') {
                    $this->load->view('blogs/index', $data);
                } else {
                    $this->load->view('blogs/myblogs', $data);
                }
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('blogs/options', $options_data);

            if ($search && $type == 'all') {
                $this->load->view('blogs/search');
            }

            if ($type == 'all') {
                $this->load->view('blogs/index', $data);
            } else {
                $this->load->view('blogs/myblogs', $data);
            }
        }

        $this->load->view('partials/footer');
    }
}