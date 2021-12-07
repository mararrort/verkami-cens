import 'datatables.net-bs4'
$( function () {
    $("#editorialsTableId").DataTable({
        "order": [ 1, 'desc' ]
    });
} );