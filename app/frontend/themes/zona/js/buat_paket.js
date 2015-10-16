document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    (function ($) {
        $('.bt-sm-edt').click(function (event) {
//            console.log('clicked');
//            console.log($(this));
            if ($(this).text() == 'Edit') {
                var theText = $(this).parent().parent().find('input[type=hidden]');
                theText.attr('type', 'number');
                $(this).parent().parent().find('label').hide();
                $(this).text('Ok');
            }
            else {
                var theText = $(this).parent().parent().find('input[type=number]');
                var dataExt = theText.data('ext');
                //console.log(theText);
                var newVal = theText.val();
                var maxVal = theText.data('max');
                if (maxVal >= newVal) {
                    theText.attr('type', 'hidden');
                    $(this).parent().parent().find('label').text(newVal + ' ' + dataExt);
                    $(this).parent().parent().find('label').show();
                    $(this).parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((maxVal - newVal) + ' ' + dataExt);
                    $(this).text('Edit');
                }
                else {
                    alert('Maksimal nilai yang dapat di set adalah: ' + maxVal + ' ' + dataExt);
                }
            }
        });
        $('#frmBuatPaket').submit(
                function (e) {
                    if ($(this).valid()) {
                        $.ajax({
                            url: baseUrl + 'ajaxBuatPaketBaru.php',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            success: function (resp) {
                                if (!resp.success) {
                                    var statusCode = resp.status;
                                    swal('Gagal!', resp.message, 'error');
                                    switch (statusCode) {
                                        //harus cek detail , di redirect
                                        case 301:
                                            var failedairline=resp.failed
                                            for(var zX in failedairline){
                                            window.open = baseUrl + '?page=detail-paket&airline='+failedairline[zX]+'&paket='+$('#frmBuatPaket input[name=nama]').val();
                                        }
                                            break;
                                    }
                                }
                                else {
                                    swal(resp.message, '', 'success');
                                    window.location = baseUrl + '?page=setting-paket';
                                }
                            },
                            error: function (resp) {

                            }

                        });
                    }
                    e.preventDefault();
                });
        $('#savePaket').click(function () {
            if ($('#frmBuatPaket').valid()) {
                swal({
                    title: 'Simpan Paket ini?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tunggu dulu',
                    closeOnConfirm: false
                }, function (isConfirmed) {
                    if (isConfirmed) {
                        swal.disableButtons();
                        $('#frmBuatPaket').submit();
                    }

                });//swal
            }
        });

        $('input[name="jenis"][type="checkbox"]').click(function (evt) {
            var thisCheckBox = $(this);
            var isNowChecked = (thisCheckBox.is(':checked'));
            if (isNowChecked) {
                var theBiaya=thisCheckBox.closest('input[name=biaya]');
                console.log(thisCheckBox);
            }
            else {

            }
        });


    })(jQuery);
});