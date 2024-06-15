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

function handler(data) {
    
    var out = '';
    if ($('#user-access-edit').val() == 1) {
        var url = baseUrl + 'patient/' + data.slug + '/edit';
        out += '<button class="btn btn-link btn-sm" onclick="location.href=\'' + url + '\'" title="Ubah">';
        out += '<i class="ti-pencil-alt"></i>';
        out += '</button>';
        out += ' ';
    }
    
    if ($('#user-access-remove').val() == 1) {
        out += '<button class="btn btn-link red-text btn-sm" onclick="patientRemove(\'' + data.fid + '\')" title="Hapus">';
        out += '<i class="ti-close"></i>';
        out += '</button>';
    }
    
    return out;
}

function itemDetail(data) {
    var link = '<button class="btn btn-link" onclick="clickDetail(\'' + data.slug + '\')" ';
    link += 'data-bs-toggle="modal" data-bs-target="#modal-patient-detail">' + data.mid + '</button>';
    link += '<input type="hidden" id="title-for-' + data.fid + '" value="' + data.title + '" />';
    return link;
}

function clickDetail(slug) {
    $('#patient-detail-slug').val(slug);
}

function patientRemove(factId) {
    var factTitle = $('#title-for-' + factId).val();
    var ask = confirm('Anda yakin untuk hapus data pasien (' + factTitle + ') ?');
    if (ask) {
        location.href = baseUrl + 'patient/' + factId + '/remove';
    }
}

function distribute(obj) {
    
    $('#title-info').html('/ ' + obj.fact.title);
    $('#detail-mid').html(obj.fact_patient.mid);
    $('#detail-nik').html(obj.fact_patient.nik);
    $('#detail-name').html(obj.fact_patient.name);
    $('#detail-gender').html(obj.fact_patient.gid == 0 ? 'Perempuan' : 'Laki-laki');
    $('#detail-blood-type').html(obj.patient_view.blood_type);
    $('#detail-ttl').html(obj.fact_patient.pob + ', ' + obj.fact_patient.dob);
    $('#detail-father-name').html(obj.fact_patient.father_name);
    $('#detail-mother-name').html(obj.fact_patient.mother_name);
    $('#detail-popti').html(obj.patient_view.popti);
    $('#detail-famcardno').html(obj.fact_patient.famcardno);
    $('#detail-sick').html(obj.fact_patient.sick_years + ' Tahun, ' + obj.fact_patient.sick_months + ' Bulan.');
    $('#detail-gen').html(obj.fact_patient.gen);
    $('#detail-education').html(obj.fact_patient.lastedu);
    $('#detail-marital').html(obj.fact_patient.martype);
    $('#detail-childs').html(obj.fact_patient.marchilds + ' Anak');
    $('#detail-warranty').html(obj.fact_patient.warrtype + ', ' + obj.fact_patient.warrno);
    $('#detail-unit').html(obj.patient_view.unit);
    $('#detail-cellno').html(obj.fact_patient.cellno);
    $('#detail-job').html(obj.fact_patient.job);
    
    var status = '<code>' + obj.fact_patient.status + '</code>';
    if (obj.fact_patient.status !== 'Aktif') {
        status = '<code class="red-text">' + obj.fact_patient.status + '</code>';
    }
    
    $('#detail-status').html(status);
    
    var addr = obj.fact_patient_address.addr;
    if (obj.fact_patient_address.villid !== 0) {
        addr += '<br /><small>';
        addr += '<i class="ti ti-location-pin"></i> ';
        addr += obj.fact_patient_address.province;
        addr += ' / ' + obj.fact_patient_address.city;
        addr += ' / ' + obj.fact_patient_address.district;
        addr += ' / ' + obj.fact_patient_address.postal;
        addr += '</small>';
    }
    
    $('#detail-address').html(addr);
    $('#detail-notes').html(nl2br(obj.fact.excerpt));
    $('#detail-edit-btn').attr('onclick', 'location.href=\'' + baseUrl + 'patient/' + obj.fact.slug + '/edit\'');
}

$(document).ready(function() {
    
    $('#modal-patient-detail').on('shown.bs.modal', function(e) {
        var slug = $('#patient-detail-slug').val();
        $.ajax({
           url: baseUrl + 'patient/' + slug,
           success: function(resp) {
               //console.log(resp);
               if (resp !== '') {
                    distribute($.parseJSON(resp));
               }
           }
        });
    });
    
    if ($('#patient-table').length) {
        var data = [
            { mData: null, mRender : function(data, type, full) { return itemDetail(data) } },
            { mData: 'nik' },
            { mData: 'name' },
            { mData: 'gender' },
            { mData: 'blood_type' },
            { mData: 'popti' },
            { mData: 'unit' },
            { mData: 'gen' },
            { mData: 'status' },
            { mData: 'created' },
        ];
        
        if ($('#user-access-edit').val() == 1 || $('#user-access-remove').val() == 1) {
            data.push({ mData: null, mRender: function(data, type, full) { return handler(data)} });
        }
        
        var api = baseUrl + 'patient/list';
        displayDataTable('patient-table', 25, 0, 0, 'desc', api, data);
        $('#patient-table_filter').css('margin-bottom', '10px');
        $('#patien-table_paginate').css('margin', '10px 0 20px 0');
    }
    
    if ($('#patient-form-add').length) {
        $('#patient-childs-input').hide();
    } else if ($('#patient-form-edit').length) {
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
    
    $('.form-reset').on('click', function() {
        formReset();
    });
    
    $('#patient-popti').change(function() {
        poptiMedicalOpts($(this).val());
    });
    
    $('#patient-form-add, #patient-form-edit').submit(function(e) {
        e.preventDefault();
        
        var id = $(this).attr('id');
        var postUrl = baseUrl + 'patient/add';
        const postData = patientPostData();
        if (id == 'patient-form-add') {
            postData.patient_add = 1;
        } else {
            postData.patient_edit = 1;
            postData.patient_id = $('#patient-id').val();
            postData.patient_cardno = $('#patient-cardno').val();
            postData.fact_id = $('#fact-id').val();
            postUrl = baseUrl + 'patient/' + $('#fact-slug').val() + '/edit';
        }
        
        //console.log(postData);
        $.ajax({
            url: postUrl,
            type: 'post',
            data: postData,
            beforeSend: function() {
                $('#patient-form-submit-result').remove();
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
                                if (!$('#' + key).is(':disabled')) {                                
                                }
                            }
                        }
                    }

                    var msg = 'Mohon perbaiki kesalahan pengisian berikut.';
                    $('.patient-form').before(pageAlert('patient-form-submit-result', msg, 'danger', true, 'alert'));
                    $('html, body').animate({scrollTop : 0}, 100);
                } else {
                    
                    var msg = 'data pasien <b>' + $('#patient-name').val() + '</b> berhasil disimpan.';
                    if (id == 'patient-form-add') {
                        msg = 'Penambahan ' + msg;
                        $('.form-control').val('');
                        $('.form-select').val('');
                    } else {
                        msg = 'Modifikasi ' + msg;
                    }
                    
                    var pa = pageAlert('patient-form-submit-result', msg, 'success', true, 'check');
                    $('.patient-form').before(pa);
                    formReset();
                }
            }
        });
        
        formAfterProcess();
    });
});

function patientPostData() {
    return {
        patient_nik : $('#patient-nik').val(),
        patient_cardno : $('#patient-cardno').val(),
        patient_name : $('#patient-name').val(),
        patient_blood_type : $('#patient-blood-type').val(),
        patient_gender : $('#patient-gender').val(),
        patient_dob : $('#patient-dob').val(),
        patient_pob : $('#patient-pob').val(),
        patient_father_name : $('#patient-father-name').val(),
        patient_mother_name : $('#patient-mother-name').val(),
        patient_address_provid : $('#patient-address-provid').val(),
        patient_address_citid : $('#patient-address-citid').val(),
        patient_address_distid : $('#patient-address-distid').val(),
        patient_address_villid : $('#patient-address-villid').val(),
        patient_address_rt : $('#patient-address-rt').val(),
        patient_address_rw : $('#patient-address-rw').val(),
        patient_address_postal : $('#patient-address-postal').val(),
        patient_address_phonecode : $('#patient-address-phonecode').val(),
        patient_address_phonecode_fix : $('#patient-address-phonecode-fix').val(),
        patient_address_details : $('#patient-address-details').val(),
        patient_popti : $('#patient-popti').val(),
        patient_popti_hospital : $('#patient-popti-hospital').val(),
        patient_duration_year : $('#patient-duration-year').val(),
        patient_duration_month : $('#patient-duration-month').val(),
        patient_gen_type : $('#patient-gen-type').val(),
        patient_education : $('#patient-education').val(),
        patient_marital : $('#patient-marital').val(),
        patient_childs : $('#patient-childs').val(),
        patient_job : $('#patient-job').val(),
        patient_warranty_type : $('#patient-warranty-type').val(),
        patient_warranty_account_number : $('#patient-warranty-account-number').val(),
        patient_phone : $('#patient-phone').val(),
        patient_status : $('input[name=\'patient_status\']').val(),
        patient_notes : $('#patient-notes').val(),
        patient_famcardno : $('#patient-family-cardno').val(),
    }
}

function formReset() {
    enableAllFields();
    removeValidInvalidClass();
    if ($('#patient-form-add').length) {
        $('#patient-popti').val('0');
        $('#patient-popti-hospital').html('<option value="0">-- Pilih Lembaga Kesehatan</option>');
        $('#patient-popti-hospital').val('0');
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

function poptiMedicalOpts(id) {
    $.ajax({
        url: baseUrl + 'popti/units/' + id,
        success: function(resp) {
            console.log(resp);
            $('#patient-popti-hospital').html(resp);
        }
    });
}