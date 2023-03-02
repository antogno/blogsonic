    </div>
</section>
<hr>
<!-- Footer -->
<footer>
    <div class="form-group">
        <div style="width: 70%; float: left">
            <p style="padding: 0 1rem 1rem 1rem; float: left">
                <?php
                    if ( ! $this->session->userdata('logged_in')) {
                ?>
                    <label class="form-label">
                        <select class="form-select" id="change_language">
                            <option value="" selected disabled hidden><?= $this->lang->line('language'); ?></option>
                            <option value="en" <?php if (substr($this->encryption->decrypt($this->session->userdata('language')), 0, -1) == 'en') { echo 'selected'; } ?>><?= $this->lang->line('english'); ?></option>
                            <option value="it" <?php if (substr($this->encryption->decrypt($this->session->userdata('language')), 0, -1) == 'it') { echo 'selected'; } ?>><?= $this->lang->line('italian'); ?></option>
                        </select>
                    </label>
                    &mdash;
                <?php
                    }
                ?>
                <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/privacy'); ?>" id="privacy_policy_link"><?= $this->lang->line('privacy_policy'); ?></a>
                &ndash;
                <a target="_blank" href="https://github.com/antogno/blogsonic/blob/master/LICENSE"><?= $this->lang->line('license'); ?></a>
                &ndash;
                <?= $this->lang->line('designed_and_created_by'); ?> <a target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/">Antonio Granaldi</a>
                &vert;

                <?php $git_info = getCurrentGitInfo(); ?>
                <a
                    target="_blank"
                    href="<? $git_info['url']; ?>"
                >
                    <span class="badge bg-primary">
                        <i class="fa fa-code-fork"></i>
                        <?= $git_info['label']; ?>
                    </span>
                </a>
            </p>
        </div>
        <div style="width: 30%; float: right">
            <p style="padding: 0 1rem 1rem 1rem; float: right">
                <a target="_blank" href="https://github.com/antogno"><i class="fa fa-github" aria-hidden="true"></i></a>
                <a target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                <a target="_blank" href="https://twitter.com/AGranaldi"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </p>
        </div>
    </div>
</footer>
<!-- Scripts -->
<script src="<?= base_url('public/js/script.js'); ?>"></script>
<script>
let confirmation_text = "<?= $this->lang->line('confirmation'); ?>";
let confirmation_profile_text = "<?= $this->lang->line('confirmation_profile'); ?>";
$(document).ready(function() {
    manageCookiebar();
    manageLanguageSwitcher();
    trimText('search');
    <?php if ($this->router->fetch_class() == 'blogs' && $this->router->fetch_method() == 'all') { echo 'manageBlogsOptions();'; } ?>
    <?php if ($this->router->fetch_class() == 'profiles' && ($this->router->fetch_method() == 'login' || $this->router->fetch_method() == 'register')) { echo 'managePasswordField("password", "password_button");'; } ?>
    <?php if ($this->router->fetch_class() == 'profiles' && $this->router->fetch_method() == 'password') { echo 'managePasswordField("new_password", "new_password_button"); managePasswordField("old_password", "old_password_button");'; } ?>
    <?php if ($this->router->fetch_class() == 'profiles' && $this->router->fetch_method() == 'register') { echo 'resetRegistrationForm();'; } ?>
    <?php if ($this->router->fetch_class() == 'profiles' && ($this->router->fetch_method() == 'register' || $this->router->fetch_method() == 'edit')) { echo 'validData("' . base_url('profiles/') . '", "' . $this->router->fetch_method() .'");'; } ?>
});
</script>
</body>
</html>