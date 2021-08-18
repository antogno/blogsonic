<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load_language();

    }

    public function load_language()
    {

        $this->load->model('Profiles_model');

        if ($this->session->userdata('logged_in')) {
            $profile_language = $this->Profiles_model->get_user($this->session->userdata('username'));
            $profile_language = $profile_language->language;

            if ($profile_language == 'en') {
                $this->session->set_userdata('language', $profile_language.'/');
                $language = 'english';
                $this->config->set_item('language', $language);
                $this->lang->load('blogsonic', $language);
            } elseif ($profile_language == 'it') {
                $this->session->set_userdata('language', $profile_language.'/');
                $language = 'italian';
                $this->config->set_item('language', $language);
                $this->lang->load('blogsonic', $language);
            }

        } else {
            $uri_language = $this->uri->segment(1);

            if ($uri_language == 'en') {
                $this->session->set_userdata('language', $uri_language.'/');
                $language = 'english';
                $this->config->set_item('language', $language);
                $this->lang->load('blogsonic', $language);
            } elseif ($uri_language == 'it') {
                $this->session->set_userdata('language', $uri_language.'/');
                $language = 'italian';
                $this->config->set_item('language', $language);
                $this->lang->load('blogsonic', $language);
            } else {
                
                $browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                $accept = ['en', 'it'];
                $browser_language = in_array($browser_language, $accept) ? $browser_language : 'en';

                if ($browser_language == 'it') {
                    $this->session->set_userdata('language', $browser_language.'/');
                    $language = 'italian';
                    $this->config->set_item('language', $language);
                    $this->lang->load('blogsonic', $language);
                } else {
                    $this->session->set_userdata('language', $uri_language.'/');
                    $language = 'english';
                    $this->config->set_item('language', $language);
                    $this->lang->load('blogsonic', $language);
                }

            }
        }

    }

    public function new_password()
    {

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.$!?@';
        $count = mb_strlen($chars);

        for ($i = 0, $password = ''; $i < 10; $i++) {
            $index = rand(0, $count - 1);
            $password .= mb_substr($chars, $index, 1);
        }

        return $password;

    }

    public function send_new_password($email, $password)
    {

        $this->load->library('email');

        $config['protocol']    = 'smtp';
        $config['smtp_port']    = '465';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_user'] = ''; // username@gmail.com
        $config['smtp_pass'] = ''; // password
        $config['charset'] = 'iso-8859-1';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['validate'] = TRUE; 

        $this->email->initialize($config);
        $this->email->from('', 'Blogsonic.org'); // username@gmail.com
        $this->email->to($email);
        $this->email->subject($this->lang->line('forgot_password_email_subject'));

        $this->email->message(
            '<p>'.$this->lang->line('forgot_password_email_body').'<strong>'.$password.'</strong></p>'
        );

        $this->email->send();

    }

}
