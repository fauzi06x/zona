function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function getServerTimeRun() {
    serverTimeRun = new Date(serverTime);
    setInterval(function () {
        serverTimeRun = new Date(serverTimeRun.getTime() + 1000);
    }, 1000);
}
;
function initializeSearch() {
    getServerTimeRun();
    jQuery.addHoverEvent();
    NProgress.configure({parent: "#CariTiketPesawatSection"});
}
;
document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    jQuery.addHoverEvent = function (tableTarget) {
        var tableTrg = typeof (tableTarget) === 'undefined' ? '' : tableTarget + ' ';
//        console.log(tableTrg);
        //      console.log(tableTarget);
        jQuery(tableTrg + ".rs-void").hover(
                function () {
                    var namaMaskapai = $(this).parent().data("maskapai");
                    //                console.log(namaMaskapai + '-' + new Date().getTime());
                    $(this).append('<label>' + namaMaskapai + '</label>');
                },
                function () {
                    $(this).find("label:last").remove();
                }
        );
    };

    jQuery.resetParamsBasedForm = function () {
        var params = {};
        params.adult = jQuery('#dewasa').val();
        params.children = jQuery('#anak').val();
        params.infant = jQuery('#bayi').val();
        params.departure_date = jQuery('#pergi').val();
        params.return_date = jQuery('#pulang').val();
        params.origin = jQuery('select[name=asal]').val();
        params.destination = jQuery('select[name=tujuan]').val();
        params.round_trip = jQuery('input[name=dir][type=radio]:checked').val();
        params.promo_code = '';
        searchResult.params = params;
    };
    jQuery.addLoadingTableContentForRender = function () {
        return  '<tr><td class="rs-maskapai green07"><br/>Loading...</td></tr>';
    };
    jQuery.addLoadingTableForRender = function (renderIndex) {
        return '<table class="zonaresult render-' + renderIndex + '" cellpadding="0" cellspacing="0">'
                + jQuery.addLoadingTableContentForRender()
                + '</table>';
    }
    jQuery.isObsoleteData = function (lastUpdateDate) {
        var lastUpdate = new Date(lastUpdateDate);
        if (typeof (serverTimeRun) === 'undefined') {
            getServerTimeRun();
        }
        var thisTime = serverTimeRun;
        var dateRange = thisTime.getTime() - lastUpdate.getTime();
        //5 MIN = 5(min),60(second),1000(milisecond)


        ///minutesTolerance dapat dari server
        return minutesTolerance >= dateRange ? false : true;
    };
    jQuery.researchObsoleteDepartureData = function (flightInfoData, renderIndex) {
        console.log(flightInfoData);
        var searchParam = searchResult.params;
        jQuery.cariTiketPesawat(
                searchParam.origin,
                searchParam.destination,
                searchParam.departure_date,
                searchParam.return_date, {
                    adult: searchParam.adult,
                    infant: searchParam.infant,
                    children: searchParam.children
                }, flightInfoData.airline_id, renderIndex);
        //(destAsal, destAkhir, pergi, pulang, personToGo, airlineID)
    };
    jQuery.sortFlight = function (jsonData) {

    };
    jQuery.eachContentToTable = function (lowesT, flightInfoData, params, renderIndex) {

        var htmlToRender = '';
        for (var LowIdx in lowesT) {
            var isOddTable = renderIndex % 2 !== 0;
            var rowSpan = parseInt(lowesT[LowIdx].transit) + 1;
            if (rowSpan > 1) {
                var transitInfo = lowesT[LowIdx].transit_info;
                var isFirst = true;
                htmlToRender += '<table cellspacing="0" cellpadding="0" class="zonaresult render-' + renderIndex + '"><tbody>';
                var countTransitInfo = transitInfo.length;
                var batas = countTransitInfo - 1;
                var mulai = 1;
                for (var tI in transitInfo) {

                    var tiIndexNext = parseInt(tI) + 1;
                    //untuk membatasi transitInfo

                    //jika yang pertama, sama td lainnya
                    if (isFirst) {
                        htmlToRender += '<tr data-maskapai="' + flightInfoData.airline + '">';
                        //tak perlu rowSpan, justru ini yg menyebabkkan rowspan
                        htmlToRender += '<td class="rs-maskapai ' + (isOddTable ? 'green07' : 'green') + '" >';
                        htmlToRender += '<div style="width:50px; height:100%" class="logo-ma">';
                        //htmlToRender += '<img alt="' + flightInfoData.airline + '" title="' + flightInfoData.airline + '" style="  width: 40px;height: 37px;float: left;" src="">';
                        htmlToRender += '<div title="' + flightInfoData.airline + '" class=" mskp mskp-' + flightInfoData.airline.toLowerCase().replace(/[^a-zA-Z0-9_-]/g, '-') + '"></div>';
                        htmlToRender += '<span>' + lowesT[LowIdx].flight_code + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '<div class="zona-arriv">';
                        htmlToRender += '<span>' + transitInfo[tI].iata + "</span>\n";
                        htmlToRender += '<span>' + transitInfo[tI].departure + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '<div class="zona-depart">';
                        htmlToRender += '<span> ' + transitInfo[tiIndexNext].iata + "</span>\n";
                        htmlToRender += '<span>' + transitInfo[tiIndexNext].arrival + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '</td>';
                        var seats = lowesT[LowIdx].all_class;
                        var countSeat = 18;
                        for (var sIdx in seats) {
                            var withRadioButton = seats[sIdx].sold_out ? '' : '<input type="radio" name="book" value="' + seats[sIdx].fare_selector_value + '" /><br/>';
                            var avaClass = '';
                            if (!seats[sIdx].sold_out) {
                                avaClass = (isOddTable) ? 'ava01' : 'ava02';
                            }
                            countSeat--;
                            //console.log(seats[sIdx]);
                            //if (countSeat >= 0) {
                            htmlToRender += '<td class="rs-void ' + avaClass + '" rowspan="' + rowSpan + '"><span>'
                                    + seats[sIdx].seat_class
                                    + withRadioButton
                                    + '(' + seats[sIdx].available_seat + ')<br>' +
                                    +String(seats[sIdx].fare).substring(0, String(seats[sIdx].fare).length - 3)
                                    + '</span></td>';
                            //};
                        }
                        if (countSeat > 0) {
                            for (var cS = 0; cS < countSeat; cS++) {
                                htmlToRender += '<td class="rs-void" rowspan="' + rowSpan + '"></td>';
                            }
                        }

                    }
                    //selain itu, headnya aja.
                    else {

                        htmlToRender += '<tr data-maskapai="' + flightInfoData.airline + '">';
                        //tak perlu rowSpan, justru ini yg menyebabkkan rowspan
                        htmlToRender += '<td class="rs-maskapai ' + (isOddTable ? 'green07' : 'green') + '" >';
                        htmlToRender += '<div class="logo-ma">';
                        //htmlToRender += '<img alt="' + flightInfoData.airline + '" title="' + flightInfoData.airline + '" style="  width: 40px;height: 37px;float: left;" src="">';
                        htmlToRender += '<div title="' + flightInfoData.airline + '" class=" mskp mskp-' + flightInfoData.airline.toLowerCase().replace(/[^a-zA-Z0-9_-]/g, '-') + '"></div>';
                        htmlToRender += '<span>' + lowesT[LowIdx].flight_code + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '<div class="zona-arriv">';
                        htmlToRender += '<span>' + transitInfo[tI].iata.toUpperCase() + "</span>\n";
                        htmlToRender += '<span>' + transitInfo[tI].departure + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '<div class="zona-depart">';
                        htmlToRender += '<span> ' + transitInfo[tiIndexNext].iata.toUpperCase() + "</span>\n";
                        htmlToRender += '<span>' + transitInfo[tiIndexNext].arrival + '</span>';
                        htmlToRender += '</div>';
                        htmlToRender += '</td></tr>';
                    }
                    isFirst = false;
                    if (mulai == batas) {
                        break;
                    }
                    mulai++;
                }//end for var transitInfo
                htmlToRender += '</tbody></table>';
            }
            //selain itu jika tidak ada transit
            else {
                htmlToRender += '<table cellspacing="0" cellpadding="0" '
                        + 'class="zonaresult render-' + renderIndex + '">';
                htmlToRender += '<tbody><tr data-maskapai="' + flightInfoData.airline + '">';
                //tak perlu rowSpan, justru ini yg menyebabkkan rowspan

                htmlToRender += '<td class="rs-maskapai ' + (isOddTable ? 'green07' : 'green') + '">';
                htmlToRender += '<div class="logo-ma">';
                htmlToRender += '<div title="' + flightInfoData.airline + '" class=" mskp mskp-' + flightInfoData.airline.toLowerCase().replace(/[^a-zA-Z0-9_-]/g, '-') + '"></div>';
                htmlToRender += '<span>' + lowesT[LowIdx].flight_code + '</span>';
                htmlToRender += '</div>';
                htmlToRender += '<div class="zona-arriv">';
                htmlToRender += '<span>' + params.origin + "</span>\n";
                htmlToRender += '<span>' + lowesT[LowIdx].departure_time + '</span>';
                htmlToRender += '</div>';
                htmlToRender += '<div class="zona-depart">';
                htmlToRender += '<span>' + params.destination + "</span>\n";
                htmlToRender += '<span>' + lowesT[LowIdx].arrival_time + '</span>';
                htmlToRender += '</div>';
                htmlToRender += '</td>';
                var seats = lowesT[LowIdx].all_class;
                var countSeat = 18;
                for (var sIdx in seats) {
                    var withRadioButton = seats[sIdx].sold_out ? '' : '<input type="radio" name="book" value="' + seats[sIdx].fare_selector_value + '" /><br/>';
                    countSeat--;
                    var avaClass = '';
                    if (!seats[sIdx].sold_out) {
                        avaClass = (isOddTable) ? 'ava01' : 'ava02';
                    }
                    //console.log(seats[sIdx]);
                    //if (countSeat >= 0) {
                    htmlToRender += '<td class="rs-void ' + avaClass + '" rowspan="' + rowSpan + '"><span>'
                            + seats[sIdx].seat_class
                            + withRadioButton
                            + '(' + seats[sIdx].available_seat + ')<br>' +
                            +String(seats[sIdx].fare).substring(0, String(seats[sIdx].fare).length - 3)
                            + '</span></td>';
                    //};
                }
                if (countSeat > 0) {
                    for (var cS = 0; cS < countSeat; cS++) {
                        htmlToRender += '<td class="rs-void" rowspan="' + rowSpan + '"></td>';
                    }
                }
                htmlToRender += '</table>';
            }
        }
        return htmlToRender;
    };
    jQuery.jsonSearchResultToTable = function (
            jsonData,
            tabToRender,
            reRenderIndex
            ) {
        console.log(jsonData);
        var htmlToRender = '';
        var flightInf = jsonData.flight_info;
        var htmlToRender = '';
        var renderIndex = 0;
        var hoverEvtIdx = [];

        //berarti ada multiple array
        if (typeof (flightInf.airline) === 'undefined') {
            for (var flInf in jsonData.flight_info) {
                if (typeof (flightInf[flInf].schedule) !== 'undefined' && flightInf[flInf].schedule !== null) {
                    var departureData = flightInf[flInf].schedule.departure;
                    var lowesT = departureData.lowest_fare_schedule;
                    var flightInfoData = flightInf[flInf];
                    var lastUpdate = departureData.last_update;
                    var isObsoleteData = jQuery.isObsoleteData(lastUpdate);
                    //var isObsoleteData = false;
                    if (!isObsoleteData) {
                        //render lowest
                        htmlToRender += jQuery.eachContentToTable(
                                lowesT,
                                flightInfoData,
                                jsonData.params,
                                renderIndex
                                );
                        hoverEvtIdx.push(renderIndex);
                    }
                    else {
                        htmlToRender += jQuery.addLoadingTableForRender(renderIndex);
                        jQuery.researchObsoleteDepartureData(flightInfoData, renderIndex);
                        console.log('trytoresearch');
                        console.log(lastUpdate);
                        console.log(flightInfoData);
                        console.log('/trytoresearch');
                    }
                }
                else {
                    console.log('research on null');
                    jQuery.researchObsoleteDepartureData(flightInf[flInf], renderIndex);
                    console.log('/research on null');
                }
                ;
                renderIndex++;
            }
        }
        else {
            console.log('ada renderindex');
            if (flightInf.schedule === null ||
                    (
                            flightInf.schedule !== null
                            //&& (typeof (flightInf.schedule.departure) !== 'undefined'
                            && flightInf.schedule.departure === null
                            )
                    ) {
                console.log('cari ulang ketika tetap null');
                jQuery.researchObsoleteDepartureData(flightInf, renderIndex);
            }

            else {
                var departureData = flightInf.schedule.departure;
                var lowesT = departureData.lowest_fare_schedule;
                var flightInfoData = flightInf;
                var lastUpdate = departureData.last_update;
                var isObsoleteData = jQuery.isObsoleteData(lastUpdate);
                //var isObsoleteData = false;
                if (!isObsoleteData) {
                    //render lowest
                    htmlToRender += jQuery.eachContentToTable(
                            lowesT,
                            flightInfoData,
                            jsonData.params,
                            renderIndex
                            );
                }
                else {
                    htmlToRender += jQuery.addLoadingTableForRender(renderIndex);
                    console.log('cari ulang ketika datanya usang');
                    jQuery.researchObsoleteDepartureData(flightInfoData, renderIndex);
                }
            }

        }
        ;
        $(tabToRender).html(htmlToRender);
        for (var hI in hoverEvtIdx) {
            $.addHoverEvent('table.render-' + hoverEvtIdx[hI]);
        }
    };
    jQuery.cariTiketPesawat = function (destAsal, destAkhir, pergi, pulang, personToGo, airlineID, renderIndex) {
        //personToGo.adult,personToGo.children,personToGo.infant
        var searchParams = {
            origin: destAsal,
            destination: destAkhir,
            pergi: pergi,
            pulang: pulang,
            personToGo: personToGo
        };
        if (typeof (airlineID) !== 'undefined') {
            searchParams.airline_id = airlineID;
        }
        ;
        console.log('perMaskapai?' + airlineID);
        console.log('perTabel?' + renderIndex);
        jQuery.ajax({
            url: baseUrl + 'ajax/caritiket.php',
            data: searchParams,
            type: "POST",
            dataType: 'JSON',
            beforeSend: function (xhr) {
                //jika yang di load adalah table yang obsolete
                if (typeof (renderIndex) !== 'undefiined') {
                    $(contentTabActiveID + ' table.render-' + renderIndex).html($.addLoadingTableContentForRender());
                }
                else {
                    //jika yang di loadd adalah tab content
                    $(contentTabActiveID).html('<table class="zonaresult" cellpadding="0" cellspacing="0">'
                            + '<tr><td class="rs-maskapai"><br/>Loading...</td>'
                            + '</tr></table>');
                }
                NProgress.start();
            },
            success: function (json) {
                console.log(json.flight_info.airline);
                if (typeof (renderIndex) !== 'undefined') {
                    jQuery.updateSearchResultObject(json);
                }
                jQuery.jsonSearchResultToTable(json, contentTabActiveID, renderIndex);
            },
            error: function (response) {
                if (typeof (renderIndex) !== 'undefiined') {
                    $(contentTabActiveID + ' table.render-' + renderIndex).html($.addLoadingTableContentForRender());
                }
                else {

                    $(contentTabActiveID).html('<table class="zonaresult" cellpadding="0" cellspacing="0">'
                            + '<tr><td class="rs-maskapai"><br/>Silakan Coba Lagi</td>'
                            + '</tr></table>');
                }
            },
            complete: function (xhr) {
                NProgress.done(true);
            }
        });
    }
    ;
    (function ($) {
        $(document).ready(function () {
            initializeSearch();
            //jenis perjalanan
            $('input[name=round][type=radio]').click(function (evt) {
                var thisVal = $(this).val();
                if (thisVal == 'no') {
                    $('.zonapulang').hide();
                }
                else {
                    $('.zonapulang').show();
                }
            });
            var isValidForm = false;
            var pulang = $('#pulang').val();
            var pergi = $('#pergi').val();
            var destAsal = $('select[name=asal]').val();
            var destAkhir = $('select[name=tujuan]').val();
            var personToGo = $('select[name=dewasa]').val() + '.' + $('select[name=anak]').val() + '.' + $('select[name=bayi]').val();
            var maskapai = $('input:checkbox:checked.maskapaicheck').map(function () {
                return this.value;
            }).get();
            var transitType = $('input:checkbox:checked.transitcheck').map(function () {
                return this.value;
            }).get();
            var dirWay = $('input[name=dir][type=radio]:checked').val();
            //mulai pencarian ketika klik tombol
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
                }
                else {

                    if (getParameterByName('page') !== 'caritiketpesawat') {
                        //jika bukan di halaman utama pencarian
                        $('#formCariTiketPesawat').submit();
                    }
                    else {
                        $(contentTabActiveID).html($.addLoadingTableForRender());
                        $.cariTiketPesawat(
                                $('select[name=asal]').val(),
                                $('select[name=tujuan]').val(),
                                $('#pergi').val(),
                                (
                                        $('#pulang').val().length == 0
                                        || $('input[name=dir][type=radio]:checked').val() == 'go'
                                        ? 'NA' : $('#pulang').val()
                                        ),
                                {
                                    adult: $('#dewasa').val(),
                                    children: $('#anak').val(),
                                    infant: $('#bayi').val()
                                }
                        );
                    }
                }
            }); //end of buttonCariClickEvent

        });
        $(function () {
            $("#dt-cil, #dt-inf").datepicker({dateFormat: 'dd/mm/y'}).val();
            var dateToday = new Date();
            var dates = $("#pergi, #pulang").datepicker(
                    {
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                        numberOfMonths: 3,
                        minDate: dateToday,
                        dateFormat: 'dd/mm/y',
                        onSelect: function (selectedDate) {
                            var option = this.id == "pergi" ? "minDate" : "maxDate",
                                    instance = $(this).data("datepicker"),
                                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                            //console.log(option,instance,date);
                            if (this.id == 'pergi') {
                                $('#pulang').datepicker("option", option, date);
                            }
                        }
                    }
            ).val();
            //get time
            var theTimes = getParameterByName('t');
            theTimes = theTimes.split('.');
            if (typeof (theTimes[0]) !== 'undefined') {
                $('#pulang').datepicker('option', 'minDate', theTimes[0]);
            }
        });
        $(function () {
            $("#dewasa")
                    .selectmenu()
                    .selectmenu("menuWidget")
                    .addClass("overflow");
            $("#anak")
                    .selectmenu()
                    .selectmenu("menuWidget")
                    .addClass("overflow");
            $("#bayi")
                    .selectmenu()
                    .selectmenu("menuWidget")
                    .addClass("overflow");
        });
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

    })(jQuery);
});
