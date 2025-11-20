import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    const table = $('#monitoringTable').DataTable({
        responsive: true,
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
            // Target 0 (No) dan -1 (Aksi) tidak bisa disortir
            { orderable: false, targets: [0, -1] },
            // Target 0, 2 (Kelas), 4 (Status), dan -1 (Aksi) rata tengah
            { className: 'text-center', targets: [0, 2, 4, -1] },
            // Kolom aksi tidak boleh turun baris (wrap)
            { className: 'dt-body-nowrap', targets: -1 }
        ],
        // Default sort berdasarkan kolom ke-1 (Nama Siswa)
        order: [[1, 'asc']],
        pageLength: 10
    });

    // Fitur penomoran otomatis (agar nomor urut tetap benar saat searching/pagination)
    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});