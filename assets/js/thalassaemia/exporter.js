$(document).ready(function() {
    $('#temp-uploader').hide();
    $('form.export-form').submit(function(e) {
         e.preventDefault();
        
        var fid = $(this).attr('id');
        var url = baseUrl;
        if (fid == 'patient-form-export') {
            url = window.location.href;
        }
        
        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(this),
            beforeSend: function() {
                $('#export-result').remove();
                $('.form-control').attr('disabled', true);
                $('.form-select').attr('disabled', true);
                $('.form-check-input').attr('disabled', true);
                $('.btn').attr('disabled', true);
                $('#process-result').html('<img src="' + basicLoader + '" id="form-loader" />');
            },
            complete: function() {
                $('.form-control').attr('disabled', false);
                $('.form-select').attr('disabled', false);
                $('.form-check-input').attr('disabled', false);
                $('.btn').attr('disabled', false);
                $('#process-result').html('');
            },
            success: function(resp) {
                console.log(resp);
                var msg = 'Data tidak ditemukan. Tentukan kriteria pencarian yang lebih tepat.';
                var alt = 'warning';
                var fav = 'alert';
                var obj = $.parseJSON(resp);
                if (obj.code == 200) {
                    var link = baseUrl + 'export/' + obj.fname;
                    var file = '<a href="' + link + '" id="file-download">' + obj.fname + '</a>';
                    msg = 'Dokumen berhasil dibuat. ';
                    msg += 'Silahkan unduh <b>' + file + '</b>';
                    alt = 'success';
                    fav = 'check';
                    location.href=link;
                }
                
                var n = pageAlert('export-result', msg, alt, true, fav);
                $('.export-form').before(n);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});