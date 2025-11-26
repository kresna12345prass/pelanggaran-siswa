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

    if ($('#prestasiTable').length) {
        const table = $('#prestasiTable').DataTable({
            responsive: true,
            info: false,
            language: languageConfig,
            // Kolom: 0:No, 1:Tanggal, 2:Jenis, 3:Tingkat, 4:Pencatat, 5:Aksi
            columnDefs: [
                { orderable: false, targets: [0, 5] }, // No & Aksi tidak bisa sort
                { className: 'text-center', targets: [0, 3, 5] }, // Center alignment
                { className: 'dt-body-nowrap', targets: 5 } // Aksi jangan turun baris
            ],
            order: [[1, 'desc']], // Sort by Tanggal (Index 1)
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
        });

        // Penomoran otomatis
        table.on('draw', function() {
            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    }
});