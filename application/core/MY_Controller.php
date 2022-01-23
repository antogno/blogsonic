<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extension of the Application Controller Class
 * 
 * @author Antonio Granaldi <tonio.granaldi@gmail.com>
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->loadLanguage();
    }
    
    /**
     * Loads the website language based on the Profile settings (if logged-in), the URL or the browser main language
     *
     * @return void
     */
    public function loadLanguage()
    {
        $this->load->model('Profiles_model');

        if ($this->session->userdata('logged_in')) {
            $profile_language = $this->Profiles_model->getUser($this->encryption->decrypt($this->session->userdata('username')));
            $profile_language = $profile_language->language;

            if ($profile_language == 'it') {
                $language = 'italian';
            }
        } else {
            if ($this->uri->segment(1) == 'it') {
                $language = 'italian';
            } elseif ($this->uri->segment(1) == 'en') {
                $language = 'english';
            } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                $accept = ['en', 'it'];
                $browser_language = in_array($browser_language, $accept) ? $browser_language : 'en';
                if ($browser_language == 'it') {
                    $language = 'italian';
                }
            }
        }

        if ( ! isset($language)) {
            $language = 'english';
        }

        $uri_language = substr($language, 0, 2);

        $user_session = [
            'language' => $this->encryption->encrypt($uri_language . '/')
        ];

        $this->session->set_userdata($user_session);
        $this->config->set_item('language', $language);
        $this->lang->load('blogsonic', $language);
    }
    
    /**
     * Generates a new password
     *
     * @return string a random string.
     */
    public function newPassword()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.$!?@';
        $count = mb_strlen($chars);

        for ($i = 0, $password = ''; $i < 10; $i++) {
            $index = rand(0, $count - 1);
            $password .= mb_substr($chars, $index, 1);
        }

        return $password;
    }
    
    /**
     * Sends the given password to the given email address
     *
     * @param string $email the email address to send the new password to.
     * @param string $password the new password.
     * @return bool `true` on success, `false` on failure.
     */
    public function sendNewPassword(string $email, string $password)
    {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_port'] = '465';
        $config['smtp_host'] = ''; // SMTP host (e.g.: ssl://smtp.googlemail.com)
        $config['smtp_user'] = ''; // User (e.g.: example@gmail.com)
        $config['smtp_pass'] = ''; // Password
        $config['charset'] = 'iso-8859-1';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['validate'] = true; 

        $this->email->initialize($config);
        $this->email->from('', 'Blogsonic.org'); // Email (e.g.: example@gmail.com)
        $this->email->to($email);
        $this->email->subject($this->lang->line('forgot_password_email_subject'));

        $this->email->message(
            '<p>'.$this->lang->line('forgot_password_email_body') . '<strong>' . $password . '</strong></p>'
        );

        return $this->email->send();
    }
}