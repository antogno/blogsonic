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
        <div class="alert alert-dismissible alert-secondary" style="margin-top: 16px">
            <?= $this->lang->line('mandatory_fields'); ?>
        </div>
        <div class="form-group">
            <!-- <div class="col-md-3"> -->
                <label for="name" class="col-sm-4 col-form-label"><strong><?= $name; ?></strong>*:
                <input type="text" class="form-control" id="name" name="name" placeholder="<?= $this->lang->line('register_placeholder_name'); ?>" value="<?= $profile_name; ?>"></label>
                <label for="surname" class="col-sm-4 col-form-label"><strong><?= $surname; ?></strong>*:
                <input type="text" class="form-control" id="surname" name="surname" placeholder="<?= $this->lang->line('register_placeholder_surname'); ?>" value="<?= $profile_surname; ?>"></label><br>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $gender; ?></strong>:
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender_m" name="gender" value="m" <?php if ($profile_gender == $this->lang->line('gender_m')) { echo 'checked'; } ?>>
                                <?= $this->lang->line('gender_m'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender_f" name="gender" value="f" <?php if ($profile_gender == $this->lang->line('gender_f')) { echo 'checked'; } ?>>
                                <?= $this->lang->line('gender_f'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="no_gender" name="gender" value="" <?php if ( ! $profile_gender) { echo 'checked'; } ?>>
                                <i><?= $this->lang->line('register_form_no_gender'); ?></i>
                            </label>
                        </div>
                    </label>
                </fieldset>
                <label for="username" class="col-sm-4 col-form-label"><strong><?= $username; ?></strong>*:
                <input type="text" class="form-control" id="username" name="username" placeholder="<?= $this->lang->line('register_placeholder_username'); ?>" value="<?= $profile_username; ?>"></label>
                <label for="email" class="col-sm-4 col-form-label"><strong><?= $email; ?></strong>*:
                <input type="text" class="form-control" id="email" name="email" placeholder="<?= $this->lang->line('register_placeholder_email'); ?>" value="<?= $profile_email; ?>"></label><br>
                <label for="phone" class="col-sm-4 col-form-label"><strong><?= $phone; ?></strong>:
                <input type="text" class="form-control" id="phone" name="phone" placeholder="<?= $this->lang->line('register_placeholder_phone'); ?>" value="<?= $profile_phone; ?>"></label>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $language; ?></strong>*:
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language_en" name="language" value="en" checked>
                                <?= $this->lang->line('english'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language_it" name="language" value="it">
                                <?= $this->lang->line('italian'); ?>
                            </label>
                        </div>
                    </label>
                </fieldset>
            <!-- </div> -->
        </div>
        <br>
        <button onclick="return confirmation()" class="col-sm-2 btn btn-primary" id="save_changes"><?= $button; ?></button>
        <a class="btn btn-link" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles'); ?>">&laquo; <?= $this->lang->line('back');?></a>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>