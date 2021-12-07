import 'datatables.net-bs4'

$( function () {
    $("#presalesTableId").DataTable({
        "order": [ 4, 'desc' ]
    });
} );