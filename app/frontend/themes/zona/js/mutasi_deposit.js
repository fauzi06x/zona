document.addEventListener('DOMContentLoaded', function (eXX) {
    (function ($) {
        var fmtUang = function (data) {
            return parseFloat(data).formatMoney();
        };
        $('#mutasiDeposit').DataTable({
            ajax: {
                url: baseUrl + 'ajax/listMutasiDeposit.php',
                type: 'POST',
            },
            serverSide: true,
            processing: true,
            columns: [
                {data: "num", orderable: false, searchable: false},
                {data: "date", render: function (data, type, full, meta) {
                        var splited = data.split('.');
                        var date = new Date(splited[0].replace(/-/g, '/'));
                        return date.format('d-m-yyyy H:M:s');
                    }},
                {data: "d", render: fmtUang},
                {data: "k", render: fmtUang},
                {data: "ls", render: fmtUang},
                {data: "cs", render: fmtUang},
                {data: "kt"},
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
        });
    })(jQuery);
});