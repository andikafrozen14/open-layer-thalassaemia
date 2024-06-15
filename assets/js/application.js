$(document).ready(function() {
    $('#setting-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            cache: false,
            contentType: false,
            processData: false,
            url: baseUrl + 'setting/application',
            type: 'post',
            data: new FormData(this),
            beforeSend: function() {
                $('#alert-result').remove();
                $('.form-control').attr('disabled', true);
                $('.form-select').attr('disabled', true);
                $('.form-check-input').attr('disabled', true);
                $('.btn').attr('disabled', true);
                $('.form-reset').after(' <img src="' + basicLoader + '" id="form-loader" />');
            },
            complete: function() {
                $('.form-control').attr('disabled', false);
                $('.form-select').attr('disabled', false);
                $('.form-check-input').attr('disabled', false);
                $('.btn').attr('disabled', false);
                $('#form-loader').remove();
            },
            success: function(resp) {
                //console.log(resp);
                var obj = $.parseJSON(resp);
                if (obj.code !== 200) {
                    for (var key in obj.errors) {
                        if (obj.errors.hasOwnProperty(key)) {
                            $('#error-' + key).html(obj.errors[key]);
                            if (obj.errors[key] !== '') {
                                $('#' + key).addClass('is-invalid');
                            } else {
                                if (!$('#' + key).is(':disabled')) {
                                    $('#' + key).addClass('is-valid');
                                }
                            }
                        }
                    }
                    
                    var msg = 'Mohon perbaiki kesalahan pengisian berikut.';
                    $('#setting-form').before(pageAlert('alert-result', msg, 'danger', true, 'alert'));
                } else {
                    var msg = 'Konfigurasi berhasil disimpan.';
                    $('#setting-form').before(pageAlert('alert-result', msg, 'success', true, 'check'));
                    removeValidInvalidClass();
                    $('.form-upload').val('');
                    setupImage(obj.setup);
                }
                
                $('html, body').animate({scrollTop : 0}, 100);
            }
        });
    });
});

function removeValidInvalidClass() {
    $('.form-control').removeClass('is-valid');
    $('.form-control').removeClass('is-invalid');
    $('.form-select').removeClass('is-valid');
    $('.form-select').removeClass('is-invalid');
    $('.error-message').html('');
}

function setupImage(setup) {
    console.log(setup);
    var imgLogo = '<img src="' + baseUrl + setup.app_logo_path + '" />';
    var imgRm = '<button class="btn btn-link btn-sm red-text" type="button" onclick="removeSiteLogo()"><i class="ti ti-close"></i></button>';
    $('#form-logo-display').html(imgLogo + '&nbsp;&nbsp;&nbsp;' + imgRm);
    
    var imgIcon = '<img src="' + baseUrl + setup.app_icon_path + '" />';
    var imgRm = '<button class="btn btn-link btn-sm red-text" type="button" onclick="removeSiteIcon()"><i class="ti ti-close"></i></button>';
    $('#form-icon-display').html(imgIcon + '&nbsp;&nbsp;&nbsp;' + imgRm);
    
    var imgAvatar = '<img src="' + baseUrl + setup.app_avatar_path + '" class="avatar" />';
    var imgRm = '<button class="btn btn-link btn-sm red-text" type="button" onclick="removeBasicAvatar()"><i class="ti ti-close"></i></button>';
    $('#form-avatar-display').html(imgAvatar + '&nbsp;&nbsp;&nbsp;' + imgRm);
}

function removeSiteLogo() {}

function removeSiteIcon() {}

function removeBasicAvatar() {}