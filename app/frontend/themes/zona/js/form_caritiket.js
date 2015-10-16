createScheduleItemhasFinished = 0;
flightLength = 0;
scheduleLeave = [];
scheduleList = [];
searchResult = [];
var maximumClassTd = 20;
var fadeTimeOut = 1000;
document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
        return false;
    }
    function createCssClass(string) {
        return string.toLowerCase().replace(/[^a-zA-Z0-9_-]/g, '-');
    }
    ;
    function initializeOnCariPage() {
        jQuery('#frmBooking').fadeIn(300);
        //searchResult
        jQuery('input[name="checkmas[]"]').click(function (evt) {
            var inSearchingCount = jQuery.searchTicket.arrival.length + jQuery.searchTicket.departure.length;
            var researchAirline = [];
            var thisVal = $(this).val();
            researchAirline.push(thisVal);
            var isNowChecked = $(this).is(':checked');
            var isRoundTrip = $('input[name=round]:checked').val();
            var groupMaskapai = $('input[name="checkmas[]"][data-groupof="' + thisVal + '"]');
            groupMaskapai.each(function (ic) {
                researchAirline.push($(groupMaskapai[ic]).val());
            });
            flightLength = 0;
            hasFinished = 0;
            var airlineID = false;
            for (var re in researchAirline) {
                airlineID = researchAirline[re];
                if (isNowChecked) {
                    /* destAsal, destAkhir,
                     pergi, pulang,
                     personToGo, isRoundTrip, airlineID,
                     repeatNumber, isLeaveData
                     */
                    var destAsal = jQuery('select[name=asal]').val();
                    var destAkhir = jQuery('select[name=tujuan]').val();
                    var tglPergi = jQuery('#pergi').val();
                    var tglKembali = jQuery('#pulang').val();
                    var jumLahOrang = {};
                    jumLahOrang.adult = jQuery('#dewasa').val();
                    jumLahOrang.children = jQuery('#anak').val();
                    jumLahOrang.infant = jQuery('#bayi').val();
                    if (inSearchingCount > 0) {

                        //var timeOutItem = setTimeout(function () {
                        jQuery.cariTiketPesawat(destAsal, destAkhir,
                                tglPergi, tglKembali, jumLahOrang, true, researchAirline[re], 0, false);
                        //}, 500);
                        jQuery.searchTicket.departure[researchAirline[re]] = jQuery.searchTicket.departure[researchAirline[re]] || [];
                        jQuery.searchTicket.arrival[researchAirline[re]] = jQuery.searchTicket.arrival[researchAirline[re]] || [];
                        //jQuery.searchTicket.departure[researchAirline[re]].timeOutItem = timeOutItem;
                        flightLength = flightLength + maxRepeatSearchPerFlight;
                        if (isRoundTrip == 'yes') {
                            flightLength = flightLength + maxRepeatSearchPerFlight;
                            //  var timeOutItem = setTimeout(function () {

                            jQuery.cariTiketPesawat(destAkhir, destAsal,
                                    tglPergi, tglKembali, jumLahOrang, true, researchAirline[re], 0, true);
                            //}, 500);
                            //jQuery.searchTicket.arrival[researchAirline[re]].timeOutItem = timeOutItem;
                        }
                    }
                }
                else {
                    jQuery.hapusSearchResult(airlineID, false);
                    jQuery.abortPreviousRequest(false, airlineID);
                    if (isRoundTrip == 'yes') {
                        jQuery.hapusSearchResult(airlineID, true);
                        jQuery.abortPreviousRequest(true, airlineID);
                    }
                    jQuery('table.zonaresult[data-airline="' + airlineID + '"]').fadeOut(fadeTimeOut).remove();
                }
            }
            setTimeout(function () {
                jQuery.resetTheTableClass(false);
                if (isRoundTrip == 'yes') {
                    jQuery.resetTheTableClass(true);
                }
            }, fadeTimeOut + 1000);
        });
        jQuery('input[name="transit[]"]').click(function (idx) {
            var thisVal = $(this).val();
            var thisIsCheck = $(this).is(':checked');
            var transit = thisVal.substr(0, 1);
            if (thisIsCheck) {
                jQuery('table.zonaresult[data-transit="' + transit + '"]').show('drop', {}, 500);
            }
            else {
                jQuery('table.zonaresult[data-transit="' + transit + '"]').hide('drop', {}, 500);
            }
            ;
            setTimeout(function () {
                jQuery.resetTheTableClass(false);
                jQuery.resetTheTableClass(true);
            }, 600);
        });
    }
    ;
    function initializeSearch() {
        jQuery('#theNprogressBar').hide();
        jQuery('#CariTiketPesawatSection').fadeIn(300);
        jQuery('#selectAsal,select[name=tujuan]').chosen();
        jQuery('.fa.fa-exchange').click(function () {
            var asal = jQuery('select[name=asal]').val();
            jQuery('select[name=asal]').val(jQuery('select[name=tujuan]').val());
            jQuery('select[name=tujuan]').val(asal);
            $("select[name=tujuan]").trigger("chosen:updated");
            $("select[name=asal]").trigger("chosen:updated");
        });
        getServerTimeRun();
        jQuery.addHoverEvent();
        jQuery('input[name=round][type=radio]').click(function (evt) {
            var thisVal = jQuery(this).val();
            if (thisVal == 'no') {
                jQuery('.sl-fly-right .sl-fly-lf').hide();
                jQuery('.zonapulang').hide();
            }
            else {
                jQuery('.sl-fly-right .sl-fly-lf').show();
                jQuery('.zonapulang').show();
            }
        });
        jQuery('input[name="checkmas[]"]').click(function (evT) {
            var thisIsChecked = jQuery(this).is(':checked');
            var myVal = jQuery(this).val();
            if (thisIsChecked) {
                jQuery('input[name="checkmas[]"][data-groupof="' + myVal + '"]').attr('checked', 'checked');
            }
            else {
                jQuery('input[name="checkmas[]"][data-groupof="' + myVal + '"]').removeAttr('checked');
            }
        });
        var dateToday = new Date();
        var dates = jQuery("#pergi, #pulang").datepicker(
                {
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 3,
                    minDate: dateToday,
                    dateFormat: 'dd/mm/y',
                    onSelect: function (selectedDate) {
                        var option = this.id == "pergi" ? "minDate" : "maxDate",
                                instance = jQuery(this).data("datepicker"),
                                date = jQuery.datepicker.parseDate(instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                        if (this.id == 'pergi') {
                            jQuery('#pulang').datepicker("option", option, date);
                        }
                    }
                }
        ).val();
        jQuery("#dewasa")
                .selectmenu()
                .selectmenu("menuWidget")
                .addClass("overflow");
        jQuery("#anak")
                .selectmenu()
                .selectmenu("menuWidget")
                .addClass("overflow");
        jQuery("#bayi")
                .selectmenu()
                .selectmenu("menuWidget")
                .addClass("overflow");
        NProgress.configure({parent: "#theNprogressBar"});
        if (getParameterByName('page') === 'caritiketpesawat') {
            initializeOnCariPage();
        }
        jQuery('#selectAllCheckMas').click(function () {
            jQuery('input[name="checkmas[]"][data-groupof="0"]:unchecked').click(); //'checked','checked');
        });
        jQuery('#unSelectAllCheckMas').click(function () {
            var checkMas = jQuery('input[name="checkmas[]"][data-groupof="0"]');
            //kenapa pake event click, karena untuk menghentikan pencarian sebelumnya.
            checkMas.each(function (inx) {
                var isChecked = jQuery(this).parent().find('.fa.fa-check').is(':visible');
                if (isChecked) {
                    jQuery(this).click();
                }
            });
        });
    }
    ;
    jQuery.selectedTickets = {departure: false, return: false};
    jQuery.searchTicket = jQuery.searchTicket || {departure: [], arrival: []};
    jQuery.calculatePassengerCost = function (isReturn) {
        var allInput = jQuery.semuaInputForm();
        var personTogo = allInput.personToGo;
        var totalFare = 0;
        var selectedTickets = isReturn ? jQuery.selectedTickets.return : jQuery.selectedTickets.departure;
        for (var sT in selectedTickets) {
            var fareDetails = selectedTickets[sT].fare_details;
            for (var fDtls in fareDetails) {
                var psgrNormalFare = fareDetails["" + fDtls + ""].passengger_normal_fare;
                if (
                        typeof (personTogo["" + fDtls + ""]) !== 'undefined'
                        && parseInt(personTogo["" + fDtls + ""]) > 0) {
                    var persTg = parseInt(personTogo["" + fDtls + ""]);
                    totalFare += psgrNormalFare * persTg;
                }
            }
        }
        return totalFare;
    };
    jQuery.getAirlineLabelFromSelectedTicket = function (isReturn) {
        var strAirline = [];
        var prevAirline = '';
        var selectedTickets = isReturn ? jQuery.selectedTickets.return : jQuery.selectedTickets.departure;
        for (var sT in selectedTickets) {
            if (prevAirline === '' || (selectedTickets[sT].airline !== prevAirline)) {
                strAirline.push(selectedTickets[sT].airline);
            }
            prevAirline = selectedTickets[sT].airline;
        }
        return strAirline.join(' > ');
    }

    jQuery.calculateNTSAandTotal = function () {
        var serviceFeeInput = 0;
        var allInput = jQuery.semuaInputForm();
        var ntsa = 0;
        var basicFare = 0;
        var psc = 0;
        var tax = 0;
        var personToGo = allInput.personToGo;
        //console.log(personToGo);
        var totalPay = 0;
        var serviceDeparture = jQuery('input[name="servicefee[departure]"]').val() == "" ? 0 : jQuery('input[name="servicefee[departure]"]').val();
        serviceFeeInput += parseInt(serviceDeparture);
        var departureTicket = jQuery.selectedTickets.departure !== false ? jQuery.selectedTickets.departure : [];
        for (var d in departureTicket) {
            for (var fDetl in departureTicket[d].fare_details) {
                if (departureTicket[d].fare_details["" + fDetl + ""].ntsa === 'NA' && ntsa !== 'NA') {
                    ntsa = 'NA';
                }
                if (
                        typeof (personToGo["" + fDetl + ""]) !== 'undefined'
                        && parseInt(personToGo["" + fDetl + ""]) > 0) {
                    totalPay += parseInt(personToGo["" + fDetl + ""]) * departureTicket[d].fare_details["" + fDetl + ""].passengger_normal_fare;
                    basicFare += parseInt(personToGo["" + fDetl + ""]) * parseInt(departureTicket[d].fare_details["" + fDetl + ""].basic_fare);
                    psc += parseInt(personToGo["" + fDetl + ""]) * parseInt(departureTicket[d].fare_details["" + fDetl + ""].passengger_service_charge);
                    tax += parseInt(personToGo["" + fDetl + ""]) * parseInt(departureTicket[d].fare_details["" + fDetl + ""].passengger_pph);
                    if (ntsa !== 'NA') {
                        ntsa += parseInt(personToGo["" + fDetl + ""]) * departureTicket[d].fare_details["" + fDetl + ""].ntsa;
                    }

                }
            }
            ;
        }
        ;
        if (false !== jQuery.selectedTickets.return && allInput.roundTrip === 'yes') {
            console.log('return is calculated in calculateNTSA');
            var serviceReturn = jQuery('input[name="servicefee[return]"]').val() == "" ? 0 : jQuery('input[name="servicefee[return]"]').val();
            serviceFeeInput += parseInt(serviceReturn);
            var returnTicket = jQuery.selectedTickets.return;
            for (var d in returnTicket) {
                for (var personType in returnTicket[d].fare_details) {

                    if (
                            typeof (personToGo["" + personType + ""]) !== 'undefined'
                            && parseInt(personToGo["" + personType + ""]) > 0) {
                        basicFare += parseInt(personToGo["" + personType + ""]) * parseInt(returnTicket[d].fare_details["" + personType + ""].basic_fare);
                        psc += parseInt(personToGo["" + personType + ""]) * parseInt(returnTicket[d].fare_details["" + personType + ""].passengger_service_charge);
                        tax += parseInt(personToGo["" + personType + ""]) * parseInt(returnTicket[d].fare_details["" + personType + ""].passengger_pph);
                        totalPay += parseInt(personToGo["" + personType + ""]) * returnTicket[d].fare_details["" + personType + ""].passengger_normal_fare;
                        if (ntsa !== 'NA') {
                            ntsa += parseInt(personToGo["" + personType + ""]) * returnTicket[d].fare_details["" + personType + ""].ntsa;
                        }
                        console.log("TotalPayIn REturn calculating" + totalPay);
                    }
                    else {
                        console.log('personType:' + personToGo["" + personType + ""] + '|' + personType);
                    }
                }
            }
            ;
        }
        else {
            console.log('return is NOT calculated in calculateNTSA');
        }
        ;
        totalPay += serviceFeeInput;
        return {ntsa: ntsa, totalpay: totalPay, basic_fare: basicFare, psc: psc, tax: tax}
        ;
    };
    /*
     jQuery.passengerCost = function (fareDetail, personToGo) {
     var psgrCost = 0;
     for (var pg in personToGo) {
     psgrCost += parseFloat(fareDetail[pg].passengger_normal_fare) * parseInt(personToGo[pg]);
     }
     ;
     return parseFloat(psgrCost);
     };
     */
    jQuery.abortPreviousRequest = function (isReturn, airlineID) {
        var abortedAjax = [];
        var abortedTimeout = [];
        isReturn = typeof (isReturn) === 'undefined' ? false : isReturn;
        if (isReturn) {
            var arrivalItems = jQuery.searchTicket.arrival;
            for (var d in arrivalItems) {
                if (typeof (airlineID) == 'undefined') {
                    if (typeof (jQuery.searchTicket.arrival[d].ajaxItem) !== 'undefined') {
                        jQuery.searchTicket.arrival[d].ajaxItem.abort();
                        console.log('ABORTING Ajax For ' + d);
                        abortedAjax.push(d);
                    }
                    if (typeof (jQuery.searchTicket.arrival[d].timeOutItem) !== 'undefined') {
                        clearTimeout(jQuery.searchTicket.arrival[d].timeOutItem);
                        console.log('ABORTING Timeout For ' + jQuery.searchTicket.arrival[d].timeOutItem);
                        abortedTimeout.push(d);
                    }

                }
                else {
                    if (airlineID == d) {
                        if (typeof (jQuery.searchTicket.arrival[d].ajaxItem) !== 'undefined') {
                            jQuery.searchTicket.arrival[d].ajaxItem.abort();
                            console.log('ABORTING Ajax For ID AIRLINE:' + d);
                            abortedAjax.push(d);
                        }
                        if (typeof (jQuery.searchTicket.arrival[d].timeOutItem) !== 'undefined') {
                            clearTimeout(jQuery.searchTicket.arrival[d].timeOutItem);
                            console.log('ABORTING Timeout For ' + jQuery.searchTicket.arrival[d].timeOutItem);
                            abortedTimeout.push(d);
                        }
                    }
                }
            }
        }
        else {

            var departureItems = jQuery.searchTicket.departure;
            for (var d in departureItems) {
                if (typeof (airlineID) == 'undefined') {
                    if (typeof (jQuery.searchTicket.departure[d].ajaxItem) !== 'undefined') {
                        jQuery.searchTicket.departure[d].ajaxItem.abort();
                        abortedAjax.push(d);
                    }
                    if (typeof (jQuery.searchTicket.departure[d].timeOutItem) !== 'undefined') {
                        clearTimeout(jQuery.searchTicket.departure[d].timeOutItem);
                        abortedTimeout.push(d);
                    }
                }
                else {
                    if (airlineID == d) {
                        if (typeof (jQuery.searchTicket.departure[d].ajaxItem) !== 'undefined') {
                            jQuery.searchTicket.departure[d].ajaxItem.abort();
                            abortedAjax.push(d);
                        }
                        if (typeof (jQuery.searchTicket.departure[d].timeOutItem) !== 'undefined') {
                            clearTimeout(jQuery.searchTicket.departure[d].timeOutItem);
                            abortedTimeout.push(d);
                        }
                    }
                }
            }
        }//if return or not

    };
    jQuery.isThisCurrentAjaxDetail = function (fareResult, dataIndex, isReturn) {
        var selectorTabID = isReturn ? contentTabActiveID2 : contentTabActiveID;
        var elSelector = selectorTabID + ' table.zonaresult[data-index=' + dataIndex + '] input[type=radio]:checked';
        var eachRadioActive = jQuery(elSelector);
        var radLength = eachRadioActive.length;
        var hasSameClass = 0;
        eachRadioActive.each(function (ix) {
            var thisRadioSeatClass = jQuery(this).data('class');
            for (var fR in fareResult) {
                if (fareResult[fR].class === thisRadioSeatClass) {
                    hasSameClass++;
                }
            }
        });
        //jika radLength nya nol berarti bukan ajax untuk radio tsb
        //mengapa menggunakan >=, karena untuk class yang sama dipilih
        return  radLength && hasSameClass >= radLength;
    };
    jQuery.ajaxGetFareDetail = function (dataIndex, selectors, isReturn, params) {
        /*
         var isInfoHidden = jQuery('#selectedFlyInfo').is(':hidden');
         if (!isInfoHidden) {*/
        jQuery('#selectedFlyInfo').slideUp(1);
        jQuery('#CariTiketPesawatSection').slideDown(100, function () {
            jQuery('.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
            jQuery('.loadcarilg,.loadcarilg .status-loading').show();
        });
        /*      }
         else {
         
         jQuery('.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
         jQuery('.loadcarilg,.loadcarilg .status-loading').show();
         }
         */
        params.selector = selectors;
        jQuery.ajax({
            url: baseUrl + 'ajaxGetFareDetail.php',
            type: 'POST',
            dataType: 'JSON',
            data: params,
            error: function (xhr) {
                var showThisAjaxResult = jQuery.isThisCurrentAjaxDetail(params.selector, dataIndex, isReturn);
                if (showThisAjaxResult) {

                    $('.loadcarilg').hide();
                    jQuery('.loadcarilg,.loadcarilg .status-loading,.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
                    swal('Error', 'Something error occured while trying get fare detail', 'error');
                }
            },
            success: function (resp) {
                if (resp === null) {
                    $('.loadcarilg').hide();
                    swal('Error', 'Something error Occured while trying get fare detail.', 'error');
                    return false;
                }
                if (resp.status == 200) {
                    var fareResult = resp.fare_result;
                    var theSchedule = false;
                    if (isReturn) {
                        theSchedule = scheduleLeave[dataIndex];
                    }
                    else {
                        theSchedule = scheduleList[dataIndex];
                    }
                    var isMulti = typeof (theSchedule.airline_id) === 'undefined';
                    if (isMulti && fareResult.length !== params.selector.length) {
                        var countHasUpdated = 0;
                        var selectorIsUpdated = false;
                        var allSelectorIsUpdated = false;
                        var selectedTickets = [];
                        for (var tS in theSchedule) {
                            for (var sL in selectors) {
                                if (selectors[sL].flight_code == theSchedule[tS].flight_code) {
                                    //fare resultnya belum
                                    for (var c in theSchedule[tS].class) {
                                        if (theSchedule[tS].class[c].seat_class == selectors[sL].class) {
                                            selectors[sL].dataIndex = dataIndex;
                                            for (var fR in fareResult) {
                                                if (fareResult[fR].class === selectors[sL].class) {
                                                    //selectorIsUpdated = true;
                                                    countHasUpdated++;
                                                    allSelectorIsUpdated = (selectors.length == countHasUpdated);
                                                    fareResult[0].airline = theSchedule[tS].airline;
                                                    selectedTickets.push(fareResult[0]);
                                                    selectors[sL].fare_infos = fareResult[0];
                                                    selectors[sL].transit = theSchedule[tS].transit;
                                                    selectors[sL].airline = theSchedule[tS].airline;
                                                    selectors[sL].transit = theSchedule[tS].transit;
                                                    selectors[sL].origin = theSchedule[tS].origin;
                                                    selectors[sL].destination = theSchedule[tS].destination;
                                                    selectors[sL].departure_time = theSchedule[tS].departure_time;
                                                    selectors[sL].arrival_time = theSchedule[tS].arrival_time;
                                                    selectors[sL].transit_info = typeof (theSchedule[tS].transit_info) === 'undefined' ? [] : theSchedule[tS].transit_info;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ;
                        if (isReturn) {
                            jQuery.selectedTickets.return = selectedTickets;
                        }
                        else {
                            jQuery.selectedTickets.departure = selectedTickets;
                        }

                        jQuery.showFareDetailToSelectedFly(selectors, isReturn);
                        //
                    }
                    else {
                        var isUpdated = jQuery.updateFareDetail(fareResult, dataIndex, isReturn);
                        //fare result is need to be check in isThisCurrentAjaxDetail FUncitons
                        var showThisAjaxResult = jQuery.isThisCurrentAjaxDetail(fareResult, dataIndex, isReturn);
                        if (isUpdated && showThisAjaxResult) {
                            jQuery.getFareDetail(dataIndex, selectors, isReturn, params);
                        }
                    }
                }
                else {
                    var showThisAjaxResult = jQuery.isThisCurrentAjaxDetail(params.selector, dataIndex, isReturn);
                    if (showThisAjaxResult) {
                        $('.loadcarilg').hide();
                        jQuery('.loadcarilg,.loadcarilg .status-loading,.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
                        var basicAlert = 'Something error Occured while trying get fare detail.';
                        swal('Error', resp.status == 404 || resp.status == 403 ? resp.message : basicAlert, 'error');
                    }
                }

            }
        });
    };
    jQuery.renderDetailsTooltipInformation = function (isReturn) {
        isReturn = typeof (isReturn) == 'undefined' ? false : true;
        var theDetails = {};
        var allInputForm = jQuery.semuaInputForm();
        var personToGo = allInputForm.personToGo;
        var departureTicket = isReturn ? jQuery.selectedTickets.return : jQuery.selectedTickets.departure;
        for (var de in departureTicket) {
            var tItems = departureTicket[de];
            for (var fDt in tItems.fare_details) {
                var fDetails = tItems.fare_details[fDt];
                var isSet = typeof (personToGo[fDt]) !== 'undefined' && parseInt(personToGo[fDt]) > 0;
                var countPerson = parseInt(personToGo[fDt]);
                if (isSet) {
                    theDetails[fDt] = theDetails[fDt] || {added: {}, reduced: {}};
                    theDetails[fDt].added["Basic Fare"] = fDetails.basic_fare * countPerson;
                    for (var pE in fDetails.passengger_extra) {
                        theDetails[fDt].added["" + pE + ""] = fDetails.passengger_extra[pE] * countPerson;
                    }
                    theDetails[fDt].added.airline_insurance = fDetails.airline_insurance * countPerson;
                    //ga usah, basic fare nya udah di modif... tapi sebenernya bisa di add lagi sih
                    //theDetails[fDt].reduced.agent_discount = fDetails.agent_discount * countPerson;

                }
            }
        }
        var added = {};
        var airlineInsurance = 0;
        var reduced = {};
        for (var tD in theDetails) {
            for (var aD in theDetails[tD].added) {
                if (aD !== 'airline_insurance') {
                    added["" + aD + ""] = added["" + aD + ""] || 0;
                    added["" + aD + ""] += parseInt(theDetails[tD].added["" + aD + ""]);
                }
                else {
                    airlineInsurance += parseInt(theDetails[tD].added["" + aD + ""]);
                }
            }
        }
        var htmlDepartureDetails = '<span>Detail Biaya ' + (isReturn ? 'Kembali' : 'Berangkat') + ':</span><br/>';
        for (var adX in added) {
            htmlDepartureDetails += '<div class="details-item"><span class="details-label">' + adX + '</span> <span class="details-value">' + parseInt(added[adX]).formatMoney() + '</span></div>';
        }
        jQuery((isReturn ? '.return-details' : '.departure-details')).html(htmlDepartureDetails);
    };
    jQuery.showFareDetailToSelectedFly = function (selectors, isReturn) {
        var allInputForm = jQuery.semuaInputForm();
        var isRoundTrip = jQuery('input[name=round]:checked').val() == 'yes' ? true : false;
        var isInfoHidden = jQuery('#selectedFlyInfo').is(':hidden');
        var thedmyDate = jQuery(isReturn ? '#pulang' : '#pergi').val();
        if (isInfoHidden) {
            jQuery('#CariTiketPesawatSection').slideUp(1);
            jQuery('#selectedFlyInfo').slideDown(100, function () {
                jQuery('.loadcarilg,.loadcarilg .status-loading,.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
            });
        }
        else {
            jQuery('.loadcarilg,.loadcarilg .status-loading,.loadcarilg .status-roundtrip,.loadcarilg .status-transit').hide();
        }
        ;
        var slFlyLeftTable = jQuery('.sl-fly-left table');
        if (isRoundTrip) {
            slFlyLeftTable.find('tr.' + (isReturn ? 'blue' : 'green02')).remove();
        }
        else {
            slFlyLeftTable.find('tr.blue,tr.green02').remove();
        }
        var trHtml = '';
        var rowSpan = selectors.length;
        var isMulti = selectors.length > 1;
        if (isMulti) {
            var slFromScheduleList = isReturn ? scheduleLeave[selectors[0].dataIndex] : scheduleList[selectors[0].dataIndex];
            for (var sL in selectors) {

                trHtml += '<tr class="' + (isReturn ? 'blue' : 'green02') + '">';
                trHtml += (sL == 0) ? '<td  rowspan="' + rowSpan + '" >' + (isReturn ? 'Return' : 'Depart') + ', ' + jQuery.dmySlashTodFyString(thedmyDate) + '</td>' : '';
                trHtml += '<td>' + selectors[sL].flight_code + '<br/>CLASS ' + selectors[sL].class + '</td>'
                        + '<td>' + slFromScheduleList[sL].transit + ' Stop</td>';
                if (slFromScheduleList[sL].transit > 0) {
                    var transitInfo = slFromScheduleList[sL].transit_info;
                    var tiLength = transitInfo.length;
                    trHtml += '<td>';
                    for (var tI in transitInfo) {
                        tI = parseInt(tI);
                        if (tI < (tiLength - 1)) {
                            trHtml += transitInfo[tI].iata + '-' + transitInfo[(tI + 1)].iata + '|';
                            trHtml += transitInfo[tI].departure + '-' + transitInfo[(tI + 1)].arrival + '<br/>';
                        }
                    }
                    trHtml += '</td>';
                }
                else {
                    trHtml += '<td>' + slFromScheduleList[sL].origin + '-' + slFromScheduleList[sL].destination
                            + '|'
                            + slFromScheduleList[sL].departure_time + '-'
                            + slFromScheduleList[sL].arrival_time
                            + '</td>';
                }

                trHtml += '</tr>';
            }
        }
        //else if not multi
        else {

            for (var sL in selectors) {

                trHtml += '<tr class="' + (isReturn ? 'blue' : 'green02') + '">';
                trHtml += '<td >' + (isReturn ? 'Return' : 'Depart') + ', ' + jQuery.dmySlashTodFyString(thedmyDate) + '</td>';
                trHtml += '<td>' + selectors[sL].flight_code + '<br/>class ' + selectors[sL].class + '</td>'
                        + '<td>' + selectors[sL].transit + ' Stop</td>';
                if (selectors[sL].transit > 0) {
                    var transitInfo = selectors[sL].transit_info;
                    var tiLength = transitInfo.length;
                    trHtml += '<td>';
                    for (var tI in transitInfo) {
                        tI = parseInt(tI);
                        if (tI < (tiLength - 1)) {
                            trHtml += transitInfo[tI].iata + '-' + transitInfo[(tI + 1)].iata + '|';
                            trHtml += transitInfo[tI].departure + '-' + transitInfo[(tI + 1)].arrival + '<br/>';
                        }
                    }
                    trHtml += '</td>';
                }
                else {
                    trHtml += '<td>' + selectors[sL].origin + '-' + selectors[sL].destination
                            + '|'
                            + selectors[sL].departure_time + '-'
                            + selectors[sL].arrival_time
                            + '</td>';
                }

                trHtml += '</tr>';
            }
        }

        if (isReturn) {
            var afterGreen = slFlyLeftTable.find('tr.green02:last');
            if (afterGreen.length > 0) {
                afterGreen.after(trHtml);
            }
            else {
                slFlyLeftTable.find('tr.grey').after(trHtml);
            }
        }
        else {
            slFlyLeftTable.find('tr.grey').after(trHtml);
        }
        //ini untuk tiap maskapai
        var psgrCost = jQuery.calculatePassengerCost(isReturn);
        var ntsaAndTotal = jQuery.calculateNTSAandTotal();
        if (false !== ntsaAndTotal) {
            var ntsaTotal = 'NA' == ntsaAndTotal.ntsa ? 'NA' : parseFloat(ntsaAndTotal.ntsa).formatMoney();
            var totalToPay = parseFloat(ntsaAndTotal.totalpay);
            var labelPsgrCost = jQuery('.sl-fly-right ' + (isReturn ? '.sl-fly-lf .sl-fly-ma02' : '.sl-fly-rg .sl-fly-ma01')).find('label');
            var airlineLabel = jQuery('.sl-fly-right ' + (isReturn ? '.sl-fly-lf .sl-fly-ma02' : '.sl-fly-rg .sl-fly-ma01')).find('span');
            airlineLabel.html(jQuery.getAirlineLabelFromSelectedTicket(isReturn));
            labelPsgrCost.data('psgrcost', psgrCost);
            labelPsgrCost.html(parseInt(psgrCost).formatMoney() + ' IDR');
            jQuery('.sl-fly-right .sl-fly-bar>span:first').html('Fare Summary ('
                    + allInputForm.personToGo.adult + ' Adult, '
                    + allInputForm.personToGo.children + ' Child, '
                    + allInputForm.personToGo.infant + ' Infant)');
            jQuery('.sl-fly-right .sl-fly-bar span.ntalabel').html(ntsaTotal);
            jQuery.renderDetailsTooltipInformation(false);
            if (isRoundTrip) {
                jQuery('.html-tooltip-target .return-details').show();
                jQuery.renderDetailsTooltipInformation(true);
            }
            else {
                jQuery('.html-tooltip-target .return-details').hide();
            }
            jQuery('.sl-fly-right .sl-total label span.totallabel').html(totalToPay.formatMoney() + ' IDR');
        }
    };
    jQuery.getFareDetail = function (dataIndex, selectors, isReturn, params) {
        var theSchedule = isReturn ? scheduleLeave[dataIndex] : scheduleList[dataIndex];
        var isMulti = typeof (theSchedule.airline_id) === 'undefined' ? true : false;
        var selectorIsUpdated = false;
        var allSelectorIsUpdated = false;
        var selectedTickets = [];
        if (isMulti) {
            var countHasUpdated = 0;
            for (var tS in theSchedule) {
                for (var sL in selectors) {
                    if (selectors[sL].flight_code === theSchedule[tS].flight_code) {
                        for (var c in theSchedule[tS].class) {
                            if (theSchedule[tS].class[c].seat_class === selectors[sL].class) {
                                if (typeof (theSchedule[tS].class[c].fare_infos) !== 'undefined') {
                                    selectors[sL].dataIndex = dataIndex;
                                    countHasUpdated++;
                                    if (false == allSelectorIsUpdated) {
                                        allSelectorIsUpdated = (selectors.length === countHasUpdated);
                                    }
                                    selectedTickets.push(theSchedule[tS].class[c].fare_infos);
                                    selectors[sL].fare_infos = theSchedule[tS].class[c].fare_infos;
                                    selectors[sL].transit = theSchedule[tS].transit;
                                    selectors[sL].airline = theSchedule[tS].airline;
                                    selectors[sL].transit = theSchedule[tS].transit;
                                    selectors[sL].origin = theSchedule[tS].origin;
                                    selectors[sL].destination = theSchedule[tS].destination;
                                    selectors[sL].departure_time = theSchedule[tS].departure_time;
                                    selectors[sL].arrival_time = theSchedule[tS].arrival_time;
                                    selectors[sL].transit_info = typeof (theSchedule[tS].transit_info) == 'undefined' ? [] : theSchedule[tS].transit_info;
                                }
                            }
                        }
                    }
                }
            }
            selectorIsUpdated = allSelectorIsUpdated;
        }
        else {
            for (var sL in selectors) {
                if (selectors[sL].flight_code == theSchedule.flight_code) {
                    for (var c in theSchedule.class) {
                        if (theSchedule.class[c].seat_class == selectors[sL].class) {
                            if (typeof (theSchedule.class[c].fare_infos) !== 'undefined') {
                                selectorIsUpdated = true;
                                selectors[sL].dataIndex = dataIndex;
                                selectors[sL].fare_infos = theSchedule.class[c].fare_infos;
                                selectedTickets.push(theSchedule.class[c].fare_infos);
                                selectors[sL].airline = theSchedule.airline;
                                selectors[sL].transit = theSchedule.transit;
                                selectors[sL].origin = theSchedule.origin;
                                selectors[sL].destination = theSchedule.destination;
                                selectors[sL].departure_time = theSchedule.departure_time;
                                selectors[sL].arrival_time = theSchedule.arrival_time;
                                selectors[sL].transit_info = typeof (theSchedule.transit_info) == 'undefined' ? [] : theSchedule.transit_info;
                            }
                        }
                    }
                }
            }
        }

        if (!selectorIsUpdated) {
            jQuery.ajaxGetFareDetail(dataIndex, selectors, isReturn, params);
        }
        else {
//            if (isMulti && allSelectorIsUpdated) {
//                jQuery.showFareDetailToSelectedFly( selectors, isReturn);
//            }
//            else {
            if (isReturn) {
                jQuery.selectedTickets.return = selectedTickets;
            }
            else {
                jQuery.selectedTickets.departure = selectedTickets;
            }
            jQuery.showFareDetailToSelectedFly(selectors, isReturn);
            //}
        }
        //selectors.flight_code,selectors.class


    }
    ;
    jQuery.firstClickedDepRet = false; //d/r
    jQuery.clickRadioTicket = function (thisObject, isReturn) {

        var readyForGetFareDetail = false;
        var allInput = jQuery.semuaInputForm();
        var mustRoundTrip = allInput.roundTrip == 'yes' ? true : false;
        var params = {};
        var thisJQobj = jQuery(thisObject);
        var closestTable = thisJQobj.closest('table');
        var dataIndex = closestTable.data('index');
        var closestTR = thisJQobj.closest('tr');
        params.airline_id = parseInt(closestTR.data('airlineid'));
        var myParentID = false;
        for (var a in globVar.available_airline) {
            if (globVar.available_airline[a].id == params.airline_id) {
                myParentID = globVar.available_airline[a].group_of;
                break;
            }
        }

        if (isReturn) {
            var isClickedRadio = jQuery(contentTabActiveID + ' input[type=radio]:checked').length;
            if (isClickedRadio == 0 || jQuery.firstClickedDepRet == 'r' || jQuery.firstClickedDepRet == false) {
                jQuery.firstClickedDepRet = 'r';
                function needToHide(element, index, array) {
                    if (params.airline_id == element.id || params.airline_id == element.group_of
                            || (false !== myParentID && element.id == myParentID)
                            ) {
                        jQuery(contentTabActiveID + ' table.zonaresult[data-airline="' + element.id + '"]').show();
                    } else {
                        jQuery(contentTabActiveID + ' table.zonaresult[data-airline="' + element.id + '"]').hide();
                        jQuery(contentTabActiveID + ' table.zonaresult[data-airline="' + element.id + '"] input[type=radio]:checked').removeAttr('checked');
                    }
                    return true;
                }
                globVar.available_airline.every(needToHide);
                jQuery.resetTheTableClass(isReturn ? false : true);
            }
        }
        else {
            var isClickedRadio = jQuery(contentTabActiveID2 + ' input[type=radio]:checked').length;
            if (isClickedRadio == 0 || jQuery.firstClickedDepRet == 'd' || jQuery.firstClickedDepRet == false) {
                jQuery.firstClickedDepRet = 'd';
            }
            //ini juga ada di pas saat render
            function needToHide(element, index, array) {
                if (params.airline_id == element.id || params.airline_id == element.group_of
                        || (false !== myParentID && element.id == myParentID)
                        ) {
                    jQuery(contentTabActiveID2 + ' table.zonaresult[data-airline="' + element.id + '"]').show();
                } else {
                    jQuery(contentTabActiveID2 + ' table.zonaresult[data-airline="' + element.id + '"]').hide();
                    jQuery(contentTabActiveID2 + ' table.zonaresult[data-airline="' + element.id + '"] input[type=radio]:checked').removeAttr('checked');
                }
                return true;
            }
            globVar.available_airline.every(needToHide);
            jQuery.resetTheTableClass(isReturn ? false : true);
        }
        params.persons = allInput.personToGo;
        if (isReturn) {
            //ini pasti selalu roundTrip
            params.origin = allInput.destAkhir;
            params.destination = allInput.destAsal;
            params.date = allInput.tglKembali;
            jQuery(contentTabActiveID2 + ' table.zonaresult')
                    .not(closestTable)
                    .find('input[type=radio]:checked')
                    .removeAttr('checked');
        }
        else {
            params.origin = allInput.destAsal;
            params.destination = allInput.destAkhir;
            params.date = allInput.tglBerangkat;
            jQuery(contentTabActiveID + ' table.zonaresult')
                    .not(closestTable)
                    .find('input[type=radio]:checked')
                    .removeAttr('checked');
        }
        var mustMultiRad = closestTable.data('multi') === 'f' ? false : parseInt(closestTable.data('multi'));
        var checkedRadio = closestTable.find('input[type=radio]:checked');
        jQuery('input[type=hidden][name=is_multi_' + (isReturn ? 'return' : 'departure') + ']').val(closestTable.data('multi'));
        if (false !== mustMultiRad && (checkedRadio.length !== mustMultiRad)) {
            //var isHide = jQuery('#selectedFlyInfo').is(':hidden');
            //if (!isHide) {
            jQuery('#selectedFlyInfo').slideUp(1);
            jQuery('#CariTiketPesawatSection').slideDown(100, function () {
                jQuery('.loadcarilg .status-loading').hide();
                jQuery('.loadcarilg .status-roundtrip').hide();
                jQuery('.loadcarilg,.loadcarilg .status-transit').show();
            });
            //}
            /*else {
             jQuery('.loadcarilg .status-loading').hide();
             jQuery('.loadcarilg .status-roundtrip').hide();
             jQuery('.loadcarilg,.loadcarilg .status-transit').show();
             }
             */

        }
        else {
            readyForGetFareDetail = true;
        }
        if (readyForGetFareDetail) {
            var selectors = [];
            checkedRadio.each(function () {
                var thisVal = $(this).val();
                var splitedVal = thisVal.split('|');
                var radioItem = {class: splitedVal[1], flight_code: splitedVal[0], origin: splitedVal[2], destination: splitedVal[3]};
                selectors.push(radioItem);
            });
            jQuery.getFareDetail(dataIndex, selectors, isReturn, params);
        }
    };
    jQuery.changeDtStatus = function (isReturn) {
        isReturn = typeof (isReturn) == 'undefined' ? false : isReturn;
        var allVar = jQuery.semuaInputForm();
        var hariIndo = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        var thDate = new Date(jQuery.dmySlashTodFyString(allVar.tglBerangkat));
        if (isReturn) {
            var labelReturn = '<span style="position:absolute; left:0; margin-left:10px; color:#666">Pulang</span>';
            labelReturn += globVar.kotaKeyVal["" + allVar.destAkhir + ""] + " ( " + allVar.destAkhir + " ) - ";
            labelReturn += globVar.kotaKeyVal["" + allVar.destAsal + ""] + " ( " + allVar.destAsal + " ) | ";
            thDate = new Date(jQuery.dmySlashTodFyString(allVar.tglKembali));
            labelReturn += hariIndo[thDate.getDay()] + ', ' + jQuery.dmyTOdmY(allVar.tglKembali) + ' | ';
            labelReturn += parseInt(allVar.personToGo.adult) + ' Dewasa, ';
            labelReturn += parseInt(allVar.personToGo.children) + ' Anak-Anak, ';
            labelReturn += parseInt(allVar.personToGo.infant) + ' Infant';
            jQuery('#tabBookReturn .dt-status').html(labelReturn);
        }
        else {
            var labelLeave = '<span style="position:absolute; left:0; margin-left:10px; color:#49823d">Berangkat</span>';
            labelLeave += globVar.kotaKeyVal["" + allVar.destAsal + ""] + " ( " + allVar.destAsal + " ) - ";
            labelLeave += globVar.kotaKeyVal["" + allVar.destAkhir + ""] + " ( " + allVar.destAkhir + " ) | ";
            labelLeave += hariIndo[thDate.getDay()] + ', ' + jQuery.dmyTOdmY(allVar.tglBerangkat) + ' | ';
            labelLeave += parseInt(allVar.personToGo.adult) + ' Dewasa, ';
            labelLeave += parseInt(allVar.personToGo.children) + ' Anak-Anak, ';
            labelLeave += parseInt(allVar.personToGo.infant) + ' Infant';
            jQuery('#tabBookLeave .dt-status').html(labelLeave);
        }
    };
    jQuery.semuaInputForm = function () {
        var ret = {};
        var serviceFee = {};
        serviceFee.departure = $('input[name="servicefee[departure]"]').val() == '' ? 0 : parseFloat($('input[name="servicefee[departure]"]').val());
        serviceFee.return = $('input[name="servicefee[return]"]').val() == '' ? 0 : parseFloat($('input[name="servicefee[return]"]').val());
        ret.serviceFee = serviceFee;
        ret.destAsal = $('select[name=asal]').val();
        ret.destAkhir = $('select[name=tujuan]').val();
        ret.tglBerangkat = $('#pergi').val();
        ret.tglKembali = $('#pulang').val();
        var person = {};
        person.adult = $('#dewasa').val();
        person.children = $('#anak').val();
        person.infant = $('#bayi').val();
        ret.personToGo = person;
        var maskapai = [];
        jQuery('input[name="checkmas[]"]:checked').each(function (inde) {
            maskapai.push($(this).val());
        });
        var transit = [];
        jQuery('input[name="transit[]"]:checked').each(function (inde) {
            transit.push($(this).val());
        });
        ret.maskapai = maskapai;
        ret.transit = transit;
        ret.roundTrip = jQuery('input[name=round]:checked').val();
        return ret;
    }
    jQuery.hapusSearchResult = function (airlineID, isLeave) {
        searchResult.flight_info = searchResult.flight_info || [];
        if (searchResult.flight_info.length > 0) {
            var fLinf = searchResult.flight_info;
            for (var f in fLinf) {
                var airlineID = typeof (fLinf[f].airline_id) !== 'undefined' ? fLinf[f].airline_id : false;
                if (typeof (fLinf[f].schedule !== 'undefined') || fLinf[f].schedule !== null || fLinf[f].airline_id == airlineID) {
                    if (isLeave) {
                        searchResult.flight_info[f].schedule.return = [];
                    }
                    else {
                        searchResult.flight_info[f].schedule.departure = [];
                    }
                }
            }
        }
        scheduleList = scheduleList || [];
        scheduleLeave = scheduleLeave || [];
        var checkSchedule = isLeave ? scheduleLeave : scheduleList;
        for (var sL in checkSchedule) {
            if (checkSchedule[sL].airline_id == airlineID) {
                delete isLeave ? scheduleLeave[sL] : scheduleList[sL];
            }
        }

    };
    jQuery.isObsoleteData = function (lastUpdateDate) {
        var lastUpdate = new Date(lastUpdateDate);
        if (typeof (serverTimeRun) === 'undefined') {
            getServerTimeRun();
        }
        var thisTime = serverTimeRun;
        var dateRange = thisTime.getTime() - lastUpdate.getTime();
        ///minutesTolerance dapat dari server
        return minutesTolerance >= dateRange ? false : true;
    };
    /*
     jQuery.sortScheduleListByTime = function (scheduleList, hasCaptured, sortedSchedule) {
     hasCaptured = typeof (hasCaptured) == 'undefined' ? [] : hasCaptured;
     sortedSchedule = typeof (sortedSchedule) == 'undefined' ? [] : sortedSchedule;
     var smallestTimeIndex = -1;
     var smallestTime = 0;
     for (var sI in scheduleList) {
     if (!inArray(sI, hasCaptured)) {
     smallestTimeIndex =
     (smallestTime === 0) ||
     (smallestTime > scheduleList[sI].departure_timestamp)
     ? sI : smallestTimeIndex;
     smallestTime = (smallestTime === 0) ||
     (smallestTime > scheduleList[sI].departure_timestamp)
     ? scheduleList[sI].departure_timestamp : smallestTime;
     
     }
     }
     hasCaptured.push(smallestTimeIndex);
     sortedSchedule.push(scheduleList[smallestTimeIndex]);
     ;
     return scheduleList.length == hasCaptured.length
     ? sortedSchedule : jQuery.sortScheduleListByTime(scheduleList, hasCaptured, sortedSchedule);
     };
     */
    jQuery.addRestClassEmpty = function (restTd, rowSpan) {
        rowSpan = typeof (rowSpan) == 'undefined' ? 1 : rowSpan;
        var str = '';
        for (var m = 0; m < restTd; m++) {
            str += '<td class="rs-void" rowspan="' + rowSpan + '"></td>';
        }
        ;
        return str;
    };
    jQuery.countTransit = function (ticketsItem, isMulti) {
        var ret = 0;
        if (isMulti) {
            for (var tI in ticketsItem) {

                ret = ret + (parseInt(ticketsItem[tI].transit) + 1);
            }
            ret--;
        }
        else {
            ret = ticketsItem.transit;
        }
        return ret;
    };
    jQuery.createTableContentTicket = function (ticketsItem, isTransit, transitType, isLeave, numTransit, indexMulti) {
        var isMulti = typeof (indexMulti) === 'undefined' ? false : true;
        isLeave = typeof (isLeave) == 'undefined' ? false : isLeave;
        indexMulti = typeof (indexMulti) === 'undefined' ? 0 : parseInt(indexMulti);
        //okay, isLeave has arrived
        //isLeave==true(berarti returndata (tab ungu)), false=tab hijau
        var tableStr = '';
        //jika transitTipe1 terpenuhi
        if (isTransit) {
            var transitInfo = ticketsItem.transit_info;
            var rowSpan = transitInfo.length - 1;
            for (var tI = 0; tI < rowSpan; tI++) {
                if (tI == 0) {
                    tableStr += '<tr data-airlineid="' + ticketsItem.airline_id + '" data-flightcode="' + ticketsItem.flight_code + '" data-maskapai="' + ticketsItem.airline + '">';
                    tableStr += '<td class="rs-maskapai  ">'; //rs-trs
                    tableStr += '<div class="logo-ma">';
                    tableStr += '<div title="' + ticketsItem.airline + '" class=" mskp mskp-'
                            + createCssClass(ticketsItem.airline)
                            + ' ' + createCssClass(ticketsItem.airline) + '"></div>';
                    tableStr += '<span>' + (typeof (transitInfo[tI].flight_code) !== 'undefined' ? transitInfo[tI].flight_code.replace(/ /g, "") : ticketsItem.flight_code.replace(/ /g, "")) + '</span>';
                    tableStr += '</div>';
                    tableStr += '<div class="zona-arriv">';
                    tableStr += '<span>' + transitInfo[tI].iata + '</span>';
                    tableStr += "\n";
                    tableStr += '<span>' + transitInfo[tI].departure + '</span>';
                    tableStr += '</div>';
                    tableStr += '<div class="zona-depart">';
                    tableStr += '<span>' + transitInfo[tI + 1].iata + '</span>';
                    tableStr += "\n";
                    tableStr += '<span>' + transitInfo[tI + 1].arrival + '</span>';
                    tableStr += '</div>';
                    tableStr += numTransit > 0 && indexMulti === 0 ? '<div class="transit-tl">' + numTransit + ' x Transit</div>' : '';
                    tableStr += '</td>';
                    //proses ini ada 2, ada dibawah juga
                    var allClass = ticketsItem.class;
                    var restTd = maximumClassTd;
                    for (var aC in allClass) {
                        restTd--;
                        var avaClass = (allClass[aC].sold_out) ? '' : ' not-sold-out ';
                        var categoryClassName = typeof (allClass[aC].category) !== 'undefined' && 'business' == allClass[aC].category ? allClass[aC].category : '';
                        tableStr += '<td rowspan="' + rowSpan
                                + '" data-maskapai="' + ticketsItem.airline + ' '
                                + categoryClassName + '" class="seat-'
                                + (allClass[aC].seat_class.replace(/\W/g, '')) + ' rs-void rs-trs' + avaClass
                                + ' line-' + indexMulti + '">';
                        tableStr += typeof (allClass[aC].category) !== 'undefined' && allClass[aC].category == 'business' ? '<div style="background:#f00;height: 3px;margin-left: 1px;position: absolute;width: 4%;"></div>' : '';
                        tableStr += '<span><b>' + allClass[aC].seat_class + '</b>';
                        tableStr += allClass[aC].sold_out ?
                                '' : '<input data-class="' + allClass[aC].seat_class/*.replace('(WL)','').replace(/ /g,'')*/
                                + '" data-seat="' + (allClass[aC].available_seat === null ? 0 : allClass[aC].available_seat) + '"'
                                + ' data-category="' + (allClass[aC].category) + '"'
                                + '" onClick="jQuery.clickRadioTicket(this,' + isLeave + ');" '
                                + 'class="ticket-radio"  value="'
                                + ticketsItem.flight_code
                                + '|'
                                + allClass[aC].seat_class/*.replace('(WL)','').replace(/ /g,'')*/
                                + '|'
                                + ticketsItem.origin
                                + '|'
                                + ticketsItem.destination
                                + '|'
                                + ticketsItem.airline_id
                                + '" type="radio" name="'
                                + (isLeave ? 'ticket-back' : 'ticket-go')
                                + indexMulti + '" /><br>';
                        tableStr += allClass[aC].available_seat === null
                                ? '(<b>0</b>)' : '(<b>' + allClass[aC].available_seat + '</b>)<br>';
                        tableStr += '<b>';
                        tableStr += allClass[aC].available_seat === null
                                || null === allClass[aC].fare || 0 == allClass[aC].fare.length
                                ? '' : parseInt(String(allClass[aC].fare).substring(
                                        0, String(allClass[aC].fare).length - 3
                                        )
                                        ).formatMoney(0);
                        tableStr += '</b>';
                        tableStr += '</span>';
                        tableStr += '</td>';
                    }
                    ;
                    if (restTd > 0) {
                        tableStr += jQuery.addRestClassEmpty(restTd, rowSpan);
                    }

                } else {

                    tableStr += '<tr  data-flightcode="' + ticketsItem.flight_code + '"  data-airlineid="' + ticketsItem.airline_id + '" data-maskapai="' + ticketsItem.airline + '">';
                    tableStr += '<td class="rs-maskapai ">'; //rs-trs
                    tableStr += '<div class="logo-ma">';
                    tableStr += '<div title="' + ticketsItem.airline + '" class=" mskp mskp-'
                            + createCssClass(ticketsItem.airline) + ' ' + createCssClass(ticketsItem.airline) + '"></div>';
                    tableStr += '<span>' + (typeof (transitInfo[tI].flight_code) !== 'undefined' ? transitInfo[tI].flight_code.replace(/ /g, "") : ticketsItem.flight_code.replace(/ /g, "")) + '</span>';
                    tableStr += '</div>';
                    tableStr += '<div class="zona-arriv">';
                    tableStr += '<span>' + transitInfo[tI].iata + '</span>';
                    tableStr += "\n";
                    tableStr += '<span>' + transitInfo[tI].departure + '</span>';
                    tableStr += '</div>';
                    tableStr += '<div class="zona-depart">';
                    tableStr += '<span>' + transitInfo[tI + 1].iata + '</span>';
                    tableStr += "\n";
                    tableStr += '<span>' + transitInfo[tI + 1].arrival + '</span>';
                    tableStr += '</div>';
                    tableStr += '</td>';
                }
                ;
                tableStr += '</tr>';
            }
        }
        else {
            //jika transitTipe1 tidak terpenuhi
            tableStr += '<tr  data-flightcode="' + ticketsItem.flight_code + '"  data-airlineid="' + ticketsItem.airline_id + '" data-maskapai="' + ticketsItem.airline + '">';
            tableStr += '<td class="rs-maskapai green07 ">'; //' + (transitType == 'multi' ? 'rs-trs' : '') + '
            tableStr += '<div class="logo-ma">';
            tableStr += '<div title="' + ticketsItem.airline + '" class=" mskp mskp-'
                    + createCssClass(ticketsItem.airline) + ' '
                    + createCssClass(ticketsItem.airline) + '"></div>';
            tableStr += '<span>' + ticketsItem.flight_code + '</span>';
            tableStr += '</div>';
            tableStr += '<div class="zona-arriv">';
            tableStr += '<span>' + ticketsItem.origin + '</span>';
            tableStr += "\n";
            tableStr += '<span>' + ticketsItem.departure_time + '</span>';
            tableStr += '</div>';
            tableStr += '<div class="zona-depart">';
            tableStr += '<span>' + ticketsItem.destination + '</span>';
            tableStr += "\n";
            tableStr += '<span>' + ticketsItem.arrival_time + '</span>';
            tableStr += '</div>';
            if (numTransit > 0 && indexMulti === 0) {
                tableStr += '<div class="transit-tl">' + numTransit + ' x Transit</div>';
            }
            ;
            //}
            tableStr += '</td>';
            //proses ini ada 2, ada diatas juga
            var allClass = ticketsItem.class;
            var restTd = maximumClassTd;
            for (var aC in allClass) {
                restTd--;
                var avaClass = (allClass[aC].sold_out) ? '' : ' not-sold-out ';
                var categoryClassName = typeof (allClass[aC].category) !== 'undefined' && allClass[aC].category == 'business' ? allClass[aC].category : '';
                tableStr += '<td data-maskapai="' + ticketsItem.airline + ' ' + categoryClassName
                        + '"  class="seat-' + allClass[aC].seat_class.replace(/\W/g, '')
                        + ' rs-void '
                        + ' line-' + indexMulti
                        + avaClass + '' + (transitType == 'multi' ? 'rs-trs' : '') + '">';
                tableStr += !allClass[aC].sold_out && typeof (allClass[aC].category) !== 'undefined' && allClass[aC].category == 'business' ? '<div style="background:#f00;height: 3px;margin-left: 1px;position: absolute;width: 4%;"></div>' : '';
                tableStr += '<span><b>' + allClass[aC].seat_class + '</b>';
                tableStr += allClass[aC].sold_out ?
                        '' : '<input  data-class="' + allClass[aC].seat_class/*.replace('(WL)','').replace(/ /g,'')*/
                        + '"  onClick="jQuery.clickRadioTicket(this,' + isLeave + ');" '
                        + ' data-category="' + (allClass[aC].category) + '"'
                        + ' data-seat="' + (allClass[aC].available_seat === null ? 0 : allClass[aC].available_seat) + '"'
                        + ' class="ticket-radio" value="'
                        + ticketsItem.flight_code
                        + '|'
                        + allClass[aC].seat_class/*.replace('(WL)','').replace(/ /g,'')*/
                        + '|'
                        + ticketsItem.origin
                        + '|'
                        + ticketsItem.destination
                        + '|'
                        + ticketsItem.airline_id
                        + '" type="radio" name="' + (isLeave ? 'ticket-back' : 'ticket-go') + indexMulti + '"><br>';
                tableStr += allClass[aC].available_seat === null
                        ? '(<b>0</b>)<br>' :
                        '(<b>' + allClass[aC].available_seat + '</b>)<br>';
                tableStr += allClass[aC].available_seat === null
                        || null === allClass[aC].fare
                        || 0 == allClass[aC].fare.length ? '<b></b><br/>'
                        : '<b>' + parseInt(String(allClass[aC].fare).substring(
                                0, String(allClass[aC].fare).length - 3
                                )
                                ).formatMoney(0) + '</b></span>';
                tableStr += allClass[aC].promo ? '<div class="cf4a"></div>' : '';
                tableStr += '</td>';
            }
            ;
            if (restTd > 0) {
                tableStr += jQuery.addRestClassEmpty(restTd);
            }
            tableStr += '</tr>';
        }
        ;
        return tableStr;
    }
    ;
    jQuery.createTableContentTRTD = function (scheduleItem, isMulti, isLeave) {
        var tableStr = '';
        var numTransit = jQuery.countTransit(scheduleItem, isMulti);
        if (!isMulti) {
            var isTransit = scheduleItem.transit > 0;
            tableStr += jQuery.createTableContentTicket(scheduleItem, isTransit, 'single', isLeave, numTransit);
        }
        else {
            for (var sC in scheduleItem) {
                var isTransit = scheduleItem[sC].transit > 0;
                tableStr += jQuery.createTableContentTicket(scheduleItem[sC], isTransit, 'multi', isLeave, numTransit, sC); //sC=indexMulti
            }
        }
        return tableStr;
    };
    jQuery.createScheduleItemToTable = function (scheduleItem, isLeave) {
        var isMulti = typeof (scheduleItem.transit) === 'undefined';
        var scheduleIndex = scheduleList.length;
        if (typeof (isLeave) !== 'undefined' && true === isLeave) {
            scheduleIndex = scheduleLeave.length;
        }
        ;
        //index 0 berpengaruh juga di tempat check tabel
        var tableAttr = typeof (scheduleItem.airline_id) == 'undefined' ? scheduleItem[0] : scheduleItem;
        var theTransit = jQuery.countTransit(scheduleItem, isMulti);
        var tableStr = '<table data-airline="' + tableAttr.airline_id
                + '" data-index="' + scheduleIndex
                + '" data-transit="' + theTransit
                + '" data-multi="' + (isMulti ? scheduleItem.length : "f")
                + '" data-order="' + tableAttr.departure_timestamp
                + '" class="zonaresult">';
        tableStr += jQuery.createTableContentTRTD(scheduleItem, isMulti, isLeave);
        tableStr += '</table>';
        return tableStr;
    };
    jQuery.renderScheduleList = function (scheduleItem, contentTab, isLeave) {
        //isLeave==return Trip
        var iAmrenderingAirline = scheduleItem.airline_id;
        var isHidden = jQuery('input[name="transit[]"][value="' + scheduleItem.transit + 'x"]').length < 1 ? true : jQuery('input[name="transit[]"][value="' + scheduleItem.transit + 'x"]').is(':checked');
        isHidden = !isHidden;
        //mengambil 
        var jQstrSelector = (isLeave ? contentTabActiveID : contentTabActiveID2)
                + '  input[type=radio]:checked';
        var airlineID = jQuery(jQstrSelector).closest('table').data('airline');
        //console.log('Pengecekan Nilai AirlineID,' + jQstrSelector);
        //console.log(airlineID);
        var isRoundTrip = jQuery('input[name=round]:checked').val() == 'yes';
        var thisAirlineIsIn = false;
        function needToHide(element, index, array) {
            var cLoog = {};
            cLoog.iAmrenderingAirline = iAmrenderingAirline;
            cLoog.element = element;
            cLoog.airline_id = airlineID;

            //jika airlineid ini ada di salah satu airline yang ada
            //atau jika airlineID ini ada di salah satu grup airline
            //atau jika blabla
            //ini dilakukan karena ada trigger checkbox yang melakukan ajax ulang.
            //salah disini kayanya
            //if (airlineID == element.id 
            //|| airlineID == element.group_of 
            //|| iAmrenderingAirline == element.group_of || !isRoundTrip) {
            if (airlineID == element.id || airlineID == element.group_of) {
                if (iAmrenderingAirline == element.id || iAmrenderingAirline == element.group_of) {

                    thisAirlineIsIn = true;
                    alert("thisAirlineIsIn:" + thisAirlineIsIn);
                    console.log(cLoog);
                    console.log("thisAirlineIsIn:");
                    console.log(thisAirlineIsIn);
                }
            }
            return true;
        }
        //jika airline id tidak null

        //dan jika yang akan ditampilkan adalah data return, 
        //dan radio yang pertama di klik adalah berangkat
        if (null !== airlineID &&
                (
                        (!isLeave && jQuery.firstClickedDepRet == 'r') || (isLeave && jQuery.firstClickedDepRet == 'd')
                        )
                ) {
            //alert("airline is not NULL:" + airlineID);
            globVar.available_airline.every(needToHide);

            var clog = {};
            clog.isHidden = isHidden;
            clog.airlineIDFromRadio = airlineID;
            clog.airlineIdOnRendering = iAmrenderingAirline;
            clog.thisAirlineIsIn = thisAirlineIsIn;
            console.log(clog);
            if (!thisAirlineIsIn) {
                isHidden = true;
            }
            console.log(clog);
            //alert('isHiddenisModified for airline ' + iAmrenderingAirline + ':' + isHidden);
        }

        //cek tabel yang telah di render
        var theTable = $(contentTab + ' table.zonaresult');
        //variable untuk menampung string html yang akan di render
        var theTableItemRender = '';
        var hasRender = false;
        if (theTable.length === 0) {
            jQuery(contentTab).html('');
            //isLeave adalah isReturn

            //buat string html, lalu dibuat object jQuery, kemudian di hide terlebih dahulu
            theTableItemRender = jQuery(jQuery.createScheduleItemToTable(scheduleItem, isLeave)).hide();
        }
        else {

            theTable.each(function (idx) {

                var thisTableOrder = parseInt($(this).data('order'));
                var thisScheduleItemTimestamp = typeof (scheduleItem.departure_timestamp) == 'undefined' ? scheduleItem[0].departure_timestamp : scheduleItem.departure_timestamp
                if (thisTableOrder > thisScheduleItemTimestamp && !hasRender) {
                    
                    //buat jQuery object yang di hide dulu
                    theTableItemRender = jQuery(jQuery.createScheduleItemToTable(scheduleItem, isLeave)).hide();
                    
                    
                    jQuery.addHoverEvent(theTableItemRender);

                    //sisipkan diatas tabel yang telah di render
                    if (isHidden) {
                        $(this).before(theTableItemRender);
                    }
                    else {
                        $(this).before(theTableItemRender.fadeIn(fadeTimeOut));
                    }
                    hasRender = true;
                }
            });
            if (!hasRender) {
                theTableItemRender = jQuery(jQuery.createScheduleItemToTable(scheduleItem, isLeave)).hide();
            }
        }
        ;
        jQuery.addHoverEvent(theTableItemRender);
        if (!hasRender) {
            if (isHidden) {
                //obj jquery tabel append(masukkan kedalam elemen) ke contentTab
                theTableItemRender.appendTo(contentTab);
            }
            else {
                //obj jquery tabel append(masukkan kedalam elemen) ke contentTab kemudian tampilkan
                theTableItemRender.appendTo(contentTab).fadeIn(fadeTimeOut);
            }
        }

    };
    jQuery.createScheduleItem = function (scheduLe, isRoundTrip, flightInfo, perMaskapai, params, isLeave, repeatNumber) {

        if (!perMaskapai) {
            flightLength = flightLength + maxRepeatSearchPerFlight;
        }
        ;
        var isMultiTicket = typeof (scheduLe.all_schedules) === 'undefined';
        var obsoleteSchedule = [];
        var theSchedule = [];
        var isObsolete = true;
        if (null !== scheduLe) {
            isObsolete = scheduLe.expired;
            theSchedule = isMultiTicket ? [] : scheduLe.all_schedules;
        }
        if (!isObsolete) {

            if (perMaskapai) {
                hasFinished = hasFinished + (maxRepeatSearchPerFlight - repeatNumber);
            }

            //jika terupdate, diproses
            //didalam theSchedule (all_schedule) baru bisa di cek dia multi ataubukan ternyata
            for (var sIdx in theSchedule) {
                var isMulti = (typeof (theSchedule[sIdx].airline_id) === 'undefined');
                var scheduleItem = isMulti ? [] : {};
                if (!isMulti) {
                    var departureTimeStamp = new Date(
                            jQuery.dmySlashTodFyString(params.departure_date)
                            + ", " + ((theSchedule[sIdx].departure_time).replace('.', ':'))
                            );
                    scheduleItem.airline_id = theSchedule[sIdx].airline_id;
                    scheduleItem.airline = theSchedule[sIdx].airline;
                    scheduleItem.departure_time = theSchedule[sIdx].departure_time;
                    scheduleItem.departure_timestamp = departureTimeStamp.getTime();
                    scheduleItem.arrival_time = theSchedule[sIdx].arrival_time;
                    scheduleItem.flight_code = theSchedule[sIdx].flight_code;
                    scheduleItem.class = theSchedule[sIdx].all_class;
                    scheduleItem.origin = theSchedule[sIdx].origin;
                    scheduleItem.destination = theSchedule[sIdx].destination;
                    scheduleItem.transit = theSchedule[sIdx].transit;
                    if (scheduleItem.transit > 0) {
                        scheduleItem.transit_info = theSchedule[sIdx].transit_info;
                    }
                }
                //else if multi
                else {
                    var theSchedules = theSchedule[sIdx];
                    for (var scMul in theSchedules) {
                        var schMulti = {};
                        var departureTimeStamp = new Date(
                                jQuery.dmySlashTodFyString(params.departure_date)
                                + ", " + ((theSchedules[scMul].departure_time).replace('.', ':'))
                                );
                        schMulti.airline_id = theSchedules[scMul].airline_id;
                        schMulti.airline = theSchedules[scMul].airline;
                        schMulti.departure_time = theSchedules[scMul].departure_time;
                        schMulti.departure_timestamp = departureTimeStamp.getTime();
                        schMulti.arrival_time = theSchedules[scMul].arrival_time;
                        schMulti.flight_code = theSchedules[scMul].flight_code;
                        schMulti.class = theSchedules[scMul].all_class;
                        schMulti.origin = theSchedules[scMul].origin;
                        schMulti.destination = theSchedules[scMul].destination;
                        schMulti.transit = theSchedules[scMul].transit;
                        if (schMulti.transit > 0) {
                            schMulti.transit_info = theSchedules[scMul].transit_info;
                        }
                        ;
                        scheduleItem.push(schMulti);
                    }
                }
                if (perMaskapai && isLeave) {
                    //kenapa di render dulu, supaya tau index mana
                    //kalo di push dulu, ntar indexnya ngaco
                    //soalnya indexnya dari length scheduleLeave ata scheduleList
                    jQuery.renderScheduleList(scheduleItem, contentTabActiveID2, isLeave);
                    scheduleLeave.push(scheduleItem);
                }
                else {
                    jQuery.renderScheduleList(scheduleItem, contentTabActiveID, isLeave);
                    scheduleList.push(scheduleItem);
                }
            }// end for

        }//end notObsolete
        else {
            hasFinished++;
            obsoleteSchedule.push(flightInfo.airline_id);
            //jika obsolete
        }
        return obsoleteSchedule;
    };
    jQuery.resetTheTableClass = function (isLeave) {
        var theTable = $(contentTabActiveID + ' table.zonaresult:visible');
        var evenTableClass = !isLeave ? 'green07' : 'purple01';
        var oddTableClass = !isLeave ? 'green' : 'purple02';
        var evenTDClass = !isLeave ? 'ava01' : 'ava03';
        var oddTDClass = !isLeave ? 'ava02' : 'ava04';
        if (isLeave) {
            theTable = $(contentTabActiveID2 + ' table.zonaresult:visible');
        }

        theTable.each(function (idx) {
            var theTd1st = $(this).find('tr').each(function (trIdx) {
                $(this).find('td:first').removeClass(evenTableClass);
                $(this).find('td:first').removeClass(oddTableClass);
                $(this).find('td:first').addClass(idx % 2 === 0 ? evenTableClass : oddTableClass);
            });
            var theTdOther = $(this).find('td.rs-void.not-sold-out');
            theTdOther.removeClass(evenTDClass);
            theTdOther.removeClass(oddTDClass);
            theTdOther.addClass(idx % 2 === 0 ? evenTDClass : oddTDClass);
        });
    };
    jQuery.isGroupOfAirlineEmpty = function (airline_id, isLeave) {
        var flInfAll = searchResult.flight_info;
        var theSchedule = null;
        for (var sR in flInfAll) {
            if (typeof (flInfAll[sR].schedule) !== 'undefined') {
                if (flInfAll[sR].airline_id == airline_id) {
                    if (flInfAll[sR].schedule !== null) {
                        var theSchedule = isLeave ? flInfAll[sR].schedule.return : flInfAll[sR].schedule.departure;
                    }
                    break;
                }
            }

        }
        var isAlsoNull = theSchedule === null;
        if (!isAlsoNull) {
            hasFinished = typeof (hasFinished) === 'undefined' ? 0 : hasFinished;
            hasFinished++;
        }
        return isAlsoNull;
    };
    jQuery.updateSearchResultObject = function (json, isLeave) {
        searchResult.flight_info = searchResult.flight_info || [];
        json.flight_info = json.flight_info || [];
        json.flight_info.schedule = json.flight_info.schedule || [];
        var updatedFlightInfo = json.flight_info.schedule.departure;
        var flInf = searchResult.flight_info;
        var hasUpdated = false;
        for (var Fi in flInf) {
            if (updatedFlightInfo.airline_id == flInf[Fi].airline_id) {
                searchResult.flight_info[Fi].schedule = searchResult.flight_info[Fi].schedule || [];
                hasUpdated = true;
                searchResult.flight_info[Fi] = json.flight_info;
                if (isLeave) {
                    searchResult.flight_info[Fi].schedule.departure = updatedFlightInfo;
                }
                else {
                    searchResult.flight_info[Fi].schedule.arrival = updatedFlightInfo;
                }


            }
        }
        ;
        if (!hasUpdated) {
            var pushFl = {};
            if (isLeave) {
                pushFl.arrival = updatedFlightInfo;
            }
            else {
                pushFl.departure = updatedFlightInfo;
            }
            searchResult.flight_info.push(json.flight_info);
        }
    };
    jQuery.updateHtmlFareDetail = function (isReturn, dataIndex, seatClass, fareInfos, line) {
        var psgrNorFare = fareInfos.fare_details.adult.passengger_normal_fare;
        var psgrNorFare = String(psgrNorFare).substring(
                0, String(psgrNorFare).length - 3
                );
        var tdToUpdate = jQuery('table.zonaresult[data-index="' + dataIndex + '"] td.line-' + line + '.seat-' + seatClass.replace(/\W/g, ''));
        jQuery(tdToUpdate.find('b')[2]).text(parseInt(psgrNorFare).formatMoney(0));
    };
    jQuery.updateFareDetail = function (fareResult, detailIndex, isReturn) {

        isReturn = typeof (isReturn) == 'undefined' ? false : isReturn;
        var theSchedule = false;
        if (isReturn) {
            theSchedule = scheduleLeave[detailIndex];
        }
        else {
            theSchedule = scheduleList[detailIndex];
        }
        ;
        var isMulti = typeof (theSchedule.airline_id) == 'undefined' ? true : false;
        var isUpdated = false;
        //jika multi, cari didalam
        if (isMulti) {
            var classIsUpdated = 0;
            //cari flight_code nya dulu
            for (var tS in theSchedule) {
                for (var fR in fareResult) {
                    if (theSchedule[tS].flight_code == fareResult[fR].flight_code) {
                        //baru cariClassnya
                        for (var c in theSchedule[tS].class) {

                            if (theSchedule[tS].class[c].seat_class == fareResult[fR].class) {
                                classIsUpdated++;
                                theSchedule[tS].class[c].fare_infos = fareResult[fR];
                                fareResult[fR].airline = theSchedule[tS].airline;
                                var fareInfos = fareResult[fR];
                                jQuery.updateHtmlFareDetail(isReturn, detailIndex, fareResult[fR].class, fareInfos, fR);
                                if (false === isUpdated) {
                                    isUpdated = classIsUpdated == fareResult.length;
                                }

                            }
                        }
                    }
                }
            }
        }
        else {
            //jika bukan multi
            for (var fR in fareResult) {
                if (theSchedule.flight_code == fareResult[fR].flight_code) {
                    //baru cariClassnya
                    for (var c in theSchedule.class) {
                        if (theSchedule.class[c].seat_class == fareResult[fR].class) {
                            theSchedule.class[c].fare_infos = fareResult[fR];
                            var fareInfos = fareResult[fR];
                            jQuery.updateHtmlFareDetail(isReturn, detailIndex, fareResult[fR].class, fareInfos, fR);
                            fareResult[fR].airline = theSchedule.airline;
                            isUpdated = true;
                        }
                    }
                }
            }
        }
        ;
        if (isUpdated) {
            if (isReturn) {
                scheduleLeave[detailIndex] = theSchedule;
                jQuery.selectedTickets.return = fareResult;
            }
            else {
                scheduleList[detailIndex] = theSchedule;
                jQuery.selectedTickets.departure = fareResult;
            }
        }
        ;
        return isUpdated;
    };
    jQuery.updateScheduleList = function (json, isRoundTrip, repeatNumber, isLeaveData) {
        var params = json.params;
        var flight_info = json.flight_info;
        //masksud perMaskapai adalah data jsonnya per maskapai atau bukan
        var perMaskapai = false;
        if (typeof (flight_info.schedule) == 'undefined') {

            //ini langsung update object searchResult.
            //kalo yang bawah, update object searchResultnya pake fungsi khusus
            searchResult = json;
        }
        else {
            perMaskapai = true;
            repeatNumber++;
            var flight_infos = [];
            flight_infos[0] = flight_info;
            flight_info = flight_infos;
        }
        ;
        var departureResearch = [];
        var returnResearch = [];
        //flightLength = perMaskapai ? flightLength : 0;
        for (var fIdx in flight_info) {
            if (!perMaskapai) {
                flightLength = flightLength + maxRepeatSearchPerFlight;
            }
            if (flight_info[fIdx].schedule !== null) {
                if (perMaskapai) {
                    jQuery.updateSearchResultObject(json, isLeaveData);
                }
                var flightInfo = flight_info[fIdx];
                var obsoleteFl = [];
                //untuk data departure, return di bawah
                //ini akan menjadi data return, jika dalam kondisi per maskapai, dan isLeave true
                var departureSchedule = flight_info[fIdx].schedule.departure;
                obsoleteFl = jQuery.createScheduleItem(
                        departureSchedule,
                        isRoundTrip,
                        flightInfo,
                        true, //perMaskapai,
                        params,
                        isLeaveData, repeatNumber);
                for (var obF in obsoleteFl) {
                    if (!inArray(obsoleteFl[obF], departureResearch)) {
                        departureResearch.push(obsoleteFl[obF]);
                    }
                }
                //ini untuk data return
                //permaskapainya gimana ya???
                if (isRoundTrip && !perMaskapai) {
                    var obsoleteRet = [];
                    //ada kondisi ketika null di schedule return
                    var returnSchedule = flight_info[fIdx].schedule.return;
                    obsoleteRet = jQuery.createScheduleItem(
                            returnSchedule,
                            isRoundTrip,
                            flightInfo,
                            true, //permaskapai harus selalu true
                            params,
                            true, repeatNumber);
                    for (var obR in obsoleteRet) {
                        if (!inArray(obsoleteRet[obR], returnResearch)) {
                            returnResearch.push(obsoleteRet[obR]);
                        }
                    }
                }
                //e, flightInfo, perMaskapai, hasFinished, params, isLeave) {
            }
            else {
                //jika isi schedule nya null, maka check apakah parent group nya null juga
                //ternyata ini dihandle di API
                //jadi sekarang mainan status aja
                var isParentDepartureAlsoNull = flight_info[fIdx].status == 200;
                var isParentReturnAlsoNull = flight_info[fIdx].status == 200;
                /*
                 if (typeof (flight_info[fIdx].group_of) !== 'undefined') {
                 isParentDepartureAlsoNull = jQuery.isGroupOfAirlineEmpty(flight_info[fIdx].group_of, false);
                 isParentReturnAlsoNull = jQuery.isGroupOfAirlineEmpty(flight_info[fIdx].group_of, true);
                 }
                 */
                //jika tidak permaskapai, maka ini dalam kondisi semua
                //
                if (!perMaskapai) {
                    repeatNumber = typeof (repeatNumber) == 'undefined' ? 0 : repeatNumber;
                    if (isParentDepartureAlsoNull) {
                        departureResearch.push(flight_info[fIdx].airline_id);
                    }
                    else {
                        hasFinished = hasFinished + (maxRepeatSearchPerFlight - repeatNumber);
                    }
                    if (isParentReturnAlsoNull) {
                        returnResearch.push(flight_info[fIdx].airline_id);
                    }
                    else {
                        hasFinished = hasFinished + (maxRepeatSearchPerFlight - repeatNumber);
                    }
                }
                else {
                    repeatNumber = typeof (repeatNumber) == 'undefined' ? 0 : repeatNumber;
                    if (isLeaveData) {
                        if (isParentReturnAlsoNull) {
                            //kenapa masih di push ke depparture? 
                            //karena di departure research, itu bisa data departure ataupun data return.
                            departureResearch.push(flight_info[fIdx].airline_id);
                        }
                        else {
                            hasFinished = hasFinished + (maxRepeatSearchPerFlight - repeatNumber);
                        }
                    }
                    else {
                        if (isParentDepartureAlsoNull) {
                            departureResearch.push(flight_info[fIdx].airline_id);
                        }
                        else {
                            hasFinished = hasFinished + (maxRepeatSearchPerFlight - repeatNumber);
                        }
                    }
                }
            }

        }
        ;
        hasFinished = typeof (hasFinished) == 'undefined' ? 0 : hasFinished;
        hasFinished = perMaskapai ? hasFinished : (flightLength - (departureResearch.length + returnResearch.length));
        //dicari ulang ada 2 kondisi, per maskapai atau yg pertama cari
        for (var dR in departureResearch) {
            console.log('departureSearchReverse is Research');
            repeatNumber = typeof (repeatNumber) === 'undefined' ? 0 : repeatNumber;
            if (repeatNumber < maxRepeatSearchPerFlight) {
                var timeOutItem = setTimeout(function () {
                    /*
                     *  destAsal, destAkhir,
                     pergi, pulang,
                     personToGo, isRoundTrip, airlineID,
                     repeatNumber, isLeaveData
                     */
                    isLeaveData = typeof (isLeaveData) === 'undefined' ? false : isLeaveData;
                    jQuery.cariTiketPesawat(
                            params.origin,
                            params.destination,
                            params.departure_date,
                            'NA',
                            {
                                adult: params.adult,
                                child: params.child,
                                infant: params.infant
                            },
                    isRoundTrip,
                            departureResearch[dR], repeatNumber, isLeaveData);
                    //delayResearchFlight dari server
                }, delayReSearchFlight);
                if (isLeaveData) {
                    jQuery.searchTicket.arrival[departureResearch[dR]].timeOutItem = timeOutItem;
                }
                else {
                    jQuery.searchTicket.departure[departureResearch[dR]].timeOutItem = timeOutItem;
                }
            }
            else {
                hasFinished = hasFinished + maxRepeatSearchPerFlight;
            }
        }
        //
        for (var dRt in returnResearch) {
            repeatNumber = typeof (repeatNumber) === 'undefined' ? 0 : repeatNumber;
            if (repeatNumber <= maxRepeatSearchPerFlight) {
                var timeOutItem = setTimeout(function () {
                    /*
                     *  destAsal, destAkhir,
                     pergi, pulang,
                     personToGo, isRoundTrip, airlineID,
                     repeatNumber, isLeaveData
                     */
                    var tmOrg = params.origin;
                    params.origin = params.destination;
                    params.destination = tmOrg;
                    jQuery.cariTiketPesawat(
                            params.origin,
                            params.destination,
                            params.departure_date,
                            'NA',
                            {
                                adult: params.adult,
                                child: params.child,
                                infant: params.infant
                            },
                    isRoundTrip,
                            returnResearch[dRt], repeatNumber, true);
                    //delayResearchFlight dari server
                }, delayReSearchFlight);
                jQuery.searchTicket.arrival[returnResearch[dRt]].timeOutItem = timeOutItem;
            }
            else {
                hasFinished++;
            }
        }
        jQuery.resetTheTableClass(isLeaveData);
        if (flightLength >= hasFinished) {
            var setNProgress = hasFinished / flightLength;
            NProgress.set(setNProgress);
            var zonaResultTable = jQuery('table.zonaresult:visible');
            var searchCountAirline = jQuery('input[type=checkbox][name="checkmas[]"]:checked').length;
            //console.log("searchCountAirline:" + searchCountAirline);
            if (
                    (
                            (zonaResultTable.length > 7 || 0.7 <= setNProgress)
                            ||
                            (zonaResultTable.length > 1 && searchCountAirline < 5)
                            )
                    && !jQuery('#theNprogressBar').is(':hidden')) {
                jQuery('#theNprogressBar').hide();
            }
        }
        if (hasFinished == flightLength) {
            NProgress.done();
            var tbLLength = $(contentTabActiveID + ' table.zonaresult').length;
            var emptyResult = jQuery('<div>Tidak ada penerbangan</div>').fadeIn(3000);
            if (tbLLength == 0) {
                $(contentTabActiveID).html(emptyResult);
            }
            tbLLength = $(contentTabActiveID2 + ' table.zonaresult').length;
            if (tbLLength == 0) {
                $(contentTabActiveID2).html(emptyResult);
            }
        }
        ;
//        ////console.log(scheduleList);
    };
    jQuery.addHoverEvent = function (tableTarget) {
        jQuery(tableTarget).find('.rs-void').hover(
                function () {
                    var namaMaskapai = $(this).data("maskapai");
                    if (typeof (namaMaskapai) !== 'undefined') {
                        $(this).append('<label>' + namaMaskapai + '</label>');
                    }
                },
                function () {
                    $(this).find("label:last").remove();
                }
        );
    };
    jQuery.dmyTOdmY = function (dmy) {
        var theD = dmy.split('/');
        theD[2] = (theD[2] < 69 ? '20' : '19') + theD[2];
        return theD.join('-');
    };
    jQuery.ajaxPencarian = function (searchParams, airlineID, isRoundTrip, repeatNumber, isLeaveData) {
        return jQuery.ajax({
            url: baseUrl + 'ajax/caritiket.php',
            data: searchParams,
            type: "POST",
            dataType: 'JSON',
            beforeSend: function (xhr) {
                if (typeof (airlineID) === 'undefined') {
                    jQuery('#theNprogressBar').fadeIn('fast');
                    NProgress.start();
                    $(contentTabActiveID).html('<div class="loading"><h2>Loading</h2></div>');
                    $(contentTabActiveID2).html('<div class="loading"><h2>Loading</h2></div>');
                }
                ;
            },
            success: function (json) {
                //console.log(JSON.stringify(json));
                if (typeof (airlineID) !== 'undefined') {
                    jQuery.updateScheduleList(json, isRoundTrip, repeatNumber, isLeaveData);
                }
                else {
                    jQuery.updateScheduleList(json, isRoundTrip);
                }
                ;
            },
            error: function (response) {
                if (typeof (airlineID) === 'undefined') {
                    $(contentTabActiveID).html('<div class="error">Silakan Coba Lagi</div>');
                }

            },
            complete: function (xhr) {

            }
        });
    };
    jQuery.dmySlashTodFyString = function (dmySlashString) {
        var theD = dmySlashString.split('/');
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        theD[2] = (theD[2] < 69 ? '20' : '19') + theD[2];
        theD[1] = monthNames[parseInt(theD[1]) - 1];
        return theD.join(' ');
    };
    jQuery.cariTiketPesawat = function (
            destAsal, destAkhir,
            pergi, pulang,
            personToGo, isRoundTrip, airlineID,
            repeatNumber, isLeaveData) {
        //personToGo.adult,personToGo.children,personToGo.infant
        ////console.log('repeat Flight ' + airlineID + ' on ' + repeatNumber + ' times');
        var searchParams = {
            pergi: pergi,
            pulang: pulang,
            personToGo: personToGo
        };
        //jangan reverse dari sini
        searchParams.origin = destAsal;
        searchParams.destination = destAkhir;
        if (typeof (airlineID) !== 'undefined') {
            searchParams.pulang = 'NA';
            searchParams.airline_id = airlineID;
            //jika yang dicari addalah schedule untuk return data

            //balik origin dan destination
        }
        ////console.log('perMaskapai?' + airlineID);
        if (typeof (airlineID) == 'undefined') {
            //ini ketika bukan per maskapai
            jQuery.ajaxPencarian(searchParams, airlineID, isRoundTrip, repeatNumber, isLeaveData);
        }
        else {

            //ini ketika per maskapai
            //console.log('sedang di pencarian dengan airlineID:' + airlineID);
            jQuery.searchTicket.arrival[airlineID] = jQuery.searchTicket.arrival[airlineID] || [];
            jQuery.searchTicket.departure[airlineID] = jQuery.searchTicket.departure[airlineID] || [];
            if (isLeaveData) {

                jQuery.searchTicket.arrival[airlineID].ajaxItem = jQuery.ajaxPencarian(searchParams, airlineID, isRoundTrip, repeatNumber, isLeaveData);
            }
            else {
                jQuery.searchTicket.departure[airlineID].ajaxItem = jQuery.ajaxPencarian(searchParams, airlineID, isRoundTrip, repeatNumber, isLeaveData);
            }
        }
    }
    ;
    (function ($) {
        $(document).ready(function ($) {
            initializeSearch();
            $('.servicefeeinput').keyup(function (evt) {
                var ntsaTot = jQuery.calculateNTSAandTotal();
                var totalToPay = ntsaTot.totalpay;
                jQuery('.sl-fly-right .sl-total label span.totallabel').html(totalToPay.formatMoney() + ' IDR');
            });
            $('#cariUlangHref').click(function (eT) {
                $('#selectedFlyInfo').slideUp(1);
                $('#CariTiketPesawatSection').slideDown(1);
            });
            $('#buttonCari').click(function (eventButton) {
                //cek jenis perjalanan

                //jika jenis perjalanan pulangpergi, maka tanggal pulang harus diisi
                if ($('select[name=asal]').val() == '' || $('select[name=tujuan]').val() == '') {

                    alert($('select[name=asal]').val() == '' ? 'Pilih Kota Asal' : 'Pilih Kota Tujuan');
                    $($('select[name=asal]').val() == '' ? 'select[name=asal]' : 'select[name=tujuan]').trigger('chosen:open');
                } else if ($('#pergi').val() === '' || typeof ($('#pergi').val()) === 'undefined') {
                    alert('Tentukan tanggal Keberangkatan.');
                    $('#pergi').focus();
                } else if ($('input[name=dir][type=radio]:checked').val() == 'back' && ($('#pulang').val() == '' || typeof ($('#pulang').val()) == 'undefined')) {
                    alert('Tentukan tanggal pulang untuk jenis perjalanan Pulang Pergi.');
                    $('#pulang').focus();
                } else if (parseInt($('select[name=dewasa]').val()) + parseInt($('select[name=anak]').val()) + parseInt(
                        $('select[name=bayi]').val()) == 0) {
                    alert('Silakan tambahkan Penumpang');
                } else if (
                        jQuery('input[name="checkmas[]"]:checked').length == 0) {
                    alert('Pilih Maskapai yang akan di cari.');
                }
                else {

                    if (getParameterByName('page') !== 'caritiketpesawat') {
                        //jika bukan di halaman utama pencarian
                        $('#formCariTiketPesawat').submit();
                    }
                    else {
                        scheduleList = [];
                        scheduleLeave = [];
                        hasFinished = 0;
                        flightLength = 0;
                        searchResult = [];
                        var roundTrip = $('input[name=round][type=radio]:checked').val();
                        var isRoundTrip = roundTrip === 'yes' ? true : false;
                        if (isRoundTrip) {
                            if (jQuery('#tabBookReturn').is(':hidden')) {
                                jQuery('#tabBookReturn').slideDown(300);
                            }
                        }
                        else {
                            if (!jQuery('#tabBookReturn').is(':hidden')) {
                                jQuery('#tabBookReturn').slideUp(300);
                            }
                        }
                        ;
                        var allValue = jQuery.semuaInputForm();
                        var destAsal = allValue.destAsal;
                        var destAkhir = allValue.destAkhir;
                        var tglBerangkat = allValue.tglBerangkat;
                        var tglKembali = allValue.tglKembali;
                        var personTogo = {};
                        personTogo.adult = allValue.personToGo.adult;
                        personTogo.children = allValue.personToGo.children;
                        personTogo.infant = allValue.personToGo.infant;
                        $(contentTabActiveID).html('<div class="loading"><h2>Loading</h2></div>');
                        $(contentTabActiveID2).html('<div class="loading"><h2>Loading</h2></div>');
                        jQuery.changeDtStatus(false);
                        var tabTanggalStr = jQuery.dmySlashTodFyString(allValue.tglBerangkat);
                        var tabTanggalStrTo = jQuery.dmySlashTodFyString(allValue.tglKembali);
                        var objTglFrom = new Date(tabTanggalStr);
                        var objTglTo = new Date(tabTanggalStrTo);
                        var dayRangeFrom = $.rangeDayWith(tabTanggalStr);
                        var dayRangeTo = $.rangeDayWith(tabTanggalStr, jQuery.dmySlashTodFyString(allValue.tglKembali));
                        jQuery.slideTheTab(dayRangeFrom, '#tabs', tabTanggalStr, dayRangeTo);
                        if (isRoundTrip) {
                            jQuery.changeDtStatus(true);
                            jQuery.slideTheTab2(dayRangeFrom, '#tabs02', tabTanggalStrTo, dayRangeTo);
                            console.log('slideTheTab2Params=dayRangeFrom:' + dayRangeFrom + ',dayRangeTo:' + dayRangeTo + ',tabTanggalStr:' + tabTanggalStr);
                        }
                        jQuery('#theNprogressBar').fadeIn('fast');
                        NProgress.start();
                        jQuery('input[name="checkmas[]"]:checked')
                                .each(function (iX)
                                {
                                    var airlineID = $(this).val();
                                    console.log('HERE: research After Slide The Tab');
                                    console.log(airlineID, tglBerangkat);
                                    $.cariTiketPesawat(
                                            destAsal, destAkhir, tglBerangkat,
                                            'NA', personTogo, isRoundTrip, airlineID, 0, false);
                                    flightLength = flightLength + maxRepeatSearchPerFlight;
                                    if (isRoundTrip) {
                                        console.log('isRoundTrip');
                                        console.log(destAkhir);
                                        console.log(destAsal);
                                        console.log(tglKembali);
                                        flightLength = flightLength + maxRepeatSearchPerFlight;
                                        $.cariTiketPesawat(
                                                destAkhir, destAsal, tglKembali,
                                                'NA', personTogo, isRoundTrip, airlineID, 0, true);
                                    }
                                });
                    }
                }
            }); //end of buttonCariClickEvent

            if (getParameterByName('page') == 'caritiketpesawat' && globVar.isFormSubmitted) {
                $('#buttonCari').click();
            }

        });
    })(jQuery);
});