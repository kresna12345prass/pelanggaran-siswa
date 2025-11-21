import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
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

    // 1. Tabel Verifikasi (Halaman Index)
    if ($('#verifikasiTable').length) {
        $('#verifikasiTable').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            // Kolom: 0:No, 1:Tanggal, 2:Siswa, 3:Kelas, 4:Pelanggaran, 5:Poin, 6:Aksi
            columnDefs: [
                { orderable: false, targets: [0, 6] }, 
                { className: 'text-center', targets: [0, 3, 5, 6] }, 
                { className: 'dt-body-nowrap', targets: 6 } 
            ],
            order: [[1, 'desc']], 
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            rowCallback: function(row, data, index) {
                var pageInfo = this.api().page.info();
                var rowNumber = pageInfo.start + index + 1;
                $('td:eq(0)', row).html(rowNumber);
            }
        });
    }

    // 2. Tabel Riwayat (Halaman Riwayat)
    if ($('#riwayatTable').length) {
        $('#riwayatTable').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            // Kolom: 0:No, 1:Nama, 2:Kelas, 3:Jenis, 4:Poin, 5:Status, 6:Aksi
            columnDefs: [
                { orderable: false, targets: [0, 6] }, // No & Aksi
                { className: 'text-center', targets: [0, 2, 4, 5, 6] }, // Center: No, Kelas, Poin, Status, Aksi
                { className: 'dt-body-nowrap', targets: 6 }
            ],
            order: [[0, 'asc']], // Default urutkan berdasarkan No/Nama jika tidak ada tanggal
            pageLength: 10
        });
    }
});