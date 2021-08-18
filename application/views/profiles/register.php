    <div>
        <div>
            <?php
                if($this->session->userdata('registered')) {
            ?>
            <div class="alert alert-dismissible alert-success">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= '<p><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;'.$this->lang->line('registered'); ?>
                    <a href="<?= base_url($this->session->userdata('language').'profiles/login'); ?>" class="alert-link"><?= ' '.$this->lang->line('registered_link').'</a>.</p>'; ?>
            </div>
            <?php
                }
            ?>
            <?= form_open(); ?>
            <?php
                if(validation_errors()) {
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
                    <label for="name" class="col-sm-4 col-form-label"><strong><?= $form_name; ?></strong>:
                    <input type="text" class="form-control" id="name" name="name" placeholder="<?= $this->lang->line('register_placeholder_name'); ?>"></label>
                    <label for="surname" class="col-sm-4 col-form-label"><strong><?= $form_surname; ?></strong>:
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="<?= $this->lang->line('register_placeholder_surname'); ?>"></label><br>
                    <fieldset class="form-group">
                        <label class="form-label"><strong><?= $form_gender; ?></strong>:
                            <div class="form-check"> 
                                <label for="gender" class="form-check-label">
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="m">
                                    <?= $form_gender_m; ?>
                                </label>
                            </div>
                            <div class="form-check"> 
                                <label for="gender" class="form-check-label">
                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="f">
                                    <?= $form_gender_f; ?>
                                </label>
                            </div>
                        </label>
                    </fieldset>
                    <label for="username" class="col-sm-4 col-form-label"><strong><?= $form_username; ?></strong>:
                    <input type="text" class="form-control" id="username" name="username" placeholder="<?= $this->lang->line('register_placeholder_username'); ?>"></label>
                    <label for="password" class="col-sm-4 col-form-label"><strong><?= $form_password; ?></strong>:
                    <input type="password" class="form-control" id="password" name="password" placeholder="<?= $this->lang->line('register_placeholder_password'); ?>"></label><br>
                    <label for="email" class="col-sm-4 col-form-label"><strong><?= $form_email; ?></strong>:
                    <input type="text" class="form-control" id="email" name="email" placeholder="<?= $this->lang->line('register_placeholder_email'); ?>"></label>
                    <label for="phone" class="col-sm-4 col-form-label"><strong><?= $form_phone; ?></strong>:
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?= $this->lang->line('register_placeholder_phone'); ?>"></label><br>
                    <fieldset class="form-group">
                        <label class="form-label"><strong><?= $form_language; ?></strong>:
                            <div class="form-check"> 
                                <label for="language" class="form-check-label">
                                    <input type="radio" class="form-check-input" id="language" name="language" value="en">
                                    <?= $form_language_en; ?>
                                </label>
                            </div>
                            <div class="form-check"> 
                                <label for="language" class="form-check-label">
                                    <input type="radio" class="form-check-input" id="language" name="language" value="it">
                                    <?= $form_language_it; ?>
                                </label>
                            </div>
                        </label>
                    </fieldset>
                <!-- </div> -->
            </div>
            <br>
            <button type="submit" class="col-sm-2 btn btn-primary"><?= $form_button; ?></button>
            <button type="reset" class="col-sm-2 btn btn-warning"><?= $form_reset; ?></button>
            <?= form_close(); ?>
        </div>
    </div>