    </div>
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
                    <a target="_blank"href="https://www.linkedin.com/in/antonio-granaldi"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                    <a target="_blank" href="https://github.com/antogno"><i class="fa fa-github" aria-hidden="true"></i></a>
                </p>
            </div>
        </div>
    </footer>
    <script>
        let confirmation_text = "<?= $this->lang->line('confirmation'); ?>";
        let confirmationProfile_text = "<?= $this->lang->line('confirmationProfile'); ?>";
    </script>
    <script src="<?= base_url('public/js/script.js'); ?>"></script>
    <script>
        function getBlogsonicPosition(url) {
            let blogsonic_segment = []
            url = url.split('/');
            url.forEach(function (item, index) {
                if (item.indexOf('blogsonic') >= 0) {
                    blogsonic_segment.push(index + 1)
                }
            });
            return blogsonic_segment[0];
        }

        $(document).ready(function() {
            if ( ! localStorage.getItem('cookie')) {
                $('#cookiebar').modal('show');
            }

            $('#cookiebar_hide').click(function() {
                localStorage.setItem('cookie', true);
                $('#cookiebar').modal('hide');
            });

            blogsonic_segment = getBlogsonicPosition(window.location.href);
            let segments = window.location.href.split('/');

            if ($("#change_limit option[value='" + segments[blogsonic_segment + 3] + "']").length > 0) {
                $("#change_limit").val(segments[blogsonic_segment + 3]);
            }

            if ($("#change_order option[value='" + segments[blogsonic_segment + 4] + "']").length > 0) {
                $("#change_order").val(segments[blogsonic_segment + 4]);
            }

            $("#date_min").val(segments[blogsonic_segment + 5]);

            if (typeof segments[blogsonic_segment + 6] != 'undefined') {
                segments[blogsonic_segment + 6] = segments[blogsonic_segment + 6].substring(0, 10);
            }
            $("#date_max").val(segments[blogsonic_segment + 6]);

            $('#reset').click(function() {
                $("#change_limit").val("");
                $("#change_order").val("");
                $("#date_min").val("");
                $("#date_max").val("");
                let last_segment = segments[segments.length - 1].split('?');
                segments[segments.length - 1] = last_segment[0];
                segments.splice(blogsonic_segment + 3);
                window.location = segments.join('/');
            });

            $('#change_options').click(function() {
                blogsonic_segment = getBlogsonicPosition(window.location.href);
                let segments = window.location.href.split('/');
                let search_term = segments[segments.length - 1].split('?');
                segments[segments.length - 1] = search_term[0];
                search_term = typeof search_term[1] != 'undefined' ? '?' + search_term[1] : '';

                if (segments.length == blogsonic_segment + 3) {
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
                    window.location = segments.join('/') + search_term;
                } else if (segments.length == blogsonic_segment + 4) {
                    if ($('#change_limit').val()) {
                        segments[blogsonic_segment + 3] = $('#change_limit').val();
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
                    window.location = segments.join('/') + search_term;
                } else if (segments.length == blogsonic_segment + 5) {
                    if ($('#change_limit').val()) {
                        segments[blogsonic_segment + 3] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[blogsonic_segment + 4] = $('#change_order').val();
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
                    window.location = segments.join('/') + search_term;
                } else if (segments.length == blogsonic_segment + 6) {
                    if ($('#change_limit').val()) {
                        segments[blogsonic_segment + 3] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[blogsonic_segment + 4] = $('#change_order').val();
                    }
                    if ($('#date_min').val()) {
                        segments[blogsonic_segment + 5] = $('#date_min').val();
                    }
                    if ($('#date_max').val()) {
                        segments.push($('#date_max').val());
                    } else {
                        let today = new Date().toISOString().slice(0, 10);
                        segments.push(today);
                    }
                    window.location = segments.join('/') + search_term;
                } else if (segments.length == blogsonic_segment + 7) {
                    if ($('#change_limit').val()) {
                        segments[blogsonic_segment + 3] = $('#change_limit').val();
                    }
                    if ($('#change_order').val()) {
                        segments[blogsonic_segment + 4] = $('#change_order').val();
                    }
                    if ($('#date_min').val()) {
                        segments[blogsonic_segment + 5] = $('#date_min').val();
                    }
                    if ($('#date_max').val()) {
                        segments[blogsonic_segment + 6] = $('#date_max').val();
                    }
                    window.location = segments.join('/') + search_term;
                }
            });

            $('#change_language').change(function() {
                let segments = window.location.href.split('/');
                segments.forEach(function (item, index) {
                    if (item.indexOf('blogsonic') >= 0) {
                        if (segments[index + 1] == 'it' || segments[index + 1] == 'en') {
                            segments[index + 1] = $('#change_language').val();
                        } else {
                            for (let i = segments.length; i > index; i--) {
                                segments[i] = segments[i - 1];
                            }
                            segments[index + 1] = $('#change_language').val();
                        }
                    }
                });
                window.location = segments.join('/');
            });
        });
    </script>
</body>
</html>