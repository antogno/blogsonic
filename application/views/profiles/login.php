<div>
    <div>
        <?php
            if ($this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('logged_in') . '</p></div>';
            } elseif ($this->session->userdata('logged_in_fail') || ! $this->session->userdata('logged_in')) {
                if ($this->session->userdata('logged_in_fail')) {
        ?>
        <div class="alert alert-dismissible alert-danger" id="danger_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('logged_in_fail') . '</p>'; ?>
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
                <label for="username" class="col-12 col-sm-4 col-form-label"><strong><?= $form_username; ?></strong>:
                    <input type="text" class="form-control" id="username" name="username">
                </label>
                <br>
                <label for="password" class="col-12 col-sm-4 col-form-label"><strong><?= $form_password; ?></strong>:
                    <span class="input-group">
                        <input type="password" class="form-control" id="password" name="password">
                        <button class="btn btn-primary" type="button" id="password_button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </span>
                </label>
            <!-- </div> -->
        </div>
        <br>
        <button type="submit" class="col-5 col-sm-2 btn btn-primary" id="login"><?= $form_button; ?></button>
        <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/forgot'); ?>" class="col-6 col-sm-2 btn btn-link"><?= $this->lang->line('forgot_password'); ?>?</a>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>