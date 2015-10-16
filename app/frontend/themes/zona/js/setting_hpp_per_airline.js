document.addEventListener('DOMContentLoaded', function () {
    jQuery.detailHPPHasSaved = {};
    (function ($) {


        $('.bt-sm-edt').click(function (event) {

            var thisButtonEdit = $(this);
            $.detailHPPHasSaved["" + thisButtonEdit.data('maskapai') + ""] = false;
            var theCancelButton = $(this).parent().find('.bt-sm-cancel');
//            console.log('clicked');
//            console.log($(this));
            if ($(this).text() == 'Edit') {
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
                    theCancelButton.hide();
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
        $('.buttonUpdateDetailHpp').click(function (event) {
            var thisUpdatePerMaskapaiButton = $(this);
            var airlineName = thisUpdatePerMaskapaiButton.data('maskapai');
            var theTable=thisUpdatePerMaskapaiButton.parent().parent().find('table');
            var allOkButton = theTable.find('.bt-sm-edt');
            var allInputField = theTable.find('input');
            console.log(theTable);
            var allValues = allInputField.serializeArray();
            var readyToSend = true;
            allOkButton.each(function (eX) {
                var thisOkB = $(allOkButton[eX]);
                if (thisOkB.text() == 'Ok') {
                    var theInputField = thisOkB.parent().parent().find('input[type=number]');
                    if (parseInt(theInputField.val()) > parseInt(theInputField.data('max'))) {
                        alert('Maksimal nilai yang dapat di set adalah:' + theInputField.data('max') + ' %');
                        readyToSend = false;
                        theInputField.focus();
                        return false;
                    }
                    else {
                        thisOkB.click();
                    }
                }

            });
            if (readyToSend) {
                swal({
                    title: 'Konfirmasi HPP ' + airlineName + '',
                    html: 'Anda akan meng-<span style="font-style:italic">update</span> HPP maskapai ' + airlineName + ', Lanjutkan?',
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
                        swal.disableButtons();
                        $.ajax({
                            url: baseUrl + 'ajax/updateSettingHppDetails.php',
                            dataType: 'JSON',
                            type: 'POST',
                            data: allValues,
                            success: function (data, textStatus, jqXHR) {
                                var updatedAirlineStatus = data[0];
                                console.log(updatedAirlineStatus);
                                if (updatedAirlineStatus.result.success) {
                                    $.detailHPPHasSaved["" + updatedAirlineStatus.airline_name + ""] = true;
                                    swal({
                                        title: 'Berhasil!',
                                        text: 'HPP maskapai ' + airlineName + ' berhasil di Update',
                                        type: 'success',
                                        timer: 2000
                                    });
                                }
                                else {

                                    swal({
                                        title: 'Gagal!',
                                        allowOutsideClick: false,
                                        text: updatedAirlineStatus.result.message, //'HPP maskapai ' + airlineName + ' gagal di Update',
                                        type: 'error'
                                                //,timer: 5000
                                    });

                                }
                            },
                            beforeSend: function (xhr) {

                            },
                            complete: function (jqXHR, textStatus) {

                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                swal({
                                    title: 'Gagal!',
                                    allowOutsideClick: false,
                                    text: 'Server tidak dapat menangani permintaan. Silakan coba lagi.',
                                    type: 'error'
                                            //,timer: 5000
                                });
                            }
                        });
                    }

                });//swal
            }
        });//.buttonUpdateDetailHpp.click
        
        
        $('.bt-sm-cancel').click(function(){
           var thisBtnCancel=$(this);
           var theOkButton=thisBtnCancel.parent().find('.bt-sm-edt');
           var theInputField=thisBtnCancel.parent().parent().find('input');
           var theLabel=thisBtnCancel.parent().parent().find('label');
           var prevVal=theInputField.data('prevVal');
           theInputField.val(prevVal);
           theInputField.attr('type','hidden');
           theLabel.show();
           theOkButton.html('Edit');
           thisBtnCancel.hide();           
           
           
        });
        
        
        
        $('#btnUpdateAll').click(function (event) {
            var thisUpdateAllButton = $(this);
            var isReadyToSend = true;
            var btSMEdt = $('.bt-sm-edt');
            btSMEdt.each(function (iX) {
                if ($(btSMEdt[iX]).text() == 'Ok') {
                    if (parseInt($(btSMEdt[iX]).parent().parent().find('input[type=number]').val())
                            > parseInt($(btSMEdt[iX]).parent().parent().find('input[type=number]').data('max'))) {
                        isReadyToSend = false;
                        alert('Maksimal nilai yang dapat di set adalah:' + $(btSMEdt[iX]).parent().parent().find('input[type=number]').data('max') + ' %');
                        $(btSMEdt[iX]).parent().parent().find('input[type=number]').focus();
                        return false;
                    }
                    else {
                        $(btSMEdt[iX]).click();
                    }
                }
            });
            var allEachUpdateButton = thisUpdateAllButton.parent().parent().find('.buttonUpdateDetailHpp');
            var allValues = thisUpdateAllButton.parent().parent().find('input').serializeArray();
            if (isReadyToSend) {
                swal({
                    title: 'Konfirmasi Update Keseluruhan',
                    html: 'Anda akan meng-<span style="font-style:italic">update</span> semua HPP maskapai sekaligus, Lanjutkan?',
                    type: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, update semua',
                    cancelButtonText: 'Batal',
                    closeOnConfirm: false
                }, function (cfM) {
                    if (cfM) {
                        swal.disableButtons();
                        $.ajax({
                            url: baseUrl + 'ajax/updateSettingHppDetails.php',
                            dataType: 'JSON',
                            type: 'POST',
                            data: allValues,
                            success: function (data, textStatus, jqXHR) {
                                var failedAirline = [];
                                for (var X in data) {
                                    if (!data[X].result.success) {
                                        var airlineInfo = {};
                                        airlineInfo.name = data[X].airline_name;
                                        airlineInfo.classes = data[X].result.classes;
                                        var strSelectorInput = [];
                                        var strSelectorLabel = [];
                                        for (var cX in data[X].result.classes) {
                                            strSelectorInput.push('input[name="diskon[' + data[X].airline_name + '][' + data[X].result.classes[cX] + ']"]');
                                            strSelectorLabel.push('label[data-maskapai="' + data[X].airline_name + '-' + data[X].result.classes[cX] + '"]');
                                        }
                                        ;
                                        var allInputsNeedToCheck = $(strSelectorInput.join(','))
                                        var allLabelNeedToHide = $(strSelectorLabel.join(','));
                                        allLabelNeedToHide.hide();
                                        allInputsNeedToCheck.each(function (inDx) {
                                            var thisInput = allInputsNeedToCheck[inDx];
                                            $(thisInput).parent().find('.bt-sm-edt').text('Ok');
                                            $(thisInput).parent().find('.bt-sm-cancel').show();
                                        });
                                        allInputsNeedToCheck.attr('type', 'number');
                                        failedAirline.push(airlineInfo);
                                    }
                                    else {
                                        $.detailHPPHasSaved["" + data[X].airline_name + ""] = true;
                                    }
                                    ;
                                }
                                ;
                                var restToCheck = data.length - failedAirline.length;
                                var isAllSuccess = restToCheck == data.length;
                                var isAllFailed = data.length == failedAirline.length;
                                if (isAllSuccess) {

                                    swal({
                                        title: 'Berhasil!',
                                        text: 'HPP seluruh maskapai berhasil di Update',
                                        type: 'success',
                                        timer: 2000
                                    });
                                }
                                else {
                                    var textMessage = '';
                                    var titleMessage = '';
                                    var typeMessage = 'error';
                                    if (isAllFailed) {
                                        textMessage = 'Semua pengaturan gagal diUpdate';
                                        titleMessage = 'Semua Gagal!';


                                    }
                                    else {
                                        textMessage = 'Beberapa pengaturan gagal diUpdate:<ol>';
                                        for (var fA in failedAirline) {
                                            textMessage += '<li>' + failedAirline[fA].name + '</li>';
                                        }
                                        textMessage += '</ol>';
                                        titleMessage = 'Gagal beberapa!';
                                        typeMessage = 'warning';
                                    }

                                    swal({
                                        title: titleMessage,
                                        allowOutsideClick: false,
                                        html: textMessage, //'HPP maskapai ' + airlineName + ' gagal di Update',
                                        type: typeMessage
                                                //,timer: 5000
                                    });
                                }
                            },
                            beforeSend: function (xhr) {
                                allEachUpdateButton.each(function (iX) {
                                    var maskapaiName = ($(this).data('maskapai'));
                                    if (typeof (maskapaiName) == 'string') {
                                        $.detailHPPHasSaved["" + maskapaiName.trim().toUpperCase() + ""] = false;
                                    }
                                    ;
                                });
                                console.log($.detailHPPHasSaved);
                            },
                            complete: function (jqXHR, textStatus) {

                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                swal({
                                    title: 'Gagal!',
                                    allowOutsideClick: false,
                                    text: 'Server tidak dapat menangani permintaan. Silakan coba lagi.',
                                    type: 'error'
                                            //,timer: 5000
                                });
                            }
                        });

                    }
                });//swal
            }
        });



        $(window).bind('beforeunload', function () {
            var okToQuit = true;
            var strAirlineName = [];
            for (var dH in $.detailHPPHasSaved) {
                if ($.detailHPPHasSaved[dH] == false) {
                    strAirlineName.push(dH);
                    okToQuit = false;
                }
            }
            if (okToQuit === false) {
                return 'Data ' + (strAirlineName.join(', ')) + ' belum disimpan, Keluar dari Laman?';
            }
            ;

        });




    })(jQuery);
});