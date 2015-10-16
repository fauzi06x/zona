document.addEventListener("DOMContentLoaded", function (eventContentLoaded) {
    jQuery.changeHTMLTab = function (allTabAnchor, theCurrentDateStr, daySToAdd) {
        allTabAnchor.each(function (index) {
            var addDay = index - parseInt(daySToAdd);
            var theDay = jQuery.addOneDay(theCurrentDateStr, addDay);
            var dateStr = theDay.dateStr;
            var dateHtml = theDay.namaHari + "<br/>" + theDay.dateStrip;
            var dateStrSlash = theDay.dateSlash;
            $(this).html(dateHtml);
            $(this).data('datestr', dateStr);
            $(this).data('tanggal', dateStrSlash);
        });
    };
    jQuery.addOneDay = function (previousDayStr, dayS) {
        dayS = typeof (dayS) === 'undefined' ? 1 : dayS;
        var plus1Day = new Date(previousDayStr);
        var oneDayInMS = (1000 * 60 * 60 * 24) * dayS;
        var theDate = new Date(plus1Day.getTime() + oneDayInMS);
        var monthNames = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        var hariIndo = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        var ret = {};
        ret.dateStr = theDate.getDate() + ' ' + monthNames[theDate.getMonth()] + ' ' + theDate.getFullYear() + ' 00:00:00';
        ret.namaHari = hariIndo[theDate.getDay()];
        ret.dateStrip = theDate.getDate()
                + '-' + ("0" + (theDate.getMonth() + 1)).slice(-2)
                + '-' + theDate.getFullYear();
        ret.dateSlash = theDate.getDate()
                + '/' + ("0" + (theDate.getMonth() + 1)).slice(-2)
                + '/' + theDate.getFullYear().toString().slice(-2);
        return ret;
    };
    jQuery.slideTheTab2 = function (dayRangeFrom, tabSelector, theCurrentDateStr, dayRangeTo) {
        var selectedTab = $(tabSelector).tabs("option", "active");
        var theReturn = true;
        var allTabAnchor = $(tabSelector).find('li a');
        if (dayRangeTo < -2) {
            //ini jika mau ke kiri
            if (dayRangeFrom < 2) {
                //ini jiika mau mepet
                if (selectedTab !== dayRangeFrom) {
                    //console.log('jika mau mepet');
                    var dayToAdd = selectedTab + dayRangeFrom;
                    jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, dayToAdd);
                    $(tabSelector).tabs("option", "active", 6 + selectedTab + dayRangeFrom);
                }
            }
            else {
                jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, 3);
                $(tabSelector).tabs("option", "active", 3);
            }
        }
        else if (dayRangeTo > -2) {
            //ini jika udah mepet ke kanan
            var isSameEnd = 6 + dayRangeTo;
            if (dayRangeFrom > 2) {
                //aman, terus ditambah jika menjauhi tanggal berangkat
                jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, 3);
                $(tabSelector).tabs("option", "active", 3);
            }
            else {
                if (selectedTab !== dayRangeFrom) {
                    var isSameStart = selectedTab + dayRangeFrom;
                    jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, isSameStart);
                    $(tabSelector).tabs("option", "active", isSameStart);
                }
            }
        }
        return theReturn;
    };
    jQuery.slideTheTab = function (dayRangeFrom, tabSelector, theCurrentDateStr, dayRangeTo) {//, selectedTab) {
        //alert('theCurrentDateStr:' + theCurrentDateStr);
        var selectedTab = $(tabSelector).tabs("option", "active");
        //console.log("SELECTEDTab:" + selectedTab);
        var theReturn = false;
        var allTabAnchor = $(tabSelector).find('li a');
        if (dayRangeFrom > 2) {
            var isSame = selectedTab === (6 + dayRangeTo);
            if (dayRangeTo > -3) {
                if (!isSame) {
                    jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, 6 + dayRangeTo);
                    $(tabSelector).tabs("option", "active", 6 + dayRangeTo);
                }
            }
            else {

                jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, 3);
                $(tabSelector).tabs("option", "active", 3);
            }
        }
        else if (dayRangeFrom < 3) {
            var isSameStart = selectedTab + dayRangeFrom;
            if (selectedTab !== dayRangeFrom) {
                jQuery.changeHTMLTab(allTabAnchor, theCurrentDateStr, isSameStart);
                $(tabSelector).tabs("option", "active", isSameStart);
            }
        }
        if (dayRangeFrom >= 0 && dayRangeTo <= 0) {
            theReturn = true;
        }
        
        return theReturn;
    };
    jQuery.getTimeFromDateStr = function (dateStr) {
        var theDt = new Date(dateStr);
        return theDt.getTime();
    };
    jQuery.rangeDayWith = function (theDateActiveTab, currentDate) {
        var mustBigger = new Date(theDateActiveTab);
        var mustSmaller = [];
        if (typeof (currentDate) === 'undefined') {
            mustSmaller = new Date(serverDate + ', 00:00:00');
        }
        else {
            mustSmaller = new Date(currentDate);
        }

        var range = mustBigger.getTime() - mustSmaller.getTime();
        return parseInt(range / 1000 / 60 / 60 / 24);
    };

    (function ($) {
        contentTabActiveID = '#tabs-' + (activeTabIndex1 + 2);
        contentTabActiveID2 = '#tabs-' + (activeTabIndex2 + 10);
        $("#tabs").tabs({
            active: activeTabIndex1,
            activate: function (event, ui) {

            },
            beforeActivate: function (evt, ui) {
                var objAnchor = jQuery(evt.delegateTarget);
                var tglKembali = $('#tabs02').tabs("option", "active");
                var theSecondAnchor = $("#tabs02 ul>li a").eq(tglKembali);
                var dayRangeFrom = jQuery.rangeDayWith(objAnchor.data('datestr'));
                var isRoundTrip = jQuery('input[type=radio][name=round]').val();

                var dayRangeTo = isRoundTrip == 'no' ? 1 : jQuery.rangeDayWith(theSecondAnchor.data('datestr'), objAnchor.data('datestr'));
                if (dayRangeTo < 0) {
                    swal('Error','Tanggal Berangkat tidak boleh mendahului tanggal Kembali','error');
                    return false;
                }
                else {
                    jQuery.abortPreviousRequest(false);
                }
                ;
            }

        });
        $('#tabs02').tabs({
            active: activeTabIndex2,
            beforeActivate: function (evt, ui) {
                var objAnchor = ui.newTab.find('a');//jQuery(evt.delegateTarget);
                var tglBerangkat = $('#tabs').tabs("option", "active");
                var tabBerangkat = $("#tabs ul>li a").eq(tglBerangkat);
                //ga perlu day range to... 
                var dayRangeTo = jQuery.rangeDayWith(objAnchor.data('datestr'), tabBerangkat.data('datestr'));
                if (dayRangeTo < 0) {
                    alert('Tanggal Kembali tidak boleh lebih awal dari Tanggal Berangkat');
                    evt.preventDefault();
                    return false;
                }
                else {
                    jQuery.abortPreviousRequest(true);
                }
                ;
            }
        });
        $("#tabs").on("tabsactivate", function (event, ui) {
            var active = $('#tabs').tabs('option', 'active');
            contentTabActiveID = $("#tabs ul>li a").eq(active).attr("href");
            jQuery(contentTabActiveID).html('');
        });
        $("#tabs02").on("tabsactivate", function (event, ui) {
            var active = $('#tabs02').tabs('option', 'active');
            contentTabActiveID2 = $("#tabs02 ul>li a").eq(active).attr("href");
            jQuery(contentTabActiveID2).html('');
        });

        $("#tabs").on("click", "ul>li", function (evt) {
            var theAnchor = $(this).find('a');
            var tabTanggal = theAnchor.data("tanggal");
            var tabTanggalStr = theAnchor.data("datestr");
            var dayRange = $.rangeDayWith(tabTanggalStr);
            var tglKembali = $('#tabs02').tabs("option", "active");
            var theSecondAnchor = $("#tabs02 ul>li a").eq(tglKembali);
            var isRoundTrip = $('input[type=radio][name=round]').val();
            var dayRangeTo = isRoundTrip == 'no' ? -7 : $.rangeDayWith(tabTanggalStr, theSecondAnchor.data("datestr"));
            if (dayRangeTo < 1) {
                
                flightLength = 0;
                flightLength=flightLength + maxRepeatSearchPerFlight;
                hasFinished=0;
                $('#selectedFlyInfo').slideUp(1);
                $('#CariTiketPesawatSection').slideDown(1);
                jQuery('#theNprogressBar').fadeIn('fast');
                jQuery.slideTheTab(dayRange, '#tabs', tabTanggalStr, dayRangeTo);
                $('#pergi').val(tabTanggal);
                jQuery.changeDtStatus(false);
                jQuery(contentTabActiveID).html('');
                var formVal = jQuery.semuaInputForm();
                jQuery.abortPreviousRequest(false);
                scheduleList = [];
                ///pulangnya NA
                for (var m = 0; m < formVal.maskapai.length; m++) {
                    var airlineID = formVal.maskapai[m];
                    //console.log(formVal);
                    jQuery.cariTiketPesawat(
                            formVal.destAsal, //ini ngga dibalik
                            formVal.destAkhir,
                            formVal.tglBerangkat, //menggunakan tanggal berangkat, 
                            //kalo di pulang , menggunakan tanggal pulang
                            'NA',
                            formVal.personToGo,
                            true,
                            airlineID,
                            0,
                            false);
                } 
            }
            else {
                console.log('else di handle di beforeActive');
            }
        });
        $("#tabs02").on("click", "ul>li", function (ev) {
//            if ($(this).hasClass('ui-tabs-active')) {
//                return false;
//            }
            var theAnchor = $(this).find('a');
            var tabTanggal = theAnchor.data("tanggal");
            var tabTanggalStr = theAnchor.data("datestr");
            var dayRangeTo = $.rangeDayWith(tabTanggalStr);
            var tglBerangkat = $('#tabs').tabs("option", "active");
            var theFirstAnchor = $("#tabs ul>li a").eq(tglBerangkat);
            var dayRangeFrom = $.rangeDayWith(tabTanggalStr, theFirstAnchor.data("datestr"));
            if (dayRangeFrom > -1) {
                flightLength = 0;
                flightLength=flightLength + maxRepeatSearchPerFlight;
                hasFinished=0;
                $('#selectedFlyInfo').slideUp(1);
                $('#CariTiketPesawatSection').slideDown(1);
                jQuery('#theNprogressBar').fadeIn('fast');
                
                jQuery.slideTheTab2(dayRangeFrom, '#tabs02', tabTanggalStr, dayRangeTo);

                //if (true === isSlide) {
                jQuery.abortPreviousRequest(true);
                $('#pulang').val(tabTanggal);
                jQuery(contentTabActiveID2).html('');
                jQuery.changeDtStatus(true);
                var formVal = jQuery.semuaInputForm();
                ///pulangnya NA
                scheduleLeave = [];
                for (var m = 0; m < formVal.maskapai.length; m++) {
                    var airlineID = formVal.maskapai[m];
                    //console.log(formVal);
                    jQuery.cariTiketPesawat(
                            formVal.destAkhir, //ini dibalik
                            formVal.destAsal,
                            formVal.tglKembali, //menggunakan tanggal kembali
                            'NA',
                            formVal.personToGo,
                            true,
                            airlineID,
                            0,
                            true);

                }
                //jQuery.cariTiketPesawat();
                //}
                //else nya dii handle di beforeActivate
            }
        });
    })(jQuery);
});