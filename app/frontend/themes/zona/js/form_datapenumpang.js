document.addEventListener("DOMContentLoaded", function (eventContentLoaded) {
    var dtPickerBdateConfig = {
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
        dateFormat: 'dd/mm/y',
    };
    jQuery.dtTableListPsgr = '';
    jQuery.clickListPassenggerButton = function (thisHtml) {
        jQuery(thisHtml).click(function (event) {
            var thisDiv = jQuery(this);
            jQuery('.dt-list[data-target="1"]').each(function () {
                jQuery(this).removeAttr('data-target');
            });
            thisDiv.attr('data-target', 1);
            if (jQuery('#dtTableListPsgr').length == 0) {
                var htmlDialog = '<table class="kd-prom" id="dtTableListPsgr">'
                        + '<thead><tr>'
                        + '<th>#</th>'
//                        + '<th>Type</th>'
                        + '<th>Title</th>'
                        + '<th>First Name</th>'
                        + '<th>Last Name</th>'
                        + '<th>ID Number</th>'
                        + '<th>Birthdate</th>'
                        + '<th>Action</th>'
                        + '</tr></thead>'
                        + '<tbody>'
                        + '</tbody>'
                        + '</table>';
                jQuery('.dialog').html(htmlDialog);
                $(".dialog").dialog("option", "open", function (event, ui) {
                    $(".ui-dialog-titlebar-close", ui.dialog | ui).show();
                });

                jQuery.dtTableListPsgr = jQuery('#dtTableListPsgr').DataTable({
                    ajax: {
                        url: baseUrl + 'ajax/listPassenggers.php',
                        type: 'POST',
                        data: function (dt) {
                            dt.type = jQuery('.dt-list[data-target="1"]').data('type')
                        }
                    },
                    serverSide: true,
                    processing: true,
                    columns: [
                        {data: "num", orderable: false},
                        //                      {data: "ty"},
                        {data: "ttl"},
                        {data: "fn"},
                        {data: "ln"},
                        {data: "idn"},
                        {data: "bd", render: function (data, type, full, meta) {
                                var splitData = data.split(' ');
                                var nD = new Date(splitData[0]);
                                var date = nD.getDate();
                                var month = nD.getMonth() + 1;
                                var year = nD.getYear();
                                date = String(date).length < 2 ? '0' + date : date;
                                date = String(date).length == 2 ? date : String(date).substr(String(date).length - 2);

                                month = String(month).length < 2 ? '0' + month : month;
                                month = String(month).length == 2 ? month : String(month).substr(String(month).length - 2);

                                year = String(year).length < 2 ? '0' + year : year;
                                year = String(year).length == 2 ? year : String(year).substr(String(year).length - 2);
                                return date + '/' + month + '/' + year;


                            }},
                        {data: "id", render: function (data, type, full, meta) {
                                var dataStr = '';
                                for (var x in full) {
                                    dataStr += ' data-' + x + '="' + full[x] + '"';
                                }
                                return '<i ' + dataStr + ' style="cursor:pointer" class="fa fa-check-circle"></i>';
                            }
                        },
                    ]
                });
                jQuery.dtTableListPsgr.on('draw', function () {
                    jQuery.each(jQuery("i.fa.fa-check-circle"), function () {
                        $(this).click(function () {

                            jQuery("i.fa.fa-check-circle").each(function () {
                                $(this).removeClass('green-text');
                            });
                            $(this).addClass('green-text');
                            var ulParent = jQuery('.dt-list[data-target=1]').parent().parent();
                            console.log($(this).data('fn'));
                            ulParent.find('input[data-field="fn"]').val($(this).data('fn'));
                            ulParent.find('input[data-field="ln"]').val($(this).data('ln'));
                            ulParent.find('input[data-field="idn"]').val($(this).data('idn'));

                            var splitData = $(this).data('bd').split(' ');
                            var nD = new Date(splitData[0]);
                            var date = nD.getDate();
                            var month = nD.getMonth() + 1;
                            var year = nD.getYear();
                            date = String(date).length < 2 ? '0' + date : date;
                            date = String(date).length == 2 ? date : String(date).substr(String(date).length - 2);

                            month = String(month).length < 2 ? '0' + month : month;
                            month = String(month).length == 2 ? month : String(month).substr(String(month).length - 2);

                            year = String(year).length < 2 ? '0' + year : year;
                            year = String(year).length == 2 ? year : String(year).substr(String(year).length - 2);
                            var dmYSlash = date + '/' + month + '/' + year;

                            ulParent.find('input[data-field="bd"]').val(dmYSlash);
                            ulParent.find('input[data-field="ttl"]').val($(this).data('ttl'));
                            //ulParent.find('input[data-field="fn"]').val($(this).data('fn'));
                        });

                    })
                });

            }
            ;
            jQuery.dtTableListPsgr.ajax.reload();
            jQuery('.dialog').dialog('option', 'width', 700);
            jQuery('.dialog').dialog('open');
        });

    }
    jQuery.itemRowPenumpang = jQuery.itemRowPenumpang || {
        adult: '<ul class="adult-row">'
                + '<li><div class="dt-dw green">Dewasa</div></li>'
                + '<li><div onclick="jQuery.changeTitlePassenger(this);" data-title="Mr" class="dt-tl">Mr<i class="fa fa-sort" style="padding-left:12px"></i></div>'
                + '<input data-field="ttl" value="Mr" name="adulttitle[]" type="hidden"></li>'
                + '<li><input data-field="fn" type="text" name="adultfirstname[]" required="required" placeholder="Nama Depan"></li>'
                + '<li><input data-field="ln" type="text" name="adultlastname[]" required="required" placeholder="Nama Belakang"></li>'
                + '<li><img src="' + baseUrl + globVar.assetsUrlWeb
                + 'images/calendar.png"><input data-field="bd" class="birthpicker" name="adultbdate[]" type="text" placeholder="Tgl Lahir">'
                + '</li>'
                + '<li><input data-field="idn" type="text" name="adultnumid[]" placeholder="No Identitas"></li>'
                + '<li><input type="checkbox"  data-field="save"  name="adultsvpsgr[]" >Save Passenger</li>'
                + '<li><div data-type="adult" onClick="jQuery.clickListPassenggerButton(this)" class="dt-list dt-list-adult green">List Pessenger</div></li></ul>',
        child: '<ul class="child-row">'
                + '<li><div class="dt-cil green03">Anak</div></li>'
                + '<li><div onclick="jQuery.changeTitlePassenger(this,false);" data-title="Mstr" class="dt-tl">Mstr<i class="fa fa-sort" style="padding-left:12px"></i></div>'
                + '<input  data-field="ttl"  value="Mstr" name="childtitle[]" type="hidden"></li>'
                + '<li><input  data-field="fn"  type="text" name="childfirstname[]"  required="required" placeholder="Nama Depan"></li>'
                + '<li><input  data-field="ln"  type="text" name="childlastname[]" required="required" placeholder="Nama Belakang"></li>'
                + '<li><img src="' + baseUrl + globVar.assetsUrlWeb
                + 'images/calendar.png"><input  data-field="bd"  class="birthpicker" name="childbdate[]" type="text" placeholder="Tgl Lahir">'
                + '</li>'
                + '<li><input data-field="idn" type="text" name="childnumid[]" placeholder="No Identitas"></li>'
                + '<li><input data-field="save"  type="checkbox" name="childsvpsgr[]">Save Passenger</li>'
                + '<li><div  data-type="children"  onClick="jQuery.clickListPassenggerButton(this)"  class="dt-list dt-list-child green03">List Pessenger</div></li></ul>',
        infant: '<ul class="infant-row">'
                + '<li><div class="dt-inf green04">Infant</div></li>'
                + '<li><div  onclick="jQuery.changeTitlePassenger(this,false);" data-title="Mstr" class="dt-tl">Mstr<i class="fa fa-sort" style="padding-left:12px"></i></div>'
                + '<input  data-field="ttl"  value="Mstr" name="childtitle[]" type="hidden"></li>'
                + '<li><input type="text" data-field="fn" name="infantfirstname[]" required="required" placeholder="Nama Depan"></li>'
                + '<li><input data-field="ln" type="text" name="infantlastname[]" required="required" placeholder="Nama Belakang"></li>'
                + '<li><img src="' + baseUrl + globVar.assetsUrlWeb
                + 'images/calendar.png"><input class="birthpicker" name="infantbdate[]" type="text" placeholder="Tgl Lahir"></li>'
                + '<li><input type="text" data-field="idn" name="infantnumid[]" placeholder="No Identitas"></li>'
                + '<li><input type="checkbox" data-field="save" name="infantsvpsgr[]">Save Passenger</li>'
                + '<li><div  data-type="infant"  onClick="jQuery.clickListPassenggerButton(this)"  class="dt-list dt-list-infant green04">List Pessenger</div></li></ul>'
    };
    jQuery.addAdultRowField = function (itemToAdd) {
        if (itemToAdd < 1) {
            console.log(itemToAdd);
            return false;
        }
        var strItem = jQuery.itemRowPenumpang.adult;
        var jQiTemToAdd = jQuery(strItem.repeat(itemToAdd));
        var adultHtmlRow = $('div.tb-dt-user ul.adult-row:last');
        if (adultHtmlRow.length == 0) {
            jQuery('div.tb-dt-user').prepend(jQiTemToAdd);
        }
        else {
            adultHtmlRow.after(jQiTemToAdd);
        }
        ;

        jQiTemToAdd.find('input.birthpicker').each(function (idnex) {
            var yearNow = new Date().getFullYear();
            dtPickerBdateConfig.yearRange = (yearNow - 100) + ':' + (yearNow - 12);
            jQuery(this).datepicker(dtPickerBdateConfig);
        })
    };
    jQuery.changeTitlePassenger = function (objThis, isAdult) {
        isAdult = typeof (isAdult) === 'undefined' ? true : isAdult;
        var iconSort = '<i class="fa fa-sort" style="padding-left:12px"></i>';
        var titles = {};
        titles.adult = ['Mr', 'Mrs'];
        titles.child = ['Mstr', 'Miss'];
        var thsO = jQuery(objThis);
        var prevTitle = thsO.data('title');
        if (isAdult === true) {
            var newVal = (prevTitle == 'Mr' ? 'Mrs' : 'Mr');
            thsO.parent().find('input[type=hidden][name="adulttitle[]"]').val(newVal);
        }
        else if (isAdult === false) {
            var newVal = (prevTitle == 'Mstr' ? 'Miss' : 'Mstr');
            thsO.parent().find('input[type=hidden][name="childtitle[]"]').val(newVal);
        }
        else {
            switch (isAdult) {
                case 'customer':
                    var newVal = (prevTitle == 'Mr' ? 'Mrs' : 'Mr');
                    thsO.parent().find('input[type=hidden][name="custtitle"]').val(newVal);
                    break;
            }
        }
        thsO.data('title', newVal);
        thsO.html(newVal + iconSort);

    };
    jQuery.addChildRowField = function (itemToAdd) {
        if (itemToAdd < 1) {
            console.log(itemToAdd);
            return false;
        }
        var strItem = jQuery.itemRowPenumpang.child;
        var jQItemToAdd = jQuery(strItem.repeat(itemToAdd))
        var childRowHTML = jQuery('div.tb-dt-user ul.child-row:last');
        if (childRowHTML.length > 0) {
            childRowHTML.after(jQItemToAdd);
        }
        else {
            var adultRow = jQuery('div.tb-dt-user ul.adult-row:last');
            if (adultRow.length > 0) {
                adultRow.after(jQItemToAdd);
            }
            else {
                var infantRow = jQuery('div.tb-dt-user ul.infant-row:first');
                if (infantRow.length > 0) {
                    infantRow.before(jQItemToAdd);
                }
                else {
                    jQuery('div.tb-dt-user').prepend(jQItemToAdd);
                }
            }
        }
        ;
        jQItemToAdd.find('input.birthpicker').each(function (idnex) {
            var yearNow = new Date().getFullYear();
            //anak
            dtPickerBdateConfig.yearRange = (yearNow - 12) + ':' + (yearNow - 2);
            jQuery(this).datepicker(dtPickerBdateConfig);
        })
    };
    jQuery.reCheckBookingStatus = function () {

        $.ajax({
            url: baseUrl + 'ajax/checkBookingStoppedStatus.php',
            type: 'POST',
            dataType: 'JSON',
            data: {},
            beforeSend: function (xhr) {

            },
            error: function (jqXHR, textStatus, errorThrown) {

            },
            success: function (data, textStatus, jqXHR) {

            },
            complete: function (jqXHR, textStatus) {
                swal('..');
            }
        });
    };
    jQuery.addInfantRowField = function (itemToAdd) {
        if (itemToAdd < 1) {
            console.log(itemToAdd);
            return false;
        }
        var strItem = jQuery.itemRowPenumpang.infant;
        var jQItemToAdd = jQuery(strItem.repeat(itemToAdd));
        var infantRowHTML = jQuery('div.tb-dt-user ul.infant-row:last');
        if (infantRowHTML.length > 0) {
            infantRowHTML.after(jQItemToAdd);
        }
        else {
            var childRow = jQuery('div.tb-dt-user ul.child-row:last');
            if (childRow.length > 0) {
                childRow.after(jQItemToAdd);
            }
            else {
                jQuery('div.tb-dt-user').append(jQItemToAdd);
            }
        }
        ;
        jQItemToAdd.find('input.birthpicker').each(function (idnex) {
            var yearNow = new Date().getFullYear();
            dtPickerBdateConfig.yearRange = (yearNow - 12) + ':' + (yearNow - 2);
            jQuery(this).datepicker(dtPickerBdateConfig);
        });
    };
    jQuery.initialFormDataPenumpang = function () {
        var allInputForm = jQuery.semuaInputForm();
        var penumpang = allInputForm.personToGo;
        jQuery.addAdultRowField(parseInt(penumpang.adult));
        jQuery.addChildRowField(parseInt(penumpang.children));
        jQuery.addInfantRowField(parseInt(penumpang.infant));
    };
    (function ($) {

        $('#dewasa').on("selectmenuchange", function (event, ui) {
            var theValue = parseInt(ui.item.value);
            var adultRow = $('div.tb-dt-user ul.adult-row');
            //jika sama, berarti tidak ada perubahan
            if (adultRow.length > theValue) {
                var minIdx = theValue - 1;
                adultRow.each(function (idx) {
                    if (idx >= theValue) {
                        adultRow[idx].remove();
                    }
                });
            }
            else if (theValue > adultRow.length) {
                var itemToAdd = theValue - adultRow.length;
                jQuery.addAdultRowField(itemToAdd);
                //it means have to add the rest
            }
            var selectCustDariPenumpangHtml = '<option value="diffcust">Input Manual</option>';
            for (var i = 0; i < theValue; i++) {
                selectCustDariPenumpangHtml += '<option value="' + i + '">Penumpang Dewasa Ke-' + (i + 1) + '</option>';
            }
            jQuery('select[name=customerDariPenumpang]').html(selectCustDariPenumpangHtml);
        });
        $('select[name=customerDariPenumpang]').change(function (e) {
            var thiisVal = $(this).val();
            console.log(thiisVal);
            if (thiisVal == 'diffcust') {

            }
            else {
                console.log(thiisVal);
                $('ul.adult-row').each(function (ex) {
                    if (ex == thiisVal) {
                        var cust1stName = $(this).find('li input[name="adultfirstname[]"]').val();
                        var custLastName = $(this).find('li input[name="adultlastname[]"]').val();

                        jQuery('input[name=custfirstname]').val(
                                cust1stName
                                );
                        jQuery('input[name=custlastname]').val(custLastName);
                    }
                });
            }
        });
        $('#anak').on("selectmenuchange", function (event, ui) {
            var allInputForm = jQuery.semuaInputForm();
            var orangDewasa = parseInt(allInputForm.personToGo.adult);
            var batasTotalAnak = parseInt(allInputForm.personToGo.children) + parseInt(allInputForm.personToGo.infant);
            var cnfrmed = true;
            var anakAllowedVal = parseInt(allInputForm.personToGo.adult) - parseInt(allInputForm.personToGo.infant);
            if (orangDewasa < batasTotalAnak) {
                cnfrmed = confirm('Jumlah pendamping kurang untuk penumpang anak-anak (Dewasa: '
                        + orangDewasa
                        + ', Anak-anak:' + batasTotalAnak + " )."
                        + "\nKlik Ok untuk konfirmasi.\nKlik Cancel untuk menambahkan " + anakAllowedVal + " anak lagi."
                        );
            }
            console.log('asasd');
            if (cnfrmed) {
                anakAllowedVal = parseInt(ui.item.value);
            }
            else {

                $('#anak').val(anakAllowedVal);
                $('#anak').selectmenu('refresh');
            }
            var theValue = anakAllowedVal;
            var childRow = $('div.tb-dt-user ul.child-row');
            //jika sama, berarti tidak ada perubahan
            if (childRow.length > theValue) {
                var minIdx = theValue - 1;
                childRow.each(function (idx) {
                    if (idx >= theValue) {
                        console.log(idx);
                        childRow[idx].remove();
                    }
                });
                var strRemoveSelector = 'div.tb-dt-user ul.child-row:nth-last-child(-n+' + theValue + ')';
                //$(strRemoveSelector).remove();
                console.log(strRemoveSelector);
                //:nth-last-child(-n+10)
                //it means have to delete the rest
            }
            else if (theValue > childRow.length) {
                var itemToAdd = theValue - childRow.length;
                jQuery.addChildRowField(itemToAdd);
                //it means have to add the rest
            }

        });
        $('#bayi').on("selectmenuselect", function (event, ui) {
            var allInputForm = jQuery.semuaInputForm();
            var orangDewasa = parseInt(allInputForm.personToGo.adult);
            var batasTotalAnak = parseInt(allInputForm.personToGo.children) + parseInt(allInputForm.personToGo.infant);
            var cnfrmed = true;
            var bayiAllowedVal = parseInt(allInputForm.personToGo.adult) - parseInt(allInputForm.personToGo.children);
            if (orangDewasa < batasTotalAnak) {
                cnfrmed = confirm('Jumlah pendamping kurang untuk penumpang anak-anak (Dewasa: '
                        + orangDewasa
                        + ', Anak-anak:' + batasTotalAnak + " )."
                        + "\nKlik Ok untuk konfirmasi.\nKlik Cancel untuk menambahkan " + bayiAllowedVal + " bayi lagi."
                        );
            }
            if (cnfrmed) {
                bayiAllowedVal = parseInt(ui.item.value);
            }
            else {

                $('#bayi').val(bayiAllowedVal);
                $('#bayi').selectmenu('refresh');
            }

            var theValue = bayiAllowedVal;
            var infantRow = $('div.tb-dt-user ul.infant-row');
            //jika sama, berarti tidak ada perubahan
            if (infantRow.length > theValue) {
                var minIdx = theValue - 1;
                infantRow.each(function (idx) {
                    if (idx >= theValue) {
                        infantRow[idx].remove();
                    }
                });
            }
            else if (theValue > infantRow.length) {
                var itemToAdd = theValue - infantRow.length;
                jQuery.addInfantRowField(itemToAdd);
                //it means have to add the rest
            }
        });
        $('#frmBooking').submit(function (event) {
            var formButtonSubmit = jQuery('#confirmBooking');
            var ntsaAndTotal = jQuery.calculateNTSAandTotal();
            var thisValues = $(this).serializeArray();
            var formSearchValue = $.semuaInputForm();
            thisValues.push({name: 'origin', value: formSearchValue.destAsal}
            , {name: 'destination', value: formSearchValue.destAkhir}
            , {name: 'departure_date', value: formSearchValue.tglBerangkat}
            , {name: 'return_date', value: formSearchValue.tglKembali}
            , {name: 'adult', value: formSearchValue.personToGo.adult}
            , {name: 'children', value: formSearchValue.personToGo.children}
            , {name: 'infant', value: formSearchValue.personToGo.infant}
            , {name: 'ntsa', value: ntsaAndTotal.ntsa}
            , {name: 'servicefee[departure]', value: formSearchValue.serviceFee.departure}
            , {name: 'servicefee[return]', value: formSearchValue.serviceFee.return}
            , {name: 'totalfare', value: ntsaAndTotal.totalpay}
            , {name: 'psc', value: ntsaAndTotal.psc}
            , {name: 'tax', value: ntsaAndTotal.tax}
            , {name: 'basic_fare', value: ntsaAndTotal.basic_fare}
            , {name: 'roundtrip', value: formSearchValue.roundTrip});
            var hasGo = false;
            for (var tV in thisValues) {
                if (thisValues[tV].name == 'ticket-go0') {
                    hasGo = true;
                }
            }
            if (!hasGo) {
                swal('Error'
                        , 'Anda belum memilih tiket.', 'error');
                return false;
                event.preventDefault();
            }
            if (formButtonSubmit.val() == 'BOOK') {
                $.ajax({
                    url: baseUrl + 'ajaxBooking.php',
                    type: 'POST',
                    data: thisValues,
                    timeout: 0,
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        $(".dialog").html('<img src="' + baseUrl + 'assets/web/images/pop-up-waiting-data.png" />');

                        $(".dialog").dialog("option", "open", function (event, ui) {
                            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
                        });
                        $(".dialog").dialog("option", "closeOnEscape", false);
                        $(".dialog").dialog("option", "width", 680);
                        $(".dialog").dialog("open");
                        formButtonSubmit.val('PLEASE WAIT');
                    },
                    complete: function (xxx) {
                        $(".dialog").dialog("close");
                        formButtonSubmit.val('BOOK');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var errorCodeStatus = jqXHR.status;
                        if (errorCodeStatus == 503) {
                            $.reCheckBookingStatus();
//                                if (cfM) { 
//                            });//swal
                        }//else if status code not 5-0-3
                        else {
                            swal('An Error Occured.', 'silakan coba lagi', 'error');
                        }


                    },
                    success: function (jsonData) {
                        if (jsonData.code == '00') {
                            if (typeof (jsonData.bookid) !== 'undefined') {
                                window.location = baseUrl + '?page=bookdetail&id=' + (jsonData.bookid);
                            }
                            else {
                                swal('An Error occured', 'Silakan Coba Lagi', 'error');
                            }
                        }
                        else {
                            var defaultMsg = 'Gagal Booking, Silakan coba lagi.'
                            var msgString = typeof (jsonData.message) == 'undefined' ? defaultMsg : jsonData.message;
                            msgString = typeof (jsonData.msg) == 'undefined' ? msgString : jsonData.msg;
                            msgString = null === msgString ? defaultMsg : msgString;
                            swal(msgString, '', 'error');
                        }
                    }
                });
            }
            event.preventDefault();
        });
        jQuery.initialFormDataPenumpang();
    })(jQuery);
}); //eventListener document event end
