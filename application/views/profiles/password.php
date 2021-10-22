<div>
    <div>
        <?php
            if ( ! $this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('not_logged_in');
                echo ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login') . '">' . $this->lang->line('login_now') . '</a> ' . $this->lang->line('or') . ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register') . '">' . $this->lang->line('register_now') . '</a>.</p></div>';
            } else {
                if ($this->session->userdata('password_changed')) {
        ?>
        <div class="alert alert-dismissible alert-success" id="success_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('password_changed') . '</p>' ?>
        </div>
        <?php
                } elseif ($this->session->userdata('password_not_changed')) {
        ?>
        <div class="alert alert-dismissible alert-danger" id="danger_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('password_not_changed') . '</p>' ?>
        </div>
        <?php
            }
        ?>
        <?= form_open(); ?>
        <?php
            if (validation_errors()) {
        ?>
        <div class="alert alert-dismissible alert-warning" id="warning_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= validation_errors(); ?>
        </div>
        <?php
            }
        ?>
        <div class="form-group">
            <!-- <div class="col-md-3"> -->
                <label for="old_password" class="col-sm-4 col-form-label"><strong><?= $form_old_password; ?></strong>:
                    <span class="input-group">
                        <input type="password" class="form-control" id="old_password" name="old_password">
                        <button class="btn btn-primary" type="button" id="old_password_button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </span>
                </label>
                <br>
                <label for="new_password" class="col-sm-4 col-form-label"><strong><?= $form_new_password; ?></strong>:
                    <span class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <button class="btn btn-primary" type="button" id="new_password_button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </span>
                </label>
            <!-- </div> -->
        </div>
        <br>
        <button onclick="return confirmation()" type="submit"  class="col-sm-2 btn btn-primary" id="save_changes"><?= $form_button; ?></button>
        <a class="btn btn-link" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles'); ?>">&laquo; <?= $this->lang->line('back');?></a>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>