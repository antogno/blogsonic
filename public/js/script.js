function confirmation() {
    if ( ! confirm(confirmation_text)) {
        return false;
    }
}

function confirmationProfile() {
    if ( ! confirm(confirmationProfile_text)) {
        return false;
    }
}

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

function manageCookiebar() {
    if ( ! localStorage.getItem('cookie')) {
        $('#cookiebar').modal('show');
    }

    $('#cookiebar_hide').click(function() {
        localStorage.setItem('cookie', true);
        $('#cookiebar').modal('hide');
    });
}

function manageLanguageSwitcher() {
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
}

function resetRegistrationForm() {
    $('#reset').click(function() {
        $("#name").val("");
        $("#surname").val("");
        $("#gender_m").val("");
        $("#gender_f").val("");
        $("#username").val("");
        $("#password").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#language_en").val("");
        $("#language_it").val("");
        let segments = window.location.href.split('/');
        window.location = segments.join('/');
    });
}

function validData(url) {
    function checkUniqueField(id, method) {
        $.ajax({
            url: url + method,
            type: 'POST',
            data: {value: $("#" + id).val()},
            success: function(data) {
                if (data == 'true') {
                    $("#" + id).attr("class", "form-control is-valid");
                } else if (data == 'false') {
                    $("#" + id).attr("class", "form-control is-invalid");
                }
                checkFieldStatus();
            }
        });
    }
    function checkFieldStatus() {
        if ($("#username").hasClass("is-invalid") || $("#email").hasClass("is-invalid") || $("#phone").hasClass("is-invalid")) {
            $("#register").attr("disabled", true);
        } else {
            $("#register").attr("disabled", false);
        }
    }

    if ($("#username").val()) {
        checkUniqueField('username', 'checkUsername');
    }
    if ($("#email").val()) {
        checkUniqueField('email', 'checkEmail');
    }
    if ($("#phone").val()) {
        checkUniqueField('phone', 'checkPhone');
    }

    $("#username").keyup(function() {
        checkUniqueField('username', 'checkUsername');
    });
    $("#email").keyup(function() {
        checkUniqueField('email', 'checkEmail');
    });
    $("#phone").keyup(function() {
        checkUniqueField('phone', 'checkPhone');
    });

    $("#username").blur(function() {
        if ( ! $("#username").val()) {
            $("#username").attr("class", "form-control");
            checkFieldStatus();
        }
    });
    $("#email").blur(function() {
        if ( ! $("#email").val()) {
            $("#email").attr("class", "form-control");
            checkFieldStatus();
        }
    });
    $("#phone").blur(function() {
        if ( ! $("#phone").val()) {
            $("#phone").attr("class", "form-control");
            checkFieldStatus();
        }
    });
}

function manageBlogsOptions() {
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
                let today = new Date();
                let tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
                segments.push(tomorrow);
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
                let today = new Date();
                let tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
                segments.push(tomorrow);
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
                let today = new Date();
                let tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
                segments.push(tomorrow);
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
                let today = new Date();
                let tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
                segments.push(tomorrow);
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
}