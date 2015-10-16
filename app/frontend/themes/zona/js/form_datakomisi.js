document.addEventListener("DOMContentLoaded", function (eventContentLoaded) {
    jQuery(document).ready( function () {
        $('#dtKomisi').DataTable({
            ajax: {
                url: baseUrl + 'ajax/listKomisi.php',
                type: 'POST', 
            },
                serverSide: true,
                processing: true,
                columns: [
                    {data: "num"},
                    {data: "t"},
                    {data: "m"},
                    {data: "k"},
                    {data: "j"},
                    {data: "s"}
                ]
        });
    });
});