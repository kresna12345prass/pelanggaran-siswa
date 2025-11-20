import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Konfigurasi Bahasa
const languageConfig = {
    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
    paginate: {
        first: '<i class="fa-solid fa-angles-left"></i>',
        previous: '<i class="fa-solid fa-angle-left"></i>',
        next: '<i class="fa-solid fa-angle-right"></i>',
        last: '<i class="fa-solid fa-angles-right"></i>'
    }
};

// Helper untuk penomoran otomatis
function addAutoNumbering(table) {
    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
}

$(document).ready(function() {
    // 1. TABEL INDEX SANKSI (#sanksiTable)
    if ($('#sanksiTable').length) {
        const tableIndex = $('#sanksiTable').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            columnDefs: [
                { orderable: false, targets: [0, 5] }, // No & Aksi
                { className: 'text-center', targets: [0, 2, 4, 5] },
                { className: 'dt-body-nowrap', targets: 5 }
            ],
            order: [[1, 'asc']] // Sort by Nama Siswa
        });
        addAutoNumbering(tableIndex);
    }

    // 2. TABEL PILIH SISWA DI CREATE (#tableSiswa)
    if ($('#tableSiswa').length) {
        const tableSiswa = $('#tableSiswa').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Semua"]],
            columnDefs: [
                { orderable: false, targets: 4 }, // Aksi
                { className: 'text-center', targets: [2, 3, 4] } // Kelas, Poin, Aksi
            ]
        });
        // Tidak perlu auto-numbering karena kolom pertama adalah NIS (bukan No Urut)
    }

    // 3. TABEL REFERENSI DI CREATE (#tableReferensi)
    if ($('#tableReferensi').length) {
        $('#tableReferensi').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Semua"]],
            columnDefs: [
                { className: 'text-center', targets: [0, 2] } // Kategori, Range
            ],
            order: [[2, 'asc']] // Sort by Range Poin (Asumsi index 2)
        });
    }
});