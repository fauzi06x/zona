document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    
    jQuery.bookingData = {};
    jQuery.bookingData.renderToBookListTable = function (resp) {
        var tableBodyHtml = '';
        var numbering = (resp.offset + 1);
        var tdDetailOpener = {
            1: '<div class="btn bt-sm-buk orange">',
            2: '<div class="btn bt-sm-buk orange">',
            3: '<div class="btn orange bt-sm-buk" style="color:red">',
            4: '<div class="btn orange bt-sm-buk" style="color:#01a528">',
            5: '<div class="btn orange bt-sm-buk" style="color:blue">',
            6: '<div class="btn orange bt-sm-buk" style="color:yellow">'
        };
        var tdDetailCloser = '</div>';
        if (resp.result.length == 0) {
            tableBodyHtml += '<tr><td colspan="10" style="text-align: center">(no data found)</td></tr>';
        }
        for (var rS in resp.result) {
            tableBodyHtml += '<tr class="grey0' + (numbering % 2 == 0 ? '2' : '3') + '">';
            tableBodyHtml += '<td>' + numbering + '</td>';
            tableBodyHtml += '<td>' + resp.result[rS].maskapai + '</td>';
            tableBodyHtml += '<td>' + resp.result[rS].bookcode + '</td>';
            tableBodyHtml += '<td>' + resp.result[rS].pemesan + '</td>';
//            tableBodyHtml += '<td>' + resp.result[rS].ticket_no + '</td>';
var dateBookDate=new Date(resp.result[rS].datebook);
            tableBodyHtml += '<td>' + 's' + '</td>';
            tableBodyHtml += '<td>' + parseFloat(resp.result[rS].total).formatMoney() + '</td>';
            tableBodyHtml += '<td>' + parseFloat(resp.result[rS].ntsa).formatMoney() + '</td>';
            tableBodyHtml += '<td>' + parseFloat(resp.result[rS].totalfare - resp.result[rS].ntsa).formatMoney() + '</td>';
            tableBodyHtml += '<td><a href="' + baseUrl + '?page=bookdetail&id=' + resp.result[rS].id + '">' + tdDetailOpener["" + resp.result[rS].statuscode + ""] + (resp.result[rS].statusname) + tdDetailCloser + '</a></td>';
            tableBodyHtml += '<td>' + (resp.result[rS].timelimit) + '</td>';

            tableBodyHtml + '</tr>';
            numbering++;
        }
        jQuery('table#bookingDataTable').find('tbody').html(tableBodyHtml);
    };
    (function ($) {
        $("#tabs-dt-book").tabs();

        $('#retrieveSearch').click(function (evt) {
            var allInput = $('#tabs-1').find('input,select');
            var allData = allInput.serializeArray();
            $.ajax({
                url: baseUrl + 'ajax/getBookingListData.php',
                type: 'POST',
                dataType: 'JSON',
                data: allData,
                success: function (resp) {
                    if (resp.code == 200) {
                        jQuery.bookingData.renderToBookListTable(resp);
                    }
                    else{
                        swal('Error',resp.message,'error');
                        resp.result=[];
                        jQuery.bookingData.renderToBookListTable(resp);
                    }
                },
                error: function (xhr) {
                    
                },
                beforeSend: function () {
                    var tableBodyHtml='<tr><td colspan="10">Please Wait</td></tr>';
                    jQuery('table#bookingDataTable').find('tbody').html(tableBodyHtml);
                    
                },
                complete: function () {
                    
                }


            });
        });
        
    })(jQuery);

});