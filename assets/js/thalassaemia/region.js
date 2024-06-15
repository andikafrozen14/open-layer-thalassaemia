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

$(document).ready(function() {
    $('#modal-region').on('shown.bs.modal', function() {
        var data = [
            { mData: null, mRender: function(data, type, full) { return pickRecord(data, type, full)} },
            { mData: 'province' },
            { mData: 'city' },
            { mData: 'district' },
            { mData: 'village' },
            { mData: 'postal' },
            { mData: 'phone_code' },
        ];
        
        var api = baseUrl + 'region/pick-list';
        var table = displayDataTable('region-picker', 10, 0, 1, 'asc', api, data);
        $('#region-picker_filter').css('margin-bottom', '10px');
        $('#region-picker_paginate').css('margin-top', '10px');
    });
});

function pickRecord(data, type, full) {
    
    const obj = [
        data.province,
        data.province_id,
        data.city,
        data.city_id,
        data.district,
        data.district_id,
        data.village,
        data.village_id,
        data.postal,
        data.phone_code
    ];
    
    var act = 'onclick="pickLocation(\'' + obj.join('~') + '\')"';
    var btn = '<button class="btn btn-outline-primary btn-block btn-sm" data-bs-dismiss="modal" ' + act + '>'
        +'<i class="ti ti-hand-point-up"></i> Pilih</button>';
    return btn;
}

function pickLocation(obj) {
    
    var data = obj.split('~');
    $('.address-notes').remove();
    $('#address-province').val(data[0]);
    $('#address-province').after('<small class="form-hint address-notes mb-1">Provinsi.</small>');
    $('#patient-address-provid').val(data[1]);
    
    $('#address-city').val(data[2]);
    $('#address-city').after('<small class="form-hint address-notes mb-1">Kota / Kabupaten.</small>');
    $('#patient-address-citid').val(data[3]);
    
    $('#address-district').val(data[4]);
    $('#address-district').after('<small class="form-hint address-notes mb-1">Kecamatan.</small>');
    $('#patient-address-distid').val(data[5]);
    
    $('#address-village').val(data[6]);
    $('#address-village').after('<small class="form-hint address-notes mb-1">Kelurahan.</small>');
    $('#patient-address-villid').val(data[7]);
    
    $('#patient-address-postal').val(data[8]);
    $('#patient-address-phonecode').val(data[9]);
    $('#patient-address-phonecode-fix').val(data[9]);
}