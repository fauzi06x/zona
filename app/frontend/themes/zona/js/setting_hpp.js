document.addEventListener("DOMContentLoaded", function (event) {
    jQuery.settingHppHasSaved = true;
    (function ($) {
        var oneWeekInMiliSec = 7 * 24 * 60 * 60 * 1000;

        $('.bt-sm-edt').click(function (event) {
            var thisBtnSmEdit = $(this);
            var theCancelButton = $(this).parent().find('.bt-sm-cancel');
//            console.log('clicked');
//            console.log($(this));
            if (thisBtnSmEdit.text() == 'Edit') {
                theCancelButton.show();
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
                var prevVal = theText.val();
                theText.data('prevVal', prevVal);
                theText.attr('type', 'number');
                $(this).parent().parent().find('label').hide();
                $(this).text('Ok');
            }
            else if (thisBtnSmEdit.text() == 'Ok') {
                var theText = $(this).parent().parent().find('input[type=number]');

                var dataExt = theText.data('ext');
                var prevVal = theText.data('prevVal');
                var newVal = theText.val();
                var maxVal = theText.data('max');
                console.log(prevVal);
                var cfmUpdateGlobal = confirm("Lakukan Update?");
                if (!cfmUpdateGlobal) {
                    theCancelButton.hide();
                    var faIcon = hasDiff
                            ? '<i title="Diambil nilai terkecil" class="fa fa-exclamation-circle"></i>'
                            : '';
                    theText.val(prevVal);
                    thisBtnSmEdit.parent().parent().find('label').html(prevVal + ' ' + dataExt + ' ' + faIcon);
                    theText.attr('type', 'hidden');
                    thisBtnSmEdit.parent().parent().find('label').show();
                    thisBtnSmEdit.parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((parseFloat(maxVal) - parseFloat(prevVal)) + ' ' + dataExt);
                    thisBtnSmEdit.text('Edit');
                    thisBtnSmEdit.parent().find('.btn-sm-cancel').hide();
                    return false;
                    event.preventDefault();
                }
                var hasDiff = theText.data('hasdiff') == 1 ? true : false;
                //console.log(theText);
                if (maxVal >= newVal) {
                    $.ajax({
                        url: baseUrl + 'ajax/updateSettingHpp.php',
                        type: 'POST',
                        dataType: 'JSON',
                        beforeSend: function (xhr) {
                            thisBtnSmEdit.text('Updating...');
                            theCancelButton.hide();
                        },
                        data: {
                            airline: {id: theText.data('maskapai-id'), name: theText.data('maskapai')},
                            type: theText.data('tipe'),
                            profit_type: theText.data('profit_type'),
                            value: newVal
                        },
                        success: function (resp) {

                            if (resp.success) {
                                var faIcon = hasDiff
                                        ? '<i title="Semua pengaturan akan di reset dan diatur ulang menjadi ' + newVal + ' ' + dataExt + '" class="fa fa-exclamation-circle"></i>'
                                        : '';
                                thisBtnSmEdit.parent().parent().find('label').html(newVal + ' ' + dataExt + ' ' + faIcon);
                                thisBtnSmEdit.parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((maxVal - newVal) + ' ' + dataExt);
                                theText.val(newVal);
                                alert('Update Global Berhasil.');

                            }
                            else {

                                var faIcon = hasDiff
                                        ? '<i title="Diambil nilai terkecil" class="fa fa-exclamation-circle"></i>'
                                        : '';
                                theText.val(prevVal);
                                thisBtnSmEdit.parent().parent().find('label').html(prevVal + ' ' + dataExt + ' ' + faIcon);
                                thisBtnSmEdit.parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((maxVal - prevVal) + ' ' + dataExt);
                                var msg = typeof (resp.message) == 'undefined' ? 'Update Global Gagal, silakan coba lagi' : resp.message;
                                alert(msg);
                            }

                        },
                        complete: function (xhr) {
                            theText.attr('type', 'hidden');
                            thisBtnSmEdit.parent().parent().find('label').show();
                            thisBtnSmEdit.text('Edit');
                            thisBtnSmEdit.parent().find('.btn-sm-cancel').hide();
                        }

                    });

                }
                else {
                    alert('Maksimal nilai yang dapat di set adalah: ' + maxVal + ' ' + dataExt);
                }
            }
        });
        $('.bt-sm-cancel').click(function () {
            var thisBtnCancel = $(this);
            var theOkButton = thisBtnCancel.parent().find('.bt-sm-edt');
            var theInputField = thisBtnCancel.parent().parent().find('input');
            var theLabel = thisBtnCancel.parent().parent().find('label');
            var prevVal = theInputField.data('prevVal');
            theInputField.val(prevVal);
            theInputField.attr('type', 'hidden');
            theLabel.show();
            theOkButton.html('Edit');
            thisBtnCancel.hide();


        });//.bt-sm-cancel

        $('x.generate-code').click(function (exd) {
            var expCodeDtPckr = $('#datepickerExpKode').val();
            var expCode = $('#datepickerExpKode').val().split('-').join(' ');
            var dateExpCode = new Date(expCode);
            var range = (serverTimeRun.getTime() + oneWeekInMiliSec) - dateExpCode.getTime();
            if (expCodeDtPckr === '') {
                swal('Tanggal tidak valid', 'Harap tentukan tanggal expired', 'error');
            } else if (range < 1) {
                swal('Tanggal tidak valid', 'Tanggal tidak boleh melebihi 7 hari dari hari ini', 'error');
            }
            else if (range > oneWeekInMiliSec) {
                swal('Tanggal tidak valid', 'Tanggal tidak boleh kurang dari hari ini', 'error');

            }
            else {
                console.log(range);
                console.log(oneWeekInMiliSec);
                var theTextHtml = 'Meng-<span style="font-style:italic">generate</span> ulang kode promo akan membuat kode promo Anda sebelumnya menjadi tidak berlaku.<br/> Lanjutkan?';

                swal({
                    title: 'Generate kode baru!',
                    html: theTextHtml,
                    type: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                    closeOnConfirm: false
                }, function (cfM) {
                    if (cfM) {

                        $.ajax({
                            url: baseUrl + 'ajax/getCodePromo.php',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                promo_expired: expCodeDtPckr
                            },
                            beforeSend: function (xhr) {
                                swal.disableButtons();
                            },
                            success: function (data, textStatus, jqXHR) {
                                if (data.success) {
                                    $('.code-generated').text(data.kode_promo);
                                    swal('Berhasil!', 'Kode promo Anda : ' + data.kode_promo, 'success');
                                }
                                else {
                                    swal('Gagal', data.message, 'error');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                swal('Gagal', 'Server tidak dapat menangani permintaan. Silakan coba lagi.', 'error');
                            },
                            complete: function (jqXHR, textStatus) {

                            }
                        });
                    }
                });//swal
            }
        });

        //run time from server
        getServerTimeRun();
        jQuery('#datepickerExpKode').datetimepicker({
            dateFormat: 'dd-M-yy',
            timeFormat: 'HH:mm',
            minDate: new Date(),
            maxDate: new Date(serverTimeRun.getTime() + oneWeekInMiliSec)
        });

    })(jQuery);
});