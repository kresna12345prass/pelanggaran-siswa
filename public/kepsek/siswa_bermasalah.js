$(document).ready(function() {
    $('#siswaTable').DataTable({
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
            { orderable: false, targets: [1, -1] },
            { className: 'text-center', targets: [0, 1, 5, -1] },
            { responsivePriority: 1, targets: 3 },
            { responsivePriority: 2, targets: -1 }
        ],
        order: [[5, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });
});
