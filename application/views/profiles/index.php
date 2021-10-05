<div>
    <div>
        <?php
            if ( ! $this->session->userdata('logged_in')) {
                echo '<div class="mt-4"><p>' . $this->lang->line('not_logged_in');
                echo ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login') . '">' . $this->lang->line('login_now') . '</a> ' . $this->lang->line('or') . ' <a href="' . base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register') . '">' . $this->lang->line('register_now') . '</a>.</p></div>';
            } else {
        ?>
        <div class="form-group">
            <!-- <div class="col-md-3"> -->
                <label for="name" class="col-sm-4 col-form-label"><strong><?= $name; ?></strong>:
                <input type="text" class="form-control" id="name" name="name" value="<?= $profile_name; ?>" readonly></label>
                <label for="surname" class="col-sm-4 col-form-label"><strong><?= $surname; ?></strong>:
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $profile_surname; ?>" readonly></label><br>
                <?php if ($profile_gender) { ?>
                    <label for="gender" class="col-sm-4 col-form-label"><strong><?= $gender; ?></strong>:
                    <input type="text" class="form-control" id="gender" name="gender" value="<?= $profile_gender; ?>" readonly></label><br>
                <?php } ?>
                <label for="username" class="col-sm-4 col-form-label"><strong><?= $username; ?></strong>:
                <input type="text" class="form-control" id="username" name="username" value="<?= $profile_username; ?>" readonly></label>
                <label for="email" class="col-sm-4 col-form-label"><strong><?= $email; ?></strong>:
                <input type="text" class="form-control" id="email" name="email" value="<?= $profile_email; ?>" readonly></label><br>
                <?php if ($profile_phone) { ?>
                    <label for="phone" class="col-sm-4 col-form-label"><strong><?= $phone; ?></strong>:
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $profile_phone; ?>" readonly></label>
                <?php } ?>
                <label for="language" class="col-sm-4 col-form-label"><strong><?= $language; ?></strong>:
                <input type="text" class="form-control" id="language" name="language" value="<?= $profile_language; ?>" readonly></label><br>
                <label for="created_at" class="col-sm-4 col-form-label"><strong><?= $created_at; ?></strong>:
                <input type="text" class="form-control" id="created_at" name="created_at" value="<?= $profile_created_at; ?>" readonly></label>
            <!-- </div> -->
        </div>
        <br>
        <a class="col-sm-2 btn btn-light" id="edit" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/edit'); ?>"><?= $this->lang->line('profile_edit_profile'); ?></a>
        <a class="col-sm-2 btn btn-light" id="change_password" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/password'); ?>"><?= $this->lang->line('profile_change_password'); ?></a>
        <?= form_open(); ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <br><button onclick="return confirmationProfile()" type="submit" class="col-sm-4 btn btn-danger" id="delete"><?= $delete; ?></button>
        <?= form_close(); ?>
        <?php
            }
        ?>
    </div>
</div>