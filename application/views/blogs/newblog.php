<div>
    <div>
        <?php
            if ( ! $this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('not_logged_in');
                echo ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login') . '">' . $this->lang->line('login_now') . '</a> ' . $this->lang->line('or') . ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register') . '">' . $this->lang->line('register') . '</a>.</p></div>';
            } else {
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
            <div class="card">
            <h3 class="card-header">
                <label for="title" class="col-12 col-sm-4 col-form-label form-label">
                <input type="text" class="form-control" id="blog_title" name="blog_title" placeholder="<?= $form_title; ?>" value="<?php if (isset($blog_title)) { echo $blog_title; } ?>"></label></h3>
                <div class="card-body">
                    <label for="body" class="col-sm-12 col-form-label form-label">
                    <textarea class="form-control" id="blog_body" name="blog_body" rows="10" cols="40" placeholder="<?= $form_body; ?>" style="resize: none;"><?php if (isset($blog_body)) { echo $blog_body; } ?></textarea></label>
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="col-5 col-sm-2 btn btn-primary" id="post"><?= $form_button; ?></button>
        <button type="reset" class="col-5 col-sm-2 btn btn-warning"><?= $form_reset; ?></button>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>