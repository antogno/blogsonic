<div>
    <div>
        <?php
            if ($this->session->userdata('registered')) {
        ?>
        <div class="alert alert-dismissible alert-success" id="success_popup">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= '<p><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;' . $this->lang->line('registered'); ?>
            <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login'); ?>" class="alert-link"><?= ' ' . $this->lang->line('registered_link') . '</a>.</p>'; ?>
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
        <div class="alert alert-dismissible alert-secondary" style="margin-top: 16px">
            <?= $this->lang->line('mandatory_fields'); ?>
        </div>
        <div class="form-group">
            <!-- <div class="col-md-3"> -->
                <label for="name" class="col-12 col-sm-4 col-form-label"><strong><?= $form_name; ?></strong>*:
                <input type="text" class="form-control" id="name" name="name" placeholder="<?= $this->lang->line('register_placeholder_name'); ?>" value="<?php if (isset($name)) { echo $name; } ?>"></label>
                <label for="surname" class="col-12 col-sm-4 col-form-label"><strong><?= $form_surname; ?></strong>*:
                <input type="text" class="form-control" id="surname" name="surname" placeholder="<?= $this->lang->line('register_placeholder_surname'); ?>" value="<?php if (isset($surname)) { echo $surname; } ?>"></label><br>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $form_gender; ?></strong>:
                        <div class="form-check"> 
                            <label for="gender_m" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender_m" name="gender" value="m" <?php if (isset($gender) && $gender == 'm') { echo 'checked'; }?>>
                                <?= $form_gender_m; ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="gender_f" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender_f" name="gender" value="f" <?php if (isset($gender) && $gender == 'f') { echo 'checked'; }?>>
                                <?= $form_gender_f; ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="no_gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="no_gender" name="gender" value="" <?php if (( ! isset($gender)) || (isset($gender) && $gender == '')) { echo 'checked'; }?>>
                                <i><?= $form_no_gender; ?></i>
                            </label>
                        </div>
                    </label>
                </fieldset>
                <label for="username" class="col-12 col-sm-4 col-form-label"><strong><?= $form_username; ?></strong>*:
                    <input type="text" class="form-control" id="username" name="username" placeholder="<?= $this->lang->line('register_placeholder_username'); ?>" value="<?php if (isset($username)) { echo $username; } ?>">
                </label>
                <label for="password" class="col-12 col-sm-4 col-form-label"><strong><?= $form_password; ?></strong>*:
                    <span class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="<?= $this->lang->line('password'); ?>">
                        <button class="btn btn-primary" type="button" id="password_button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </span>
                </label>
                <br>
                <label for="email" class="col-12 col-sm-4 col-form-label"><strong><?= $form_email; ?></strong>*:
                    <input type="text" class="form-control" id="email" name="email" placeholder="<?= $this->lang->line('register_placeholder_email'); ?>" value="<?php if (isset($email)) { echo $email; } ?>">
                </label>
                <label for="phone" class="col-12 col-sm-4 col-form-label"><strong><?= $form_phone; ?></strong>:
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?= $this->lang->line('register_placeholder_phone'); ?>" value="<?php if (isset($phone)) { echo $phone; } ?>">
                </label>
                <br>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $form_language; ?></strong>*:
                        <div class="form-check"> 
                            <label for="language_en" class="form-check-label">
                                <?php if ( ! isset($language)) { $language = substr($this->encryption->decrypt($this->session->userdata('language')), 0, -1); } ?>
                                <input type="radio" class="form-check-input" id="language_en" name="language" value="en" <?php if ($language == 'en') { echo 'checked'; }?>>
                                <?= $form_language_en; ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="language_it" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language_it" name="language" value="it" <?php if ($language == 'it') { echo 'checked'; }?>>
                                <?= $form_language_it; ?>
                            </label>
                        </div>
                    </label>
                </fieldset>
            <!-- </div> -->
        </div>
        <br>
        <button type="submit" class="col-5 col-sm-2 btn btn-primary" id="register"><?= $form_button; ?></button>
        <button type="reset" class="col-5 col-sm-2 btn btn-warning" id="reset"><?= $form_reset; ?></button>
        <?= form_close(); ?>
    </div>
</div>