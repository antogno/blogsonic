    </div>
    <hr>
    <div class="form-group">
        <footer style="padding: 0 1rem 1rem 1rem">
            <?php
                if(!$this->session->userdata('logged_in')) {
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
            <a href="<?= base_url($this->session->userdata('language').'pages/view/privacy'); ?>"><?= $this->lang->line('privacy_policy_link'); ?></a>
            &ndash;
            &copy; 2021, Blogsonic.org &ndash; <?= $this->lang->line('designed_and_created_by'); ?> <a target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/">Antonio Granaldi</a>.
        </footer>
    </div>
    <script>
        let confirmation_text = "<?= $this->lang->line('confirmation'); ?>";
        let confirmationProfile_text = "<?= $this->lang->line('confirmationProfile'); ?>";
    </script>
    <script src="<?= base_url('public/assets/js/script.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            if (!localStorage.getItem('cookie')) {
                $('#cookiebar').modal('show');
            }

            $('#cookiebar_hide').click(function() {
                localStorage.setItem('cookie', true);
                $('#cookiebar').modal('hide');
            });

            $('#change_options').click(function() {
                let segments = window.location.href.split('/');
                if (segments.length == 8) {
                    if ($('#change_limit').val()) {
                        segments.push($('#change_limit').val());
                    } else {
                        segments.push(5);
                    }
                    if ($('#change_order').val()) {
                        segments.push($('#change_order').val());
                    } else {
                        segments.push('desc');
                    }
                    if ($('#date_min').val()) {
                        segments.push($('#date_min').val());
                    } else {
                        segments.push('1970-01-01');
                    }
                    if ($('#date_max').val()) {
                        segments.push($('#date_max').val());
                    } else {
                        let today = new Date().toISOString().slice(0, 10);
                        segments.push(today);
                    }
                    window.location = segments.join('/');
                } else if (segments.length == 9) {
                    if ($('#change_limit').val()) {
                        segments[8] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments.push($('#change_order').val());
                    } else {
                        segments.push('desc');
                    }
                    if ($('#date_min').val()) {
                        segments.push($('#date_min').val());
                    } else {
                        segments.push('1970-01-01');
                    }
                    if ($('#date_max').val()) {
                        segments.push($('#date_max').val());
                    } else {
                        let today = new Date().toISOString().slice(0, 10);
                        segments.push(today);
                    }
                    window.location = segments.join('/');
                } else if (segments.length == 10) {
                    if($('#change_limit').val()) {
                        segments[8] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[9] = $('#change_order').val();
                    }
                    if ($('#date_min').val()) {
                        segments.push($('#date_min').val());
                    } else {
                        segments.push('1970-01-01');
                    }
                    if ($('#date_max').val()) {
                        segments.push($('#date_max').val());
                    } else {
                        let today = new Date().toISOString().slice(0, 10);
                        segments.push(today);
                    }
                    window.location = segments.join('/');
                } else if (segments.length == 11) {
                    if ($('#change_limit').val()) {
                        segments[8] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[9] = $('#change_order').val();
                    }
                    if ($('#date_min').val()) {
                        segments[10] = $('#date_min').val();
                    }
                    if ($('#date_max').val()) {
                        segments.push($('#date_max').val());
                    } else {
                        let today = new Date().toISOString().slice(0, 10);
                        segments.push(today);
                    }
                    window.location = segments.join('/');
                } else if (segments.length == 12) {
                    if ($('#change_limit').val()) {
                        segments[8] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[9] = $('#change_order').val();
                    }
                    if ($('#date_min').val()) {
                        segments[10] = $('#date_min').val();
                    }
                    if ($('#date_max').val()) {
                        segments[11] = $('#date_max').val();
                    }
                    window.location = segments.join('/');
                }
            });

            $('#change_language').change(function() {
                let segments = window.location.href.split('/');
                segments[5] = $(this).val();
                window.location = segments.join('/');
            });
        });
    </script>
</body>
</html>