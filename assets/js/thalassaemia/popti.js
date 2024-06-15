$(document).ready(function() {
    
    $('#popti-table').DataTable();
    $('.dataTables_filter').css('margin-bottom', '10px');
    $('.dataTables_paginate').css('margin', '10px 0 10px 0');
    
    $('#popti-item-adder').click(function() {
        addPoptiItem('', '', '', true);
    });
    
    $('.form-reset').on('click', function() {
        //location.href=window.location.href;
        formReset();
    });
    
    $('#modal-popti').on('shown.bs.modal', function(e) {
        var id = $('#modal-popti-id').text();
        $.ajax({
            url: baseUrl + 'popti/' + id,
            success: function(resp) {
                //console.log(resp);
                var obj = $.parseJSON(resp);
                $('#popti-title').html('<i class="ti ti-info-alt"></i> POPTI Info <small class="ti ti-angle-double-right"></small> ' + obj.popti.branch);
                $('#popti-notes').html(obj.popti.notes);
                
                var list = '';
                if (obj.units.length > 0) {
                    for (var i = 0; i < obj.units.length; i++) {
                        var unit = obj.units[i];
                        list += '<div class="row">';
                        list += '<div class="col-3"><b>' + unit.name + '</b></div>';
                        list += '<div class="col-9">' + unit.notes + '</div>';
                        list += '</div>';
                        list += '<div class="divider mt-3 mb-3"></div>';
                    }
                    
                    $('#popti-units').html(list);
                }
            }
        });
    });
    
    $('#popti-form-add, #popti-form-edit').submit(function(e) {
        e.preventDefault();
        const postData = poptiInput();
        var fid = $(this).attr('id');
        if (fid == 'popti-form-edit') {
            postData.popti_id = $('#popti-id').val();
            if ($('#popti-status').length) {
                var st = $('#popti-status').is(':checked')? 1 : 0;
                postData.popti_status = st;
            }
            postData.form_action = 'edit';
        } else {
            postData.form_action = 'add';
        }
        
        //console.log(postData);
        $.ajax({
            url: baseUrl + 'popti/post',
            type: 'POST',
            data: postData,
            beforeSend: function() {
                $('#popti-form-submit-result').remove();
                $('.form-control').attr('disabled', true);
                $('.form-select').attr('disabled', true);
                $('.btn').attr('disabled', true);
                $('.form-reset').after(' <img src="' + basicLoader + '" id="form-loader" />');
                removeValidInvalidClass();
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
                                $('#' + key).addClass('is-valid');
                            }
                        }
                    }
                } else {
                    
                    var msg = 'data POPTI <b>' + $('#popti-branch').val() + '</b> berhasil diproses.';
                    if (fid == 'popti-form-add') {
                        msg = 'Penambahan ' + msg;
                        $('.form-control').val('');
                        $('.form-select').val('');
                        formReset();
                    } else {
                        msg = 'Modifikasi ' + msg;
                        $('#popti-meta-data').html(obj.data);
                        $('#popti-items').html('');
                        if (obj.data !== '') {
                            var items = $.parseJSON(obj.data);
                            for (var i = 0; i < items.length; i++) {
                                addPoptiItem(items[i].name, items[i].notes, items[i].id);
                            }
                        }
                    }
                    
                    var pa = pageAlert('popti-form-submit-result', msg, 'success', true, 'check');
                    $('.popti-form').before(pa);
                }
            },
            cache: false
        });
        
        formAfterProcess();
        $('html, body').animate({scrollTop : 0}, 100);
    });
});

function poptiInput() {
    const post = {
        popti_branch : $('#popti-branch').val(),
        popti_notes : $('#popti-notes').val(),
    };
    
    const items = [];
    $('.form-input').each(function() {
        items.push($(this).val());
    });
    
    post.popti_items = items;
    
    const notes = [];
    $('.form-text').each(function() {
        notes.push($(this).val());
    });
    
    post.popti_item_notes = notes;
    
    const ids = [];
    $('.unit-id').each(function() {
        ids.push($(this).val());
    });
    
    post.popti_unit_ids = ids;
    
    return post;
}

function addPoptiItem(item, notes, unitId, removeable) {
    
    var inp = document.createElement('input');
    inp.setAttribute('type', 'text');
    inp.setAttribute('name', 'item_data[]');
    inp.setAttribute('class', 'form-control form-input');
    inp.setAttribute('placeholder', 'Nama lembaga kesehatan (*)');
    inp.setAttribute('required', 'required');
    inp.setAttribute('value', item);
    
    var id = document.createElement('input');
    id.setAttribute('type', 'hidden');
    id.setAttribute('class', 'unit-id');
    id.setAttribute('name', 'item_id[]');
    id.setAttribute('value', unitId);
    
    var td1 = document.createElement('td');
    td1.setAttribute('width', '27%');
    td1.appendChild(inp);
    td1.appendChild(id);
    
    var txt = document.createElement('textarea');
    txt.setAttribute('class', 'form-control autosize form-text');
    txt.setAttribute('name', 'item_notes[]');
    txt.setAttribute('placeholder', 'Catatan khusus (Alamat / Kontak personal / No. Telepon / Email dsb).');
    txt.appendChild(document.createTextNode(notes));
    
    var td2 = document.createElement('td');
    td2.setAttribute('width', '68%');
    td2.appendChild(txt);
    
    var td3 = document.createElement('td');
    if (removeable) {
        var del = document.createElement('button');
        del.setAttribute('type', 'button');
        del.setAttribute('title', 'Hapus');
        del.setAttribute('onclick', 'removeNode(this)');
        del.setAttribute('class', 'btn btn-link red-text btn-sm');

        var rm = document.createElement('i');
        rm.setAttribute('class', 'ti-close');
        del.appendChild(rm);
        td3.appendChild(del);
    }
    
    var tr = document.createElement('tr');
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    
    var tbl = document.getElementById('popti-items');
    tbl.appendChild(tr);
}

function removeNode(obj) {
    var tr = obj.parentNode.parentNode;
    tr.parentNode.removeChild(tr);
}

function formReset() {
    enableAllFields();
    removeValidInvalidClass();
    var fid = $('.popti-form').attr('id');
    if (fid == 'popti-form-add') {
        $('#popti-items').html('');
        addPoptiItem('', '', '', false);
    } else {
        if ($('#popti-meta-data').length) {
            var strMeta = $('#popti-meta-data').text();
            if (strMeta !== '') {
                $('#popti-items').html('');
                var meta = $.parseJSON(strMeta);
                for (var i = 0; i < meta.length; i++) {
                    var removeable = i == 0 ? false : true;
                    addPoptiItem(meta[i].name, meta[i].notes, meta[i].id, removeable);
                }
            }
        }
    }
    
    $('html, body').animate({scrollTop : 0}, 100);
}

function enableAllFields() {
    $('.form-control').attr('disabled', false);
    $('.form-control').removeAttr('readonly');
    $('.form-select').attr('disabled', false);
}

function removeValidInvalidClass() {
    $('.form-control').removeClass('is-valid');
    $('.form-control').removeClass('is-invalid');
    $('.form-select').removeClass('is-valid');
    $('.form-select').removeClass('is-invalid');
    $('.error-message').html('');
}

function formAfterProcess() {
    enableAllFields();
    $('.btn').attr('disabled', false);
    $('#form-loader').remove();
}

function poptiActivate(id, branch) {
    if ($('#popti-status-' + id).length) {
        var status = $('#popti-status-' + id).is(':checked')? 1 : 0;
        $.ajax({
            url: baseUrl + 'popti/activate',
            type: 'post',
            data: {
                popti_id : id, popti_branch : branch, popti_status : status
            }
        });
    }
}

function poptiRemove(id, branch) {
    if ($('#popti-remove-' + id).length) {
        var ask = confirm('Anda yakin untuk menghapus ' + branch + '?');
        if (ask) {
            $.ajax({
                url: baseUrl + 'popti/remove',
                type: 'post',
                data: {popti_id : id, popti_branch : branch},
                beforeSend: function() {
                    $('#popti-alert').remove();
                },
                success : function(resp) {
                    var ms = 'Data POPTI "' + branch + '" berhasil dihapus.';
                    var pa = pageAlert('popti-alert', ms, 'success', true, 'check');
                    $('#popti-table').before(pa);
                    $('#popti-table').load(document.URL + ' #popti-table');
                }
            });
        }
    }
}

function poptiDetails(id) {
    $('#modal-popti-id').html(id);
}