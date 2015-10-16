document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    jQuery.detailPaketHasSaved = true;
    (function ($) {

        $('.bt-sm-edt').click(function (event) {
//            console.log('clicked');
//            console.log($(this));
            if ($(this).text() == 'Edit') {
                var theText = $(this).parent().parent().find('input[type=hidden]');
                var hasDiff = theText.data('hasdiff') == 1 ? true : false;
                if (hasDiff) {
                    var cfmChange = confirm("Pengaturan berbeda di setiap kelas maskapai.\n "
                            + "Jika Anda mengatur dari sini, semua pengaturan akan di sama ratakan.\n"
                            + "Untuk melakukan pengaturan secara spesifik, lakukan pengaturan pada tiap masing-masing maskapai.\n"
                            + "Lanjutkan untuk melakukan pengaturan global?");
                    if (!cfmChange) {
                        event.preventDefault();
                        return false;
                    }
                }
                theText.attr('type', 'number');
                $(this).parent().parent().find('label').hide();
                $(this).text('Ok');
            }
            else {
                jQuery.detailPaketHasSaved = false;
                var theText = $(this).parent().parent().find('input[type=number]');
                var dataExt = theText.data('ext');
                var hasDiff = theText.data('hasdiff') == 1 ? true : false;
                //console.log(theText);
                var newVal = theText.val();
                var maxVal = theText.data('max');
                if (maxVal >= newVal) {
                    var faIcon = hasDiff
                            ? '<i title="Semua pengaturan akan di reset dan diatur ulang menjadi ' + newVal + ' ' + dataExt + '" class="fa fa-exclamation-circle"></i>'
                            : '';
                    theText.attr('type', 'hidden');
                    $(this).parent().parent().find('label').html(newVal + ' ' + dataExt + ' ' + faIcon);
                    $(this).parent().parent().find('label').show();

                    $(this).parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((maxVal - newVal) + ' ' + dataExt);
                    $(this).text('Edit');
                }
                else {
                    alert('Maksimal nilai yang dapat di set adalah: ' + maxVal + ' ' + dataExt);
                }
            }
        });

        $('form.frmEditDetailPaket').submit(function (evt) {
            var thisVal = $(this).serialize();
            console.log(thisVal);
            if ($(this).valid()) {
                $.ajax({
                    url: baseUrl + 'ajaxUpdateDetailPaket.php',
                    data: thisVal,
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        $(this).find('.buttonUpdateDetailPaket').attr('disabled', 'disabled');
                    },
                    success: function (resp) {
                        if (resp.success) {
                            jQuery.detailPaketHasSaved = true;
                            alert('Update berhasil');
                            window.location = baseUrl + '?page=setting-paket'
                        } else {
                            alert(resp.message);
                        }
                    },
                    error: function () {

                    },
                    complete: function () {
                        $(this).find('.buttonUpdateDetailPaket').removeAttr('disabled');
                    }
                });
            }
            else {
                console.log('Notvalid');
            }
            evt.preventDefault();
        });
        $('.buttonUpdateDetailPaket').click(function (evt) {
            console.log($(this));
            $(this).parent().parent().submit();
        });
        $(window).bind('beforeunload', function () {

            if ($.detailPaketHasSaved === false) {
                return 'Data belum disimpan, Keluar dari Laman?';
            };

        });
    })(jQuery);
});