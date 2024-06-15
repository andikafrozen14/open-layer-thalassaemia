jQuery.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
    return {
        'iStart' : oSettings._iDisplayStart,
        'iEnd' : oSettings.fnDisplayEnd(),
        'iLength' : oSettings._iDisplayLength,
        'iTotal' : oSettings.fnRecordsTotal(),
        'iFilteredTotal' : oSettings.fnRecordsDisplay(),
        'iPage' : oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        'iTotalPages' : oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
};

function displayDataTable(tableId, limit, offset, sortBy, sortMode, pathService, data) {

    return $('#'+tableId).dataTable({
        'bProcessing' : true,
        'bServerSide' : true,
        'order': [[ sortBy, sortMode ]],
        'bStateSave' : false,
        'iDisplayLength' : limit,
        'iDisplayStart' : offset,
        'fnDrawCallback' : function() {},
        'sAjaxSource' : pathService,
        'aoColumns': data,
        retrieve: true,
        'columnDefs': [{
            'targets': 'unorderable',
            'orderable': false,
        }]
    });
}

function clickDetail(slug) {
    $('#screening-detail-slug').val(slug);
}

function itemDetail(data) {
    var link = '<button class="btn btn-link" onclick="clickDetail(\'' + data.slug + '\')" ';
    link += 'data-bs-toggle="modal" data-bs-target="#modal-screening-detail">' + data.nik + '</button>';
    link += '<input type="hidden" id="title-for-' + data.fid + '" value="' + data.title + '" />';
    return link;
}

function handler(data) {
    
    var out = '';
    if ($('#user-access-edit').val() == 1) {
        var url = baseUrl + 'screening/' + data.slug + '/edit';
        out += '<button class="btn btn-link btn-sm" onclick="location.href=\'' + url + '\'" title="Ubah">';
        out += '<i class="ti-pencil-alt"></i>';
        out += '</button>';
        out += ' ';
    }
    
    if ($('#user-access-remove').val() == 1) {
        out += '<button class="btn btn-link red-text btn-sm" onclick="screeningRemove(\'' + data.fid + '\')" title="Hapus">';
        out += '<i class="ti-close"></i>';
        out += '</button>';
    }
    
    return out;
}

$(document).ready(function() {
    
    $('#uploader1').hide();
    $('#uploader2').hide();
    $('#last-event').hide();
    $('#modal-screening-detail').on('shown.bs.modal', function(e) {
        var slug = $('#screening-detail-slug').val();
        $.ajax({
           url: baseUrl + 'screening/' + slug,
           success: function(resp) {
               if (resp !== '') {
                    distribute($.parseJSON(resp));
               }
           }
        });
    });
    
    if ($('#screening-table').length) {
        var data = [
            { mData: null, mRender : function(data, type, full) { return itemDetail(data) } },
            { mData: 'name' },
            { mData: 'gender' },
            { mData: 'blood_type' },
            { mData: 'has_family' },
            { mData: 'indicate' },
            { mData: 'cellno' },
            { mData: 'event' },
            { mData: 'created' },
        ];

        if ($('#user-access-edit').val() == 1 || $('#user-access-remove').val() == 1) {
            data.push({ mData: null, mRender: function(data, type, full) { return handler(data)} });
        }

        var api = baseUrl + 'screening/list';
        displayDataTable('screening-table', 10, 0, 0, 'desc', api, data);
        $('#screening-table_filter').css('margin-bottom', '10px');
        $('#screening-table_paginate').css('margin', '10px 0 20px 0');
    }
    
    $('.form-reset').on('click', function() {
        formReset();
    });
    
    if ($('#screening-form-add').length) {
        $('#patient-childs-input').hide();
    } else if ($('#screening-form-edit').length) {
        var childs = $('#patient-childs').val();
        if (childs < 1) {
            $('#patient-childs-input').hide();
        }
    }
    
    $('#patient-marital').on('change', function() {
        if ($(this).val() == 'Belum Menikah') {
            $('#patient-childs-input').hide();
            $('#patient-childs').val('0');
        } else {
            $('#patient-childs-input').show();
            $('#patient-childs').focus();
        }
    });
    
    $('#patient-inherit').change(function() {
        if ($(this).val() == 0) {
            $('#patient-inherit-input').hide();
            $('#patient-inherit-nik').val('');
        } else {
            $('#patient-inherit-input').show();
            $('#patient-inherit-input').focus();
        }
    });
    
    $('.screen-form').submit(function(e) {
        e.preventDefault();
        
        var id = $(this).attr('id');
        var ep = baseUrl + 'screening/add';
        if (id == 'screening-form-edit') {
            ep = window.location.href;
        }
        
        $.ajax({
            url: ep,
            type: 'post',
            data: new FormData(this),
            beforeSend: function() {
                $('#screening-form-submit-result').remove();
                $('.form-control').attr('disabled', true);
                $('.form-select').attr('disabled', true);
                $('.btn').attr('disabled', true);
                $('.form-reset').after(' <img src="' + basicLoader + '" id="form-loader" />');
                removeValidInvalidClass();
            },
            success: function(resp) {
                console.log(resp);
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
                    $('.screen-form').before(pageAlert('screening-form-submit-result', msg, 'danger', true, 'alert'));
                    $('html, body').animate({scrollTop : 0}, 100);
                } else {
                    
                    if (id == 'screening-form-edit') {
                        location.href = window.location.href;
                    }
                    
                    var msg = 'data screening <b>' + $('#patient-name').val() + '</b> berhasil disimpan.';
                    if (id == 'screening-form-add') {
                        msg = 'Penambahan ' + msg;
                        $('.form-control').val('');
                        $('.form-select').val('');
                    } else {
                        msg = 'Modifikasi ' + msg;
                    }
                    
                    var pa = pageAlert('screening-form-submit-result', msg, 'success', true, 'check');
                    $('.screen-form').before(pa);
                    formReset();
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
    enableAllFields();
    removeValidInvalidClass();
    var formId = $('.screen-form').attr('id');
    if (formId == 'screening-form-add') {
        $('#patient-inherit').val(1);
        $('#patient-inherit-input').show();
        $('#patient-inherit-nik').val('');
        $('#patient-event').val($('#last-event').text());
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
    $('#address-province').attr('disabled', true);
    $('#address-city').attr('disabled', true);
    $('#address-district').attr('disabled', true);
    $('#address-village').attr('disabled', true);
    $('.btn').attr('disabled', false);
    $('#form-loader').remove();
}

function editDoc1() {
    $('#link-doc1').hide();
    $('#uploader1').show();
    $('#patient-upload-lab1').click();
}

function cancelUploadDoc1() {
    $('#link-doc1').show();
    $('#uploader1').hide();
    $('#patient-upload-lab1').val('');
    $('input[name=\'remove_doc1\']').remove();
}

function removeDoc1() {
    $('#link-doc1').hide();
    $('#uploader1').show();
    $('#patient-upload-lab1').val('');
    $('#patient-upload-lab1').after('<input type="hidden" name="remove_doc1" value="1" />');
}

function editDoc2() {
    $('#link-doc2').hide();
    $('#uploader2').show();
    $('#patient-upload-lab2').click();
}

function cancelUploadDoc2() {
    $('#link-doc2').show();
    $('#uploader2').hide();
    $('#patient-upload-lab2').val('');
    $('input[name=\'remove_doc2\']').remove();
}

function removeDoc2() {
    $('#link-doc2').hide();
    $('#uploader2').show();
    $('#patient-upload-lab2').val('');
    $('#patient-upload-lab2').after('<input type="hidden" name="remove_doc2" value="1" />');
}

function distribute(obj) {
    
    $('#title-info').html('/ ' + obj.fact.title);
    $('#detail-mid').html(obj.screening_view.sick_family);
    $('#detail-fam-nik').html(obj.fact_screening.nik_family);
    $('#detail-nik').html(obj.fact_screening.nik);
    $('#detail-event').html(obj.fact_screening.event);
    $('#detail-name').html(obj.fact_screening.name);
    $('#detail-gender').html(obj.fact_screening.gid == 0 ? 'Perempuan' : 'Laki-laki');
    $('#detail-blood-type').html(obj.screening_view.blood_type);
    $('#detail-ttl').html(obj.fact_screening.pob + ', ' + obj.fact_screening.dob);
    $('#detail-father-name').html(obj.fact_screening.father_name);
    $('#detail-mother-name').html(obj.fact_screening.mother_name);
    $('#detail-famcardno').html(obj.fact_screening.famcardno);
    $('#detail-sick').html(obj.fact_screening.sick_years + ' Tahun, ' + obj.fact_screening.sick_months + ' Bulan.');
    $('#detail-gen').html(obj.fact_screening.gen);
    $('#detail-education').html(obj.fact_screening.lastedu);
    $('#detail-marital').html(obj.fact_screening.martype);
    $('#detail-childs').html(obj.fact_screening.childs + ' Anak');
    $('#detail-cellno').html(obj.fact_screening.cellno);
    $('#detail-job').html(obj.fact_screening.job);
    
    $('#detail-lab1').html(obj.fact_screening_result.lab1);
    $('#detail-hb').html(obj.fact_screening_result.hb);
    $('#detail-mcv').html(obj.fact_screening_result.mcv);
    $('#detail-mchc').html(obj.fact_screening_result.mchc);
    $('#detail-mch').html(obj.fact_screening_result.mch);
    $('#detail-lab2').html(obj.fact_screening_result.lab2);
    $('#detail-hba2').html(obj.fact_screening_result.hba2);
    $('#detail-hbf').html(obj.fact_screening_result.hbf);
    $('#detail-gen').html(obj.fact_screening_result.gen);
    
    if (obj.fact_screening_result.doc1 !== '') {
        var filePath = obj.fact_screening_result.doc1;
        var title = obj.fact_screening_result.file1;
        $('#detail-doc1').html(uploadResult(filePath, title));
    }
    
    if (obj.fact_screening_result.doc2 !== '') {
        var filePath = obj.fact_screening_result.doc2;
        var title = obj.fact_screening_result.file2;
        $('#detail-doc2').html(uploadResult(filePath, title));
    }
    
    var indi = '<code class="red-text">Terindikasi Thalassaemia</code>';
    if (obj.fact_screening_result.indi == 0) {
        indi = '<code>Tidak Terindikasi</code>';
    }
    $('#detail-indicate').html(indi);
    
    var addr = obj.fact_screening_address.addr;
    if (obj.fact_screening_address.villid !== 0) {
        addr += '<br /><small>';
        addr += '<i class="ti ti-location-pin"></i> ';
        addr += obj.fact_screening_address.province;
        addr += ' / ' + obj.fact_screening_address.city;
        addr += ' / ' + obj.fact_screening_address.district;
        addr += ' / ' + obj.fact_screening_address.postal;
        addr += '</small>';
    }
    
    $('#detail-address').html(addr);
    $('#detail-notes').html(nl2br(obj.fact.excerpt));
    $('#detail-edit-btn').attr('onclick', 'location.href=\'' + baseUrl + 'screening/' + obj.fact.slug + '/edit\'');
}

function uploadResult(filePath, title) {
    var o = '<a href="' + baseUrl + filePath + '" class="btn btn-link btn-sm" target="_blank" title="' + title + '">';
    o += '<i class="ti ti-file"></i> ' + title + '</a>';
    return o;
}

function screeningRemove(fid) {
    var factTitle = $('#title-for-' + fid).val();
    var ask = confirm('Anda yakin untuk hapus data screening (' + factTitle + ') ?');
    if (ask) {
        location.href = baseUrl + 'screening/' + fid + '/remove';
    }
}