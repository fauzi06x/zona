document.addEventListener("DOMContentLoaded", function (eventContentLoaded) {
    jQuery(document).ready( function () {
        $('#dtMember').DataTable({
            ajax: {
                url: baseUrl + 'ajax/listMember.php',
                type: 'POST', 
            },
                serverSide: true,
                processing: true,
                columns: [
                    {data: "num"},
                    {data: "l"},
                    {data: "m"},
                    {data: "n"},
                    {data: "p"},
                    {data: "pk"},
                    {data: "pr"},
                    {data: "ka"},
                    {data: "ke"},
                ]
        });
    });
});
