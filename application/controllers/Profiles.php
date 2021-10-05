<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profiles Controller Class
 * 
 * @author  Antonio Granaldi
 */
class Profiles extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

    }
    
    /**
     * Shows the main Profile page
     *
     * @return  void
     */
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
            $data['username'] = $this->encryption->decrypt($this->session->userdata('username'));
            $profile = $this->Profiles_model->getUser($data['username']);
            $data['username'] = $this->lang->line('profile_username');
            $data['profile_name'] = $profile->name;
            $data['profile_surname'] = $profile->surname;
            $data['profile_username'] = $profile->username;

            if ($profile->gender === 'm') {
                $data['profile_gender'] = $this->lang->line('profile_gender_m');
            } elseif ($profile->gender === 'f') {
                $data['profile_gender'] = $this->lang->line('profile_gender_f');
            } else {
                $data['profile_gender'] = false;
            }

            $data['profile_email'] = $profile->email;
            $data['profile_phone'] = isset($profile->phone) ? $profile->phone : false;

            if ($profile->language === 'en') {
                $data['profile_language'] = $this->lang->line('profile_language_en');
            } else {
                $data['profile_language'] = $this->lang->line('profile_language_it');
            }

            $data['profile_created_at'] = date("d-m-Y H:i", strtotime($profile->created_at));
            $data['id'] = $profile->id;
            $data['title'] = $this->lang->line('profile_title');
            $data['meta_title'] = $this->lang->line('profile_meta_title');
            $data['meta_description'] = $this->lang->line('profile_meta_description');

            $this->form_validation->set_rules('id', '', 'required');

            if ($this->form_validation->run()) {
                $this->session->sess_destroy();
                $this->Profiles_model->deleteUser($profile->username);

                redirect($this->encryption->decrypt($this->session->userdata('language')));
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
    
    /**
     * Shows the login page
     *
     * @return  void
     */
    public function login()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('login_title'),
            'meta_title' => $this->lang->line('login_meta_title'),
            'meta_description' => $this->lang->line('login_meta_description'),
            'form_username' => $this->lang->line('login_form_username'),
            'form_password' => $this->lang->line('login_form_password'),
            'form_button' => $this->lang->line('login_form_button')
        );

        $this->form_validation->set_rules('username', $data['form_username'], 'required|min_length[6]|max_length[50]|alpha_dash');
        $this->form_validation->set_rules('password', $data['form_password'], 'required|min_length[8]|max_length[50]');

        if ($this->form_validation->run()) {
            if ($this->session->userdata('logged_in')) {
                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login', 'refresh');
            } else {
                if ($this->Profiles_model->login($this->input->post())) {

                    $user_session = array(
                        'logged_in' => true,
                        'logged_in_fail' => false,
                        'username' => $this->encryption->encrypt($this->input->post('username')),
                        'email' => $this->encryption->encrypt($this->Profiles_model->getUser($this->input->post('username'))->email),
                        'phone' => $this->encryption->encrypt($this->Profiles_model->getUser($this->input->post('username'))->phone),
                        'language' => $this->encryption->encrypt($this->Profiles_model->getUser($this->input->post('username'))->language . '/')
                    );
                    $this->session->set_userdata($user_session);

                    redirect($this->encryption->decrypt($this->encryption->decrypt($this->session->userdata('language'))) . 'profiles');
                } else {

                    $user_session = array(
                        'logged_in' => false,
                        'logged_in_fail' => true
                    );
                    $this->session->set_userdata($user_session);

                    redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login', 'refresh');
                }
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/login', $data);
            $this->load->view('partials/footer');
        }

    }
    
    /**
     * Logs out from the current logged-in Profile
     *
     * @return  void
     */
    public function logout()
    {

        $data['title'] = $this->lang->line('logout_title');
        $data['meta_title'] = $this->lang->line('logout_meta_title');
        $data['meta_description'] = $this->lang->line('logout_meta_description');

        $this->load->view('partials/header', $data);
        $this->load->view('profiles/logout');
        $this->load->view('partials/footer');

    }
    
    /**
     * Shows the register page
     *
     * @return  void
     */
    public function register()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('register_title'),
            'meta_title' => $this->lang->line('register_meta_title'),
            'meta_description' => $this->lang->line('register_meta_description'),
            'form_name' => $this->lang->line('register_form_name'),
            'form_surname' => $this->lang->line('register_form_surname'),
            'form_gender' => $this->lang->line('register_form_gender'),
            'form_gender_m' => $this->lang->line('register_form_gender_m'),
            'form_gender_f' => $this->lang->line('register_form_gender_f'),
            'form_no_gender' => $this->lang->line('register_form_no_gender'),
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
        $this->form_validation->set_rules('gender', $data['form_gender'], 'max_length[1]');
        $this->form_validation->set_rules('username', $data['form_username'], 'required|min_length[6]|max_length[50]|alpha_dash|is_unique[users.username]');
        $this->form_validation->set_rules('password', $data['form_password'], 'trim|required|min_length[8]|max_length[50]');
        $this->form_validation->set_rules('email', $data['form_email'], 'required|max_length[50]|is_unique[users.email]|valid_email');
        $this->form_validation->set_rules('phone', $data['form_phone'], 'exact_length[10]|integer|is_unique[users.phone]');
        $this->form_validation->set_rules('language', $data['form_language'], 'required|max_length[2]');

        if ($this->form_validation->run()) {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->Profiles_model->register($this->input->post(), $password);

            $user_session = array(
                'registered' => true
            );
            $this->session->set_userdata($user_session);

            redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register', 'refresh');
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/register', array_merge($data, $this->input->post()));
            $this->load->view('partials/footer');
        }

    }
    
    /**
     * Shows the edit page for the logged-in Profile
     *
     * @return  void
     */
    public function edit()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'name' => $this->lang->line('profile_name'),
            'surname' => $this->lang->line('profile_surname'),
            'gender' => $this->lang->line('profile_gender'),
            'username' => $this->lang->line('profile_username'),
            'email' => $this->lang->line('profile_email'),
            'phone' => $this->lang->line('profile_phone'),
            'language' => $this->lang->line('profile_language'),
            'button' => $this->lang->line('edit_profile_button')
        );

        if ($this->session->userdata('logged_in')) {
            $this->form_validation->set_rules('name', $data['name'], 'ltrim|required|max_length[50]');
            $this->form_validation->set_rules('surname', $data['surname'], 'ltrim|required|max_length[50]');
            $this->form_validation->set_rules('gender', $data['gender'], 'max_length[1]');
            $this->form_validation->set_rules('username', $data['username'], 'required|min_length[6]|max_length[50]|alpha_dash');
            $this->form_validation->set_rules('email', $data['email'], 'required|max_length[50]|valid_email');
            $this->form_validation->set_rules('phone', $data['phone'], 'exact_length[10]|integer');
            $this->form_validation->set_rules('language', $data['language'], 'required|max_length[2]');

            if ($this->form_validation->run()) {
                $this->Profiles_model->updateUser($this->encryption->decrypt($this->session->userdata('username')), $this->input->post());
                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles');
            } else {
                $data['username'] = $this->encryption->decrypt($this->session->userdata('username'));
                $profile = $this->Profiles_model->getUser($data['username']);
                $data['username'] = $this->lang->line('profile_username');
                $data['profile_name'] = $profile->name;
                $data['profile_surname'] = $profile->surname;
                $data['profile_username'] = $profile->username;

                if ($profile->gender === 'm') {
                    $data['profile_gender'] = $this->lang->line('profile_gender_m');
                } elseif ($profile->gender === 'f') {
                    $data['profile_gender'] = $this->lang->line('profile_gender_f');
                } else {
                    $data['profile_gender'] = false;
                }

                $data['profile_email'] = $profile->email;
                $data['profile_phone'] = $profile->phone;

                if ($profile->language === 'en') {
                    $data['profile_language'] = $this->lang->line('profile_language_en');
                } else {
                    $data['profile_language'] = $this->lang->line('profile_language_it');
                }

                $data['title'] = $this->lang->line('edit_profile_title');
                $data['meta_title'] = $this->lang->line('edit_profile_meta_title');
                $data['meta_description'] = $this->lang->line('edit_profile_meta_description');

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
    
    /**
     * Shows the change password page
     *
     * @return  void
     */
    public function password()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('password_title'),
            'meta_title' => $this->lang->line('password_meta_title'),
            'meta_description' => $this->lang->line('password_meta_description'),
            'form_old_password' => $this->lang->line('password_form_old_password'),
            'form_new_password' => $this->lang->line('password_form_new_password'),
            'form_button' => $this->lang->line('password_form_button')
        );

        $this->form_validation->set_rules('old_password', $data['form_old_password'], 'required');
        $this->form_validation->set_rules('new_password', $data['form_new_password'], 'trim|required|min_length[8]|max_length[50]|differs[old_password]');

        if ($this->form_validation->run()) {
            $user = $this->Profiles_model->getUser($this->encryption->decrypt($this->session->userdata('username')));
            if (password_verify($this->input->post('old_password'), $user->password)) {
                $data = array('password' => $this->input->post('new_password'));
                $this->Profiles_model->updateUser($this->encryption->decrypt($this->session->userdata('username')), $data);

                $user_session = array(
                    'password_changed' => true,
                    'password_not_changed' => false
                );
                $this->session->set_userdata($user_session);

                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/password', 'refresh');
            } else {

                $user_session = array(
                    'password_changed' => false,
                    'password_not_changed' => true
                );
                $this->session->set_userdata($user_session);

                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/password', 'refresh');
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/password', $data);
            $this->load->view('partials/footer');
        }

    }
    
    /**
     * Shows the forgot password page
     *
     * @return  void
     */
    public function forgot()
    {

        $this->load->model('Profiles_model');

        $data = array(
            'title' => $this->lang->line('forgot_password'),
            'meta_title' => $this->lang->line('forgot_meta_title'),
            'meta_description' => $this->lang->line('forgot_meta_description'),
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

                $user_session = array(
                    'forgot_password_success' => true,
                    'forgot_password_fail' => false
                );
                $this->session->set_userdata($user_session);

                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/forgot', 'refresh');
            } else {

                $user_session = array(
                    'forgot_password_success' => false,
                    'forgot_password_fail' => true
                );
                $this->session->set_userdata($user_session);

                redirect($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/forgot', 'refresh');
            }
        } else {
            $this->load->view('partials/header', $data);
            $this->load->view('profiles/forgot', $data);
            $this->load->view('partials/footer');
        }

    }

    /**
     * Checks if a username is valid or not. It's used for the AJAX request in the registration form
     *
     * @return  void
     */
    public function checkUsername()
    {

        $this->load->model('Profiles_model');

        $username = $this->input->post('value');
        $username_field = $this->Profiles_model->checkUsersByField('username', $username);

        if ($username) {
            if ((( ! $username_field) || ($username_field == $this->encryption->decrypt($this->session->userdata('username')) && ($this->router->fetch_class() == 'profiles' && $this->input->post('method') == 'edit'))) &&
                (strlen($username) >= 6 && strlen($username) <= 50) &&
                (preg_match('/^[a-z0-9_-]+$/i', $username))) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            return false;
        }

    }

    /**
     * Checks if an email is valid or not. It's used for the AJAX request in the registration form
     *
     * @return  void
     */
    public function checkEmail()
    {

        $this->load->model('Profiles_model');

        $email = $this->input->post('value');
        $email_field = $this->Profiles_model->checkUsersByField('email', $email);

        if ($email) {
            if ((( ! $email_field) || ($email_field == $this->encryption->decrypt($this->session->userdata('email')) && ($this->router->fetch_class() == 'profiles' && $this->input->post('method') == 'edit'))) &&
                (strlen($email) <= 50) &&
                ((bool)filter_var($email, FILTER_VALIDATE_EMAIL))) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            return false;
        }

    }

    /**
     * Checks if a phone number is valid or not. It's used for the AJAX request in the registration form
     *
     * @return  void
     */
    public function checkPhone()
    {

        $this->load->model('Profiles_model');

        $phone = $this->input->post('value');
        $phone_field = $this->Profiles_model->checkUsersByField('phone', $phone);

        if ($phone) {
            if ((( ! $phone_field) || ($phone_field == $this->encryption->decrypt($this->session->userdata('phone')) && ($this->router->fetch_class() == 'profiles' && $this->input->post('method') == 'edit'))) &&
                (strlen($phone) == 10) &&
                (ctype_digit($phone))) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            return false;
        }

    }

}
