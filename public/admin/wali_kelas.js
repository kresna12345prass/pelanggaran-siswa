$(document).ready(function() {
    const table = $('#waliKelasTable').DataTable({
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
            { orderable: false, targets: [0, -1] },
            { className: 'text-center', targets: [0, 2, 3, -1] },
            { className: 'dt-body-nowrap', targets: -1 }
        ],
        order: [[1, 'asc']]
    });

    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById('deleteWaliKelasModal');
    
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nama = button.getAttribute('data-wali-kelas-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            deleteModal.querySelector('.modal-title').textContent = 'Hapus Wali Kelas: ' + nama;
            deleteModal.querySelector('.modal-body-text').textContent = 'Apakah Anda yakin ingin menghapus wali kelas "' + nama + '"? Tindakan ini tidak dapat dibatalkan.';
            deleteModal.querySelector('#deleteWaliKelasForm').setAttribute('action', deleteUrl);
        });
    }
});