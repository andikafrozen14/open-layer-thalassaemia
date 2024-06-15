$(document).ready(function() {
       
    userListView();
    $('#reload-table').on('click', function() {
        userListView();
    });
    
    $('.img-uploader').on('click', function() {
        $('#user-avatar').click();
    });
    
    $('#user-avatar').on('change', function() {
        if ($(this).val() !== '') {
            
            if ($('#avatar-path').length) {
                var exp = $(this).val().split('\\');
                var btn = '<button type="button" class="btn btn-outline-secondary btn-sm mt-1" onclick="resetAvatar()">Reset</button>';
                $('#avatar-path').html(exp[2] + '<br />' + btn);
            }
            
            var imgInp = document.getElementById('user-avatar');
            const [file] = imgInp.files
            if (file) {
                var obj = document.getElementById('avatar-preview');
                obj.src = URL.createObjectURL(file);
                if ($('#btn-uploader').length) {
                    $('#btn-uploader').attr('disabled', false);
                }
            } else {
                if ($('#btn-uploader').length) {
                    $('#btn-uploader').attr('disabled', true);
                }
            }
        } else {
            resetAvatar();
            if ($('#btn-uploader').length) {
                $('#btn-uploader').attr('disabled', true);
            }
        }
    });
    
    $('.form-reset').on('click', function() {
        formReset();
    });
    
    $('#user-form').submit(function(e) {
        e.preventDefault();
        userFormSubmit(this);
    });
    
    $('#profile-form').submit(function() {
        userProfileFormSubmit();
    });
    
    $('#modal-profile').on('hidden.bs.modal', function() {
        $('#profile-form')[0].reset();
    });
});

function userProfileFormSubmit() {
    $.ajax({
        url: baseUrl + 'update-profile',
        type: 'POST',
        data: {
            user_screen : $('#user-screen').val(),
            user_email : $('#user-email').val(),
            user_phone : $('#user-phone').val(),
        },
        beforeSend: function() {
            $('#profile-form-submit-result').remove();
            $('.form-control').attr('disabled', true);
            $('.btn').attr('disabled', true);
            $('.btn-submit').before(' <img src="' + basicLoader + '" id="user-form-loader" class="ms-auto" />');
            removeValidInvalidClass();
        },
        complete: function() {
            $('#user-form-loader').remove();
        },
        success: function(resp) {
            var obj = $.parseJSON(resp);
            //console.log(obj);
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

                $('html, body').animate({scrollTop : 0}, 100);
            } else {
                window.location.href = baseUrl + 'user-profile/' + obj.user;
            }
        }
    });
    
    enableAllFields();
    removeValidInvalidClass();
}

function userFormSubmit(form) {
    $.ajax({
        url: baseUrl + 'setting/user/post',
        type: 'POST',
        data: new FormData(form),
        beforeSend: function() {
            $('#user-form-submit-result').remove();
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
            $('.btn').attr('disabled', true);
            $('.form-reset').after(' <img src="' + basicLoader + '" id="user-form-loader" />');
            $('.form-control').removeClass('is-invalid');
            $('.error-message').html('');
        },
        success: function (data) {
            //console.log(data);
            var obj = $.parseJSON(data);
            //console.log(obj);
            if (obj.code == 400) {
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

                $('html, body').animate({scrollTop : 0}, 100);
            }

            if (obj.code == 200) {
                userListView();
                var res = pageAlert('user-form-submit-result', obj.message, 'success', true, 'check');
                $('#user-form').before(res);
                $('.form-control').val('');
                $('#avatar-path').html('');
                $('#user-avatar').val('');
                formReset();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });

    formAfterProcess();
}

function enableAllFields() {
    $('.form-control').attr('disabled', false);
    $('.form-control').removeAttr('readonly');
    $('.form-select').attr('disabled', false);
    $('.btn').attr('disabled', false);
}

function resetAvatar() {
    
    $('#avatar-path').html('');
    $('#user-avatar').removeClass('is-invalid');
    $('#user-avatar').val('');
    
    if ($('#img-url-hide').length) {
        $('#avatar-preview').attr('src', $('#img-url-hide').val());
    } else {
        $('#avatar-preview').attr('src', noAvatarPath);
    }
    
    $('#error-user-avatar').html('');
}

function removeCheckEnabler() {
    if ($('#form-check-enabler').length) {
        $('#form-check-enabler').remove();
    }
}

function removeValidInvalidClass() {
    $('.form-control').removeClass('is-valid');
    $('.form-control').removeClass('is-invalid');
    $('.form-select').removeClass('is-valid');
    $('.form-select').removeClass('is-invalid');
    $('.error-message').html('');
}

function userEdit(uid) {
    removeCheckEnabler();
    var data = $('#user-edit-' + uid).val();
    data = $.parseJSON(data);
    $('#user-id').val(data.name);
    $('#user-screen').val(data.screen);
    $('#user-email').val(data.email);
    $('#user-phone').val(data.phone);
    $('#user-role').val(data.rid);
    
    var path = noAvatarPath;
    if (data.avatar !== '') {
        path = baseUrl + data.avatar;
    }
    
    $('#avatar-preview').attr('src', path);
    $('#user-form-action').val('edit-' + data.id);
    $('#user-id').attr('readonly', true);
    $('#user-password').attr('disabled', true);
    $('#user-repassword').attr('disabled', true);
    $('#user-password').val('');
    $('#user-repassword').val('');
    
    var enb = '<label id="form-check-enabler" class="form-check mt-1">';
    enb += '<input type="checkbox" onclick="editPassword()" class="form-check-input" id="password-edit-enabler" />';
    enb += ' <span class="form-check-label">Ubah kata sandi</span></label>';
    $('#user-password').after(enb);
    removeValidInvalidClass();
    $('#user-screen').focus();
}

function editPassword() {
    if ($('#password-edit-enabler').is(':checked')) {
        $('#user-password').attr('disabled', false);
        $('#user-repassword').attr('disabled', false);
        $('#user-password').focus();
    } else {
        $('#user-password').attr('disabled', true);
        $('#user-repassword').attr('disabled', true);
    }
}

function takeUpload() {
    $('#user-avatar').removeClass('is-invalid');
    $('#user-avatar').attr('disabled', false);
    $('#user-avatar').click();
}

function formReset() {
    $('#user-form-action').val('add');
    resetAvatar();
    removeCheckEnabler();
    enableAllFields();
    removeValidInvalidClass();
    //$('#user-id').focus();
    $('html, body').animate({scrollTop : 0}, 100);
}

function formAfterProcess() {
    if ($('#user-form-action').val() !== 'add') {
        $('#user-screen').attr('disabled', false);
        $('#user-email').attr('disabled', false);
        $('#user-phone').attr('disabled', false);
        $('#user-role').attr('disabled', false);
        if ($('#password-edit-enabler').is(':checked')) {
            if ($('#user-password').val().length > 0) {
                $('#user-password').attr('disabled', false);
                $('#user-repassword').attr('disabled', false);
            } else {
                $('#user-password').attr('disabled', true);
                $('#user-repassword').attr('disabled', true);
                $('#password-edit-enabler').prop('checked', false);
            }
        }
    } else {
        enableAllFields();
    }
    
    $('#user-form-loader').remove();
}

function userListView() {
    $.ajax({
        url: baseUrl + 'setting/user/list',
        success: function(result) {
            $('#user-list-view').html(result);
            $('table.data-table').DataTable();
            $('.dataTables_filter').css('margin-bottom', '10px');
            $('.dataTables_paginate').css('margin', '10px 0 10px 0');
        }
    });
}

function locking(id, name) {
    var obj = $('#check-lock-' + id);
    var isLocked = obj.is(':checked')? true : false;
    $.ajax({
        url: baseUrl + 'setting/user/lock',
        type: 'post',
        data: {uid : id, lock : isLocked, name: name}
    });
}

function userRemove(id, screen) {
    var conf = confirm('Anda yakin untuk hapus data pengguna ' + screen + '?');
    if (conf) {
        $.ajax({
            url: baseUrl + 'setting/user/remove/' + id,
            beforeSend: function() {
                $('#remove-result').remove();
            },
            success: function(data) {
                //console.log(data);
                var message = 'Pengguna ' + screen + ' berhasil dihapus.';
                var result  = pageAlert('remove-result', message, 'success', true, 'check');
                $('#result-process').html(result);
                userListView();
            }
        });
    }
}