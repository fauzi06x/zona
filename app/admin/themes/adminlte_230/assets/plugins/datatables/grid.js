$.extend($.fn.dataTableExt.oStdClasses, {
    "sWrapper": $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper",
    "sFilterInput": "form-control input-small input-sm input-inline",
    "sLengthSelect": "form-control input-xsmall input-sm input-inline"
});
$.extend($.fn.dataTable.defaults, {
    "processing": true,
    "serverSide": true,
    "lengthMenu": [
        [10, 20, 50, 100, 150, -1],
        [10, 20, 50, 100, 150, "Semua"]
    ],
    "pageLength": 10,
    "bStateSave": true,
    "dom": "t<'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'p>>",
    "language": {
        "metronicGroupActions": "_TOTAL_ records selected:  ",
        "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
        "lengthMenu": "Lihat _MENU_ data",
        "info": "<span class='seperator'>|</span> jumlah total: _TOTAL_ data",
        "infoEmpty": "Tidak ada data yang ditampilkan",
        "emptyTable": "Tidak ada data yang ditampilkan",
		"sInfoFiltered": " | dari: _MAX_ total data",
        "zeroRecords": "Hasil pencarian tidak ada.",
        "paginate": {
            "previous": "Prev",
            "next": "Next",
            "last": "Last",
            "first": "First",
            "page": "Page",
            "pageOf": "of"
        }
    },
    "pagingType": "bootstrap_full_number",
   
});

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    orientation: "left",
    autoclose: true
});
