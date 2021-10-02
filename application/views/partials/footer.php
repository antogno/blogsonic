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
                            <option value="" selected disabled hidden><?= $this->lang->line('language_select_footer'); ?></option>
                            <option value="en"><?= $this->lang->line('language_en_footer'); ?></option>
                            <option value="it"><?= $this->lang->line('language_it_footer'); ?></option>
                        </select>
                    </label>
                    &mdash;
                <?php
                    }
                ?>
                <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/privacy'); ?>" id="privacy_policy_link"><?= $this->lang->line('privacy_policy_link'); ?></a>
                &ndash;
                <a target="_blank" href="https://github.com/antogno/blogsonic/blob/master/LICENSE"><?= $this->lang->line('license'); ?></a>
                &ndash;
                Blogsonic.org &ndash; <?= $this->lang->line('designed_and_created_by'); ?> <a target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/">Antonio Granaldi</a>.
            </p>
        </div>
        <div style="width: 30%; float: right">
            <p style="padding: 0 1rem 1rem 1rem; float: right">
                <a target="_blank" href="https://www.facebook.com/antonio.granaldi"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                <a target="_blank" href="https://twitter.com/AGranaldi"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a target="_blank" href="https://www.reddit.com/user/antogno"><i class="fa fa-reddit" aria-hidden="true"></i></a>
                <a target="_blank"href="https://www.linkedin.com/in/antonio-granaldi/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                <a target="_blank"href="https://stackoverflow.com/users/16877786/antogno"><i class="fa fa-stack-overflow" aria-hidden="true"></i></a>
                <a target="_blank" href="https://github.com/antogno"><i class="fa fa-github" aria-hidden="true"></i></a>
            </p>
        </div>
    </div>
</footer>
<!-- Scripts -->
<script src="<?= base_url('public/js/script.js'); ?>"></script>
<script>
let confirmation_text = "<?= $this->lang->line('confirmation'); ?>";
let confirmationProfile_text = "<?= $this->lang->line('confirmationProfile'); ?>";
$(document).ready(function() {
    manageCookiebar();
    manageLanguageSwitcher();
    <?php if ($this->router->fetch_class() == 'blogs') { echo 'manageBlogsOptions();'; } ?>
});
</script>
</body>
</html>