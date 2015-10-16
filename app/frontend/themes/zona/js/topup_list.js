
var fmtUang = function (data) {
    return parseFloat(data).formatMoney();
};
document.addEventListener('DOMContentLoaded', function (evtContentLoaded) {
    (function ($) {
        $('input[name=dari],input[name=ke]').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('#topUpList').DataTable(
                {
                    order:[[1,'desc']],
                    ajax: {
                        url: baseUrl + 'ajax/listTopUpHistory.php',
                        type: 'POST',
                    },
                    serverSide: true,
                    processing: true,
                    columns: [
                        {data: "num", orderable: false, searchable: false},
                        {data: "dr", render: function (data, type, full, meta) {
                                var splited = data.split('.');
                                var date = new Date(splited[0].replace(/-/g, '/'));
                                return date.format('d-m-yyyy H:M:s');
                            }},
                        {data: "b"},
                        {data: "n",render:fmtUang},
                        {data: "s",
                            render: function (data, type, full, meta) {
                                var status = {
                                    1: 'Pending',
                                    2: 'Canceled',
                                    3: '(unknown)',
                                    4: 'Valid'
                                };
                                return typeof (status[data]) == 'undefined' ? '(N/A)' : status[data];
                            }
                        },
                        /*
                         {data: "id", render: function (data, type, full, meta) {
                         var dataStr = '';
                         for (var x in full) {
                         dataStr += ' data-' + x + '="' + full[x] + '"';
                         }
                         return '<i ' + dataStr + ' style="cursor:pointer" class="fa fa-check-circle"></i>';
                         }
                         },
                         */
                    ]
                }
        );
    })(jQuery);
});