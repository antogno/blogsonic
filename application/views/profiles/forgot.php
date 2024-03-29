<div>
    <div>
        <?php
            if ($this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('logged_in') . '</p></div>';
            } else {
                if ($this->session->userdata('forgot_password_success')) {
        ?>
        <div class="alert alert-dismissible alert-success" id="success_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('forgot_password_success') . '</p>' ?>
        </div>
        <?php
                } elseif ($this->session->userdata('forgot_password_fail')) {
        ?>
        <div class="alert alert-dismissible alert-danger" id="danger_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('forgot_password_fail') . ' <a href="mailto:' . $_ENV['BLOGSONIC_IN_EMAIL'] . '">' . $_ENV['BLOGSONIC_IN_EMAIL'] . '</a>.</p>' ?>
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
                <label for="email" class="col-12 col-sm-4 col-form-label"><strong><?= $form_email; ?></strong>:
                <input type="text" class="form-control" id="email" name="email">
                <small class="form-text text-muted"><?= $form_text; ?></small></label><br>
            <!-- </div> -->
        </div>
        <br>
        <button type="submit" class="col-5 col-sm-2 btn btn-primary" id="confirm"><?= $form_button; ?></button>
        <a class="btn btn-link" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login'); ?>">&laquo; <?= $this->lang->line('back');?></a>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>