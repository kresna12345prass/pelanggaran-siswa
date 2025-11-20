import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    $('#sanksiTable').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 0
            }
        },
        info: true,
        paging: true,
        pageLength: 10,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
            paginate: {
                first: '<i class="fa-solid fa-angles-left"></i>',
                last: '<i class="fa-solid fa-angles-right"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
                previous: '<i class="fa-solid fa-angle-left"></i>'
            }
        },
        columnDefs: [
            { className: 'dtr-control', orderable: false, targets: 0 },
            { orderable: false, targets: [1, -1] },
            { className: 'text-center', targets: [0, 1, 4, -1] },
            { responsivePriority: 1, targets: 2 },
            { responsivePriority: 2, targets: -1 }
        ],
        order: [[2, 'asc']]
    });
});
