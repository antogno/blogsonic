<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'name' => $this->lang->line('profile_name'),
            'surname' => $this->lang->line('profile_surname'),
            'gender' => $this->lang->line('profile_gender'),
            'email' => $this->lang->line('profile_email'),
            'phone' => $this->lang->line('profile_phone'),
            'language' => $this->lang->line('profile_language'),
            'created_at' => $this->lang->line('profile_created_at'),
            'delete' => $this->lang->line('profile_delete')
        );

        if ($this->session->userdata('logged_in')) {
            $data['username'] = $this->session->userdata('username');
            $profile = $this->Profiles_model->getUser($data['username']);
            $data['username'] = $this->lang->line('profile_username');
            $data['profile_name'] = $profile->name;
            $data['profile_surname'] = $profile->surname;
            $data['profile_username'] = $profile->username;

            if ($profile->gender === 'm') {
                $data['profile_gender'] = $this->lang->line('profile_gender_m');
            } else {
                $data['profile_gender'] = $this->lang->line('profile_gender_f');
            }

            $data['profile_email'] = $profile->email;
            $data['profile_phone'] = $profile->phone;

            if ($profile->language === 'en') {
                $data['profile_language'] = $this->lang->line('profile_language_en');
            } else {
                $data['profile_language'] = $this->lang->line('profile_language_it');
            }

            $data['profile_created_at'] = date("d-m-Y H:i", strtotime($profile->created_at));
            $data['id'] = $profile->id;
            $data['title'] = $this->lang->line('profile_title');

            $this->form_validation->set_rules('id', '', 'required');

            if ($this->form_validation->run()) {
                $this->session->sess_destroy();
                $this->Profiles_model->deleteUser($profile->username);

                redirect($this->session->userdata('language'));
            } else {
                $this->load->view('partials/header', $data);
                $this->load->view('profiles/index', $data);
                $this->load->view('partials/footer');
            }
        } else {
            $data['title'] = $this->lang->line('profile_title');

            $this->load->view('partials/header', $data);
            $this->load->view('profiles/index', $data);
            $this->load->view('partials/footer');
        }

    }

    public function login()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('login_title'),
            'form_username' => $this->lang->line('login_form_username'),
            'form_password' => $this->lang->line('login_form_password'),
            'form_button' => $this->lang->line('login_form_button')
        );

        $this->form_validation->set_rules('username', $data['form_username'], 'required|min_length[6]|max_length[50]|alpha_dash');
        $this->form_validation->set_rules('password', $data['form_password'], 'required|min_length[8]|max_length[50]');

        if ($this->form_validation->run()) {
            if ($this->session->userdata('logged_in')) {
                redirect($this->session->userdata('language') . 'profiles/login', 'refresh');
            } else {
                if ($this->Profiles_model->login($this->input->post())) {
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('logged_in_fail', FALSE);
                    $username = $this->input->post('username');
                    $this->session->set_userdata('username', $username);
                    $language = $this->Profiles_model->getUser($username);
                    $this->session->set_userdata('language', $language->language . '/');

                    redirect($this->session->userdata('language') . 'profiles');
                } else {
                    $this->session->set_userdata('logged_in', FALSE);
                    $this->session->set_userdata('logged_in_fail', TRUE);

                    redirect($this->session->userdata('language') . 'profiles/login', 'refresh');
                }
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/login', $data);
            $this->load->view('partials/footer');
        }

    }

    public function logout()
    {

        $data['title'] = $this->lang->line('logout_title');

        $this->load->view('partials/header', $data);
        $this->load->view('profiles/logout');
        $this->load->view('partials/footer');

    }

    public function register()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('register_title'),
            'form_name' => $this->lang->line('register_form_name'),
            'form_surname' => $this->lang->line('register_form_surname'),
            'form_gender' => $this->lang->line('register_form_gender'),
            'form_gender_m' => $this->lang->line('register_form_gender_m'),
            'form_gender_f' => $this->lang->line('register_form_gender_f'),
            'form_username' => $this->lang->line('register_form_username'),
            'form_password' => $this->lang->line('register_form_password'),
            'form_email' => $this->lang->line('register_form_email'),
            'form_phone' => $this->lang->line('register_form_phone'),
            'form_language' => $this->lang->line('register_form_language'),
            'form_language_en' => $this->lang->line('register_form_language_en'),
            'form_language_it' => $this->lang->line('register_form_language_it'),
            'form_button' => $this->lang->line('register_form_button'),
            'form_reset' => $this->lang->line('register_form_reset')
        );

        $this->form_validation->set_rules('name', $data['form_name'], 'ltrim|required|max_length[50]');
        $this->form_validation->set_rules('surname', $data['form_surname'], 'ltrim|required|max_length[50]');
        $this->form_validation->set_rules('gender', $data['form_gender'], 'required|max_length[1]');
        $this->form_validation->set_rules('username', $data['form_username'], 'required|min_length[6]|max_length[50]|alpha_dash|is_unique[users.username]');
        $this->form_validation->set_rules('password', $data['form_password'], 'trim|required|min_length[8]|max_length[50]');
        $this->form_validation->set_rules('email', $data['form_email'], 'required|max_length[50]|is_unique[users.email]|valid_email');
        $this->form_validation->set_rules('phone', $data['form_phone'], 'required|min_length[10]|max_length[13]|integer|is_unique[users.phone]');
        $this->form_validation->set_rules('language', $data['form_language'], 'required|max_length[2]');

        if ($this->form_validation->run()) {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->Profiles_model->register($this->input->post(), $password);
            $this->session->set_userdata('registered', TRUE);

            redirect($this->session->userdata('language') . 'profiles/register', 'refresh');
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/register', $data);
            $this->load->view('partials/footer');
        }

    }

    public function edit()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'name' => $this->lang->line('profile_name'),
            'surname' => $this->lang->line('profile_surname'),
            'gender' => $this->lang->line('profile_gender'),
            'email' => $this->lang->line('profile_email'),
            'phone' => $this->lang->line('profile_phone'),
            'language' => $this->lang->line('profile_language'),
            'button' => $this->lang->line('edit_profile_button')
        );

        if ($this->session->userdata('logged_in')) {
            $this->form_validation->set_rules('name', $data['name'], 'ltrim|required|max_length[50]');
            $this->form_validation->set_rules('surname', $data['surname'], 'ltrim|required|max_length[50]');
            $this->form_validation->set_rules('gender', $data['gender'], 'required|max_length[1]');
            $this->form_validation->set_rules('language', $data['language'], 'required|max_length[2]');

            if ($this->form_validation->run()) {
                $this->Profiles_model->updateUser($this->session->userdata('username'), $this->input->post());
                redirect($this->session->userdata('language') . 'profiles');
            } else {
                $data['username'] = $this->session->userdata('username');
                $profile = $this->Profiles_model->getUser($data['username']);
                $data['username'] = $this->lang->line('profile_username');
                $data['profile_name'] = $profile->name;
                $data['profile_surname'] = $profile->surname;
                $data['profile_username'] = $profile->username;

                if ($profile->gender === 'm') {
                    $data['profile_gender'] = $this->lang->line('profile_gender_m');
                } else {
                    $data['profile_gender'] = $this->lang->line('profile_gender_f');
                }

                $data['profile_email'] = $profile->email;
                $data['profile_phone'] = $profile->phone;

                if ($profile->language === 'en') {
                    $data['profile_language'] = $this->lang->line('profile_language_en');
                } else {
                    $data['profile_language'] = $this->lang->line('profile_language_it');
                }

                $data['title'] = $this->lang->line('edit_profile_title');

                $this->load->view('partials/header', $data);
                $this->load->view('profiles/edit', $data);
                $this->load->view('partials/footer');
            }
        } else {
            $data['title'] = $this->lang->line('edit_profile_title');
            
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/edit', $data);
            $this->load->view('partials/footer');
        }

    }

    public function password()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('password_title'),
            'form_old_password' => $this->lang->line('password_form_old_password'),
            'form_new_password' => $this->lang->line('password_form_new_password'),
            'form_button' => $this->lang->line('password_form_button')
        );

        $this->form_validation->set_rules('old_password', $data['form_old_password'], 'required');
        $this->form_validation->set_rules('new_password', $data['form_new_password'], 'trim|required|min_length[8]|max_length[50]|differs[old_password]');

        if ($this->form_validation->run()) {
            $user = $this->Profiles_model->getUser($this->session->userdata('username'));
            if (password_verify($this->input->post('old_password'), $user->password)) {
                $data = array('password' => $this->input->post('new_password'));
                $this->Profiles_model->updateUser($this->session->userdata('username'), $data);
                $this->session->set_userdata('password_changed', TRUE);
                $this->session->set_userdata('password_not_changed', FALSE);

                redirect($this->session->userdata('language') . 'profiles/password', 'refresh');
            } else {
                $this->session->set_userdata('password_changed', FALSE);
                $this->session->set_userdata('password_not_changed', TRUE);

                redirect($this->session->userdata('language') . 'profiles/password', 'refresh');
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/password', $data);
            $this->load->view('partials/footer');
        }

    }

    public function forgot()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('forgot_password'),
            'form_email' => $this->lang->line('forgot_password_email'),
            'form_button' => $this->lang->line('forgot_password_confirm'),
            'form_text' => $this->lang->line('forgot_password_text')
        );

        $this->form_validation->set_rules('email', $data['form_email'], 'required|max_length[50]|valid_email');

        if ($this->form_validation->run()) {
            $profile = $this->Profiles_model->getUserByEmail($this->input->post('email'));
            if ($profile) {
                $email = $this->input->post('email');
                $password = $this->newPassword();
                $this->Profiles_model->newPassword($email, $password);
                $this->sendNewPassword($email, $password);
                $this->session->set_userdata('forgot_password_success', TRUE);
                $this->session->set_userdata('forgot_password_fail', FALSE);

                redirect($this->session->userdata('language') . 'profiles/forgot', 'refresh');
            } else {
                $this->session->set_userdata('forgot_password_success', FALSE);
                $this->session->set_userdata('forgot_password_fail', TRUE);

                redirect($this->session->userdata('language') . 'profiles/forgot', 'refresh');
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/forgot', $data);
            $this->load->view('partials/footer');
        }

    }

}
