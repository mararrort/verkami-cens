import 'datatables.net-bs4'

$( function () {
    $("#presalesTableId").DataTable({
        "language": {
            "url": 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
        },
        "order": [ 4, 'desc' ]
    });
} );