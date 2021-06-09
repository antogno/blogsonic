    <div>
        <?php
            if(!$this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>'.$this->lang->line('not_logged_in');
                echo ' <a href="'.base_url($this->session->userdata('language').'profiles/login').'">'.$this->lang->line('login_now').'</a> '.$this->lang->line('or').' <a href="'.base_url($this->session->userdata('language').'profiles/register').'">'.$this->lang->line('register_now').'</a>.</p></div>';
            } else {
                $this->session->sess_destroy();
                redirect($this->session->userdata('language'));
            }
        ?>
    </div>