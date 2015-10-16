$(document).ready(function(){
    $.extend(true, $.fn.dataTable.defaults, {
        "processing": true,
        "serverSide": true,
        "iDisplayLength": 20,
        "aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
        "sDom": "<r>t<'row'<'col-sm-5 hidden-xs'li><'col-sm-7 col-xs-12 clearfix'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sSearch": "<div class=\"input-group\">_INPUT_<span class=\"input-group-addon\"><i class=\"fa fa-search\"></i></span></div>",
            "sInfo": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong>",
            "oPaginate": {
                "sPrevious": "",
                "sNext": ""
            }
        }
    });
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sWrapper": "dataTables_wrapper",
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });
});