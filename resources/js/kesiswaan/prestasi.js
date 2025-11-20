import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    var table = $('#prestasiTable').DataTable({
        responsive: true,
        info: false,
        searching: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
            paginate: {
                first: '<i class="fa-solid fa-angles-left"></i>',
                previous: '<i class="fa-solid fa-angle-left"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
                last: '<i class="fa-solid fa-angles-right"></i>'
            }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // Urutkan berdasarkan Kolom Poin (index 5) secara descending secara default
        order: [[5, 'desc']], 
        columnDefs: [
            // Non-orderable: No (0) dan Aksi (6)
            { orderable: false, targets: [0, 6] },
            // Center align: No (0), Kelas (2), Tingkat (4), Poin (5), Aksi (6)
            { className: 'text-center', targets: [0, 2, 4, 5, 6] },
            // Mencegah kolom aksi turun baris
            { className: 'dt-body-nowrap', targets: 6 }
        ]
    });
    
    // Penomoran otomatis
    table.on('draw.dt', function() {
        var info = table.page.info();
        table.column(0, { page: 'current' }).nodes().each(function(cell, i) {
            cell.innerHTML = info.start + i + 1;
        });
    });
});