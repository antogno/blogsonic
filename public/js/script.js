function confirmation() {
    if ( ! confirm(confirmation_text)) {
        return false;
    }
}

function confirmationProfile() {
    if ( ! confirm(confirmation_profile_text)) {
        return false;
    }
}

function trimText(id) {
    $('#' + id).blur(function () {
        $('#' + id).val($.trim(this.value));
    });

    $('#' + id).on('keypress', function(key) {
        if (key.which == 13) {
            $('#' + id).val($.trim(this.value));
        }
    });
}

function managePasswordField(password_id, toggle_id) {
    $('#' + toggle_id).click(function () {
        let type = $('#' + password_id).attr("type"); 
        if (type === 'password'){
            $('#' + password_id).attr("type", "text");
            $('#' + toggle_id).html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
        } else {
            $('#' + password_id).attr("type", "password");
            $('#' + toggle_id).html('<i class="fa fa-eye" aria-hidden="true"></i>');
        }
    });
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

function validData(url, current_method) {
    function checkUniqueField(id, method) {
        $.ajax({
            url: url + method,
            type: 'POST',
            data: {value: $("#" + id).val(), method: current_method},
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
            $("#save_changes").attr("disabled", true);
        } else {
            $("#register").attr("disabled", false);
            $("#save_changes").attr("disabled", false);
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
    let urlParams = new URLSearchParams(window.location.search);

    $('#filter_blogs').submit(function() {
        if (urlParams.has('search')) {
            $('<input>').attr({
                type: 'hidden',
                name: 'search',
                value: urlParams.get('search')
            }).prependTo(this);
        }
    });
}