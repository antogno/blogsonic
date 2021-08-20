<div>
    <div>
        <?php
            if ( ! $this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('not_logged_in');
                echo ' <a href="' . base_url($this->session->userdata('language') . 'profiles/login') . '">' . $this->lang->line('login_now') . '</a> ' . $this->lang->line('or') . ' <a href="' . base_url($this->session->userdata('language') . 'profiles/register') . '">' . $this->lang->line('register_now') . '</a>.</p></div>';
            } else {
        ?>
        <?= form_open(); ?>
        <?php
            if (validation_errors()) {
        ?>
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= validation_errors(); ?>
        </div>
        <?php
            }
        ?>
        <div class="form-group">
            <!-- <div class="col-md-3"> -->
                <label for="name" class="col-sm-4 col-form-label"><strong><?= $name; ?></strong>:
                <input type="text" class="form-control" id="name" name="name" value="<?= $profile_name; ?>"></label>
                <label for="surname" class="col-sm-4 col-form-label"><strong><?= $surname; ?></strong>:
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $profile_surname; ?>"></label><br>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $gender; ?></strong>:
                        <?php
                            if ($profile_gender === $this->lang->line('profile_gender_m')) {
                        ?>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="m" checked>
                                <?= $this->lang->line('profile_gender_m'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="f">
                                <?= $this->lang->line('profile_gender_f'); ?>
                            </label>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="m">
                                <?= $this->lang->line('profile_gender_m'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="gender" class="form-check-label">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="f" checked>
                                <?= $this->lang->line('profile_gender_f'); ?>
                            </label>
                        </div>
                        <?php
                            }
                        ?>
                    </label>
                </fieldset>
                <label for="username" class="col-sm-4 col-form-label"><strong><?= $username; ?></strong>:
                <input type="text" class="form-control" id="username" name="username" value="<?= $profile_username; ?>" readonly></label>
                <label for="email" class="col-sm-4 col-form-label"><strong><?= $email; ?></strong>:
                <input type="text" class="form-control" id="email" name="email" value="<?= $profile_email; ?>" readonly></label><br>
                <label for="phone" class="col-sm-4 col-form-label"><strong><?= $phone; ?></strong>:
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $profile_phone; ?>" readonly></label>
                <fieldset class="form-group">
                    <label class="form-label"><strong><?= $language; ?></strong>:
                        <?php
                            if ($profile_language === $this->lang->line('profile_language_en')) {
                        ?>
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language" name="language" value="en" checked>
                                <?= $this->lang->line('profile_language_en'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language" name="language" value="it">
                                <?= $this->lang->line('profile_language_it'); ?>
                            </label>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language" name="language" value="en">
                                <?= $this->lang->line('profile_language_en'); ?>
                            </label>
                        </div>
                        <div class="form-check"> 
                            <label for="language" class="form-check-label">
                                <input type="radio" class="form-check-input" id="language" name="language" value="it" checked>
                                <?= $this->lang->line('profile_language_it'); ?>
                            </label>
                        </div>
                        <?php
                            }
                        ?>
                    </label>
                </fieldset>
            <!-- </div> -->
        </div>
        <br>
        <button onclick="return confirmation()" class="col-sm-2 btn btn-primary"><?= $button; ?></button>
        <a class="btn btn-link" href="<?= base_url($this->session->userdata('language') . 'profiles'); ?>">&laquo; <?= $this->lang->line('back');?></a>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>