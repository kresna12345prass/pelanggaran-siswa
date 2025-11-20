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
        info: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
            paginate: {
                first: '<i class="fa-solid fa-angles-left"></i>',
                previous: '<i class="fa-solid fa-angle-left"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
                last: '<i class="fa-solid fa-angles-right"></i>'
            }
        },
        columnDefs: [
            { className: 'dtr-control', orderable: false, targets: 0 },
            { orderable: false, targets: [1] },
            { className: 'text-center', targets: [0, 1, 8] },
            { responsivePriority: 1, targets: 4 },
            { responsivePriority: 2, targets: 8 }
        ],
        order: [[2, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });
});