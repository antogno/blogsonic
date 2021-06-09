<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Blogs extends MY_Controller {
        public function __construct() {
            parent::__construct();
        }

        public function all($limit = 5, $order = 'desc', $date_min = NULL, $date_max = NULL) {
            $this->load->model('Blogs_model');
            $data = array(
                'blogs' => FALSE,
                'title' => $this->lang->line('blogs_title'),
                'blogs_title' => $this->lang->line('blogs_actual_title'),
                'user' => $this->lang->line('blogs_user'),
                'created_at' => $this->lang->line('blogs_created_at'),
                'view' => $this->lang->line('blogs_view')
            );
            if((is_numeric($limit) && $limit > 0 && $limit <= 20) && ($order == 'desc' || $order == 'asc')) {
                if(isset($date_min) && isset($date_max)) {
                    $date_min = date('Y-m-d H:i:s', strtotime($date_min));
                    $date_max = date('Y-m-d H:i:s', strtotime($date_max.' 23:59:59'));
                    $blogs = $this->Blogs_model->get_blog($limit, $order, $date_min, $date_max);
                } elseif(isset($date_min)) {
                    $date_min = date('Y-m-d H:i:s', strtotime($date_min));
                    $blogs = $this->Blogs_model->get_blog($limit, $order, $date_min, FALSE);
                } elseif(isset($date_max)) {
                    $date_max = date('Y-m-d H:i:s', strtotime($date_max.' 23:59:59'));
                    $blogs = $this->Blogs_model->get_blog($limit, $order, FALSE, $date_max);
                } else {
                    $blogs = $this->Blogs_model->get_blog($limit, $order, FALSE, FALSE);
                }
                if($blogs) {
                    $data['blogs'] = TRUE;
                    $this->load->view('partials/header', $data);
                    $this->load->view('blogs/options');
                    foreach($blogs as $blog) {
                        $data['blog_id'] = $blog->id;
                        $data['blog_title'] = $blog->title;
                        $data['blog_user'] = $this->Blogs_model->get_user($blog->user_id);
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
                redirect($this->session->userdata('language').'blogs/all', 'refresh');
            }
        }

        public function myblogs($limit = 5, $order = 'desc', $date_min = NULL, $date_max = NULL) {
            $this->load->model('Blogs_model');
            $data = array(
                'blogs' => FALSE,
                'myblogs' => FALSE,
                'title' => $this->lang->line('myblogs_title'),
                'blogs_title' => $this->lang->line('blogs_actual_title'),
                'user' => $this->lang->line('blogs_user'),
                'created_at' => $this->lang->line('blogs_created_at'),
                'view' => $this->lang->line('blogs_view')
            );
            if((is_numeric($limit) && $limit > 0 && $limit <= 20) && ($order == 'desc' || $order == 'asc')) {
                if(isset($date_min) && isset($date_max)) {
                    $date_min = date('Y-m-d H:i:s', strtotime($date_min));
                    $date_max = date('Y-m-d H:i:s', strtotime($date_max.' 23:59:59'));
                    $blogs = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), $order, $date_min, $date_max);
                } elseif(isset($date_min)) {
                    $date_min = date('Y-m-d H:i:s', strtotime($date_min));
                    $blogs = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), $order, $date_min, FALSE);
                } elseif(isset($date_max)) {
                    $date_max = date('Y-m-d H:i:s', strtotime($date_max.' 23:59:59'));
                    $blogs = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), $order, FALSE, $date_max);
                } else {
                    $blogs = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), $order, FALSE, FALSE);
                }
                if($blogs) {
                    $data['blogs'] = TRUE;
                    $this->load->view('partials/header', $data);
                    $this->load->view('blogs/options');
                    foreach($blogs as $key => $blog) {
                        $user = $this->Blogs_model->get_user($blog->user_id);
                        if((strtolower($user) == strtolower($this->session->userdata('username'))) && ($limit > 0)) {
                            $data['myblogs'] = TRUE;
                            $data['blog_id'] = $blog->id;
                            $data['blog_title'] = $blog->title;
                            $data['blog_user'] = $user;
                            $data['blog_created_at'] = date('d-m-Y H:i', strtotime($blog->created_at));
                            $this->load->view('blogs/myblogs', $data);
                            $limit--;
                        } elseif($key === array_key_last($blogs) && $data['myblogs'] === FALSE) {
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
                redirect($this->session->userdata('language').'blogs/myblogs', 'refresh');
            }
        }

        public function newblog() {
            $this->load->model('Blogs_model');
            $data = array(
                'title' => $this->lang->line('newblog_title'),
                'form_title' => $this->lang->line('newblog_actual_title'),
                'form_body' => $this->lang->line('newblog_body'),
                'form_button' => $this->lang->line('newblog_button'),
                'form_reset' => $this->lang->line('newblog_reset')
            );
            $this->form_validation->set_rules('title', $data['form_title'], 'ltrim|required|max_length[20]');
            $this->form_validation->set_rules('body', $data['form_body'], 'required');
            if($this->form_validation->run()) {
                $data = array(
                    'title' => $this->input->post('title'),
                    'body' => $this->input->post('body'),
                    'user_id' => $this->Blogs_model->get_user_id($this->session->userdata('username'))
                );
                $this->Blogs_model->insert_blog($data);
                redirect($this->session->userdata('language').'blogs/myblogs');
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('blogs/newblog', $data);
                $this->load->view('partials/footer');
            }
        }

        public function view() {
            $this->load->model('Blogs_model');
            $id = $this->uri->segment(4);
            if($id) {
                $blog = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), 'desc', FALSE, FALSE, $id);
                if($blog) {
                    $data = array(
                        'title' => $this->lang->line('view_title'),
                        'view_title' => $blog->title,
                        'user' => $this->lang->line('blogs_user'),
                        'created_at' => $this->lang->line('blogs_created_at'),
                        'body' => $this->lang->line('blogs_body'),
                        'id' => $blog->id,
                        'view_user' => $this->Blogs_model->get_user($blog->user_id),
                        'view_created_at' => date('d-m-Y H:i', strtotime($blog->created_at)),
                        'view_body' => $blog->body,
                        'delete' => $this->lang->line('view_delete'),
                        'edit' => $this->lang->line('view_edit')
                    );
                    $this->form_validation->set_rules('id', '', 'required');
                    if($this->form_validation->run()) {
                        $this->Blogs_model->delete_blog($data['id']);
                        redirect($this->session->userdata('language').'blogs/all');
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

        public function edit() {
            $this->load->model('Blogs_model');
            $id = $this->uri->segment(4);
            if($id) {
                $blog = $this->Blogs_model->get_blog($this->Blogs_model->blogs_number(), 'desc', FALSE, FALSE, $id);
                if($blog) {
                    $user = $this->Blogs_model->get_user($blog->user_id);
                    if((strtolower($user) == strtolower($this->session->userdata('username')))) {
                        $data = array(
                            'title' => $this->lang->line('edit_title'),
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
                        if($this->form_validation->run()) {
                            $data = array(
                                'id' => $id,
                                'title' => $this->input->post('title'),
                                'body' => $this->input->post('body')
                            );
                            $this->Blogs_model->update_blog($data);
                            redirect($this->session->userdata('language').'blogs/myblogs');
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
