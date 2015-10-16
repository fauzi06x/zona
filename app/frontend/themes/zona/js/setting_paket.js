document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    (function ($) {

        $('.bt-sm-edt').click(function (event) {
            var thisBtnSmEdit = $(this);
//            console.log('clicked');
//            console.log($(this));
            if (thisBtnSmEdit.text() == 'Edit') {
                thisBtnSmEdit.parent().find('.btn-sm-cancel').show();
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
                        url: baseUrl + 'ajax/updateSettingPaket.php',
                        type: 'POST',
                        dataType: 'JSON',
                        beforeSend: function (xhr) {
                            thisBtnSmEdit.text('Updating...');
                        },
                        data: {
                            airline: {id: theText.data('maskapai-id'), name: theText.data('maskapai')},
                            type: theText.data('tipe'),
                            id: theText.data('paketname'),
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
                                swal('Berhasil','Update Global Berhasil.','success');

                            }
                            else {

                                var faIcon = hasDiff
                                        ? '<i title="Diambil nilai terkecil" class="fa fa-exclamation-circle"></i>'
                                        : '';
                                theText.val(prevVal);
                                thisBtnSmEdit.parent().parent().find('label').html(prevVal + ' ' + dataExt + ' ' + faIcon);
                                thisBtnSmEdit.parent().parent().parent().find('td.result-' + (dataExt == 'IDR' ? 'komisi' : 'diskon')).text((maxVal - prevVal) + ' ' + dataExt);
                                var msg = typeof (resp.message) == 'undefined' ? 'Update Global Gagal, silakan coba lagi' : resp.message;
                                swal('Gagal',msg,'error');
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
                    swal('Peringatan','Maksimal nilai yang dapat di set adalah: ' + maxVal + ' ' + dataExt,'warning');
                }
            }
        });

        $('.edit-harga-registrasi').click(function () {
            var inOkModeText = 'Edit Harga';
            var inEditModeText = 'Update';
            var thisButton = $(this);

            var theLabel = thisButton.parent().find('span label');
            if (thisButton.text() == inOkModeText) {
                var theTextField = thisButton.parent().find('input[type=hidden]');
                theLabel.hide();
                theTextField.attr('type', 'text');
                thisButton.text(inEditModeText);
            }
            else {
                var theTextField = thisButton.parent().find('input[type=text]');
                var newVal = theTextField.val();
                var prevVal = theTextField.data('prefval');
                var paketName = theTextField.data('paket');
                $.ajax({
                    url: baseUrl + 'ajax/updateBiayaRegistrasiPaket.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        newval: newVal,
                        paket: paketName,
                    },
                    success: function (resp) {
                        console.log(resp);
                        if (resp.success) {
                            theLabel.text('Rp. ' + parseFloat(newVal).formatMoney() + ' ,-');
                            theTextField.data('prefval', newVal);
                            swal('Berhasil','Update sukses','success');
                        }
                        else {
                            theLabel.text('Rp. ' + parseFloat(prevVal).formatMoney() + ' ,-');
                            var message = typeof (resp.message) == 'undefined' ? 'Hubungi CS Kami' : resp.message;
                            swal('Update Gagal!', message, 'error');
                        }
                    },
                    error: function (resp) {
                        theLabel.text('Rp. ' + parseFloat(prevVal).formatMoney() + ' ,-');

                    },
                    beforeSend: function (xHr) {
                        thisButton.text('Processing...');
                    },
                    complete: function (xHr) {
                        thisButton.text(inOkModeText);
                        theLabel.show();
                    }
                });
                theTextField.attr('type', 'hidden');

            }
        });//update biaya registrasi
        $('.generate-code').click(function (evt) {
            var thisButton = $(this);
            var cfmGeneratePaket = confirm('Generate Kode Promo akan membuat kode promo Anda yang aktif sekarang menjadi tidak valid.'
                    + "\nLanjutkan?");
            if (!cfmGeneratePaket) {
                return false;
            }
            $.ajax({
                url: baseUrl + 'ajax/generateCodePromo.php',
                type: 'POST',
                data: {
                    paket: thisButton.data('paket')
                },
                beforeSend: function (xhr) {

                },
                success: function (resp) {
                    if (resp.success) {
                        thisButton.parent().find('div.code-generated').text(resp.code);
                    }
                    else {
                        swal('Gagal',typeof (resp.message) == 'undefined' ? 'Gagal Ambil Kode Promo. Hubungi CS Kami.' : resp.message,'error');
                    }
                },
                complete: function (xhr) {
                },
                error: function (xhr) {

                }
            });
        });
        $('.fa-toggle-table').click(function (etS) {
            var thisFa = $(this);
            console.log(thisFa);
            if (thisFa.find('i').hasClass('fa-minus')) {
                thisFa.find('i').removeClass('fa-minus');
                thisFa.find('i').addClass('fa-plus');
                thisFa.parent().next('table').hide();
            }
            else if (thisFa.find('i').hasClass('fa-plus')) {
                thisFa.find('i').removeClass('fa-plus');
                thisFa.find('i').addClass('fa-minus');
                thisFa.parent().next('table').show();
            }
        });
    })(jQuery);
});