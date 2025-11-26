$(document).ready(function() {
    $('#guruTable').DataTable({
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
            { className: 'text-center', targets: [0, -1] }
        ],
        order: [[2, 'asc']],
        drawCallback: function(settings) {
            var api = this.api();
            var startIndex = api.context[0]._iDisplayStart;
            api.column(0, {page:'current'}).nodes().each(function(cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById('deleteModal');
    
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nama = button.getAttribute('data-nama');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            deleteModal.querySelector('.modal-title').textContent = 'Hapus Guru: ' + nama;
            deleteModal.querySelector('.modal-body-text').textContent = 'Apakah Anda yakin ingin menghapus guru "' + nama + '"? Tindakan ini tidak dapat dibatalkan.';
            deleteModal.querySelector('#deleteForm').setAttribute('action', deleteUrl);
        });
    }
});
