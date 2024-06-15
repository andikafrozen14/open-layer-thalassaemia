$(document).ready(function() {
    
    roleView();
    var command = '<code>Silahkan isi Nama Tipe Pengguna untuk mengatur akses tipe pengguna.</code>';
    $('#role-access-form').html(command);
    $('#role-screen').on('change', function() {
        if ($(this).val().trim() !== '') {
            roleAccessView(0);
        } else {
            $('#role-access-form').html(command);
        }
    });
    
    $('.form-reset').on('click', function() {
        formReset();
    });
    
    $('#role-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: baseUrl + 'setting/role/save',
            data: new FormData(this),
            beforeSend: function() {
                $('#role-form-submit-result').remove();
                $('.form-control').attr('disabled', true);
                $('.form-select').attr('disabled', true);
                $('.btn').attr('disabled', true);
                $('.form-reset').after(' <img src="' + basicLoader + '" id="role-form-loader" />');
                $('.form-control').removeClass('is-invalid');
                $('.error-message').html('');
            },
            complete: function() {},
            success: function(data) {
                console.log(data);
                var obj = $.parseJSON(data);
                $('html, body').animate({scrollTop : 0}, 100);
                if (obj.code == 200) {
                    var msg = 'Tipe Pengguna "' + $('#role-screen').val() + '" berhasil disimpan.';
                    var res = pageAlert('role-form-submit-result', msg, 'success', true, 'check');
                    $('#role-form').before(res);
                    $('.form-control').val('');
                    formReset();
                    roleView();
                }
                
                if (obj.error !== '') {
                    $('#role-screen').addClass('is-invalid');
                    $('.error-message').html(obj.error);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        formAfterProcess();
    });
});

function formReset() {
    $('#role-form-action').val('add');
    $('#role-access-form').html('');
    enableAllFields();
    removeValidInvalidClass();
    $('html, body').animate({scrollTop : 0}, 100);
}

function roleView() {
    $.ajax({
        url: baseUrl + 'setting/role/list',
        success: function(result) {
            $('#role-list-view').html(result);
            $('table.data-table').DataTable();
            $('.dataTables_filter').css('margin-bottom', '10px');
            $('.dataTables_paginate').css('margin', '10px 0 10px 0');
        }
    });
}

function roleAccessView(rid) {
    
    var api = baseUrl + 'setting/role/access';
    if (rid !== 0) {
        api = baseUrl + 'setting/role/access/' + rid;
    }
    
    $.ajax({
        url: api,
        success: function(result) {
            accessLoadResultHandler(result);
        }
    });
}

function accessLoadResultHandler(result) {
    $('#role-access-form').html(result);
    $('#item-founder').on('input', function() {
        var filter = $(this).val().toLowerCase();
        $('.perm-list').each(function() {
            var divText = $(this).text().toLowerCase();
            if (divText.indexOf(filter) < 0) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
}

function roleEdit(rid) {
    $('#role-form-submit-result').remove();
    var data = $('#role-edit-' + rid).val();
    data = $.parseJSON(data);
    $('#role-screen').val(data.screen);
    $('#role-screen').focus();
    $('#role-form-action').val('edit-' + rid + '-' + data.name);
    roleAccessView(rid);
}

function formAfterProcess() {
    if ($('#role-form-action').val() !== 'add') {
        $('#role-screen').attr('disabled', false);
    } else {
        enableAllFields();
    }

    $('.btn').attr('disabled', false);
    $('#role-form-loader').remove();
}

function enableAllFields() {
    $('.form-control').attr('disabled', false);
    $('.form-select').attr('disabled', false);
}

function removeValidInvalidClass() {
    $('.form-control').removeClass('is-valid');
    $('.form-control').removeClass('is-invalid');
    $('.error-message').html('');
}

function locking(id, screen) {
    var obj = $('#check-lock-' + id);
    var isLocked = obj.is(':checked')? true : false;
    $.ajax({
        url: baseUrl + 'setting/role/lock',
        type: 'post',
        data: {uid : id, lock : isLocked, screen: screen}
    });
}

function roleRemove(id, screen) {
    var conf = confirm('Anda yakin untuk hapus data tipe pengguna ' + screen + '?');
    if (conf) {
        $.ajax({
            url: baseUrl + 'setting/role/remove/' + id,
            beforeSend: function() {
                $('#remove-result').remove();
            },
            success: function(data) {
                //console.log(data);
                var message = 'Tipe Pengguna "' + screen + '" berhasil dihapus.';
                var result  = pageAlert('remove-result', message, 'success', true, 'check');
                $('#result-process').html(result);
                roleView();
            }
        });
    }
}