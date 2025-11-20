import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Konfigurasi umum bahasa Indonesia
const languageConfig = {
    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
    paginate: {
        first: '<i class="fa-solid fa-angles-left"></i>',
        previous: '<i class="fa-solid fa-angle-left"></i>',
        next: '<i class="fa-solid fa-angle-right"></i>',
        last: '<i class="fa-solid fa-angles-right"></i>'
    }
};

$(document).ready(function() {
    // 1. Inisialisasi Tabel Update Pelaksanaan (Halaman Index)
    if ($('#tablePelaksanaan').length) {
        const table1 = $('#tablePelaksanaan').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            columnDefs: [
                { orderable: false, targets: [0, 7] }, // No dan Aksi
                { className: 'text-center', targets: [0, 3, 6, 7] },
                { className: 'dt-body-nowrap', targets: 7 }
            ],
            pageLength: 10,
            order: [[5, 'desc']] // Tanggal Mulai
        });

        table1.on('draw', function() {
            table1.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    }

    // 2. Inisialisasi Tabel Riwayat (Halaman Riwayat - Jika ada di project)
    if ($('#tableRiwayat').length) {
        const table2 = $('#tableRiwayat').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            columnDefs: [
                { orderable: false, targets: [0, 5] }, // No dan Aksi (index 5)
                { className: 'text-center', targets: [0, 2, 5] }, // No, Kelas, Aksi
                { className: 'dt-body-nowrap', targets: 5 }
            ],
            pageLength: 10,
            order: [[4, 'desc']] // Tanggal Pelaksanaan (index 4)
        });

        table2.on('draw', function() {
            table2.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    }
});