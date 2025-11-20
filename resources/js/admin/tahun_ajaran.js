import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    const table = $('#tahunAjaranTable').DataTable({
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
            { className: 'text-center', targets: [0, 3, -1] },
            { className: 'dt-body-nowrap', targets: -1 }
        ],
        order: [[1, 'desc']]
    });

    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteTahunAjaranModal');
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const taName = button.getAttribute('data-ta-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            deleteConfirmModal.querySelector('.modal-title').textContent = 'Hapus Tahun Ajaran: ' + taName;
            deleteConfirmModal.querySelector('.modal-body-text').textContent = 'Apakah Anda yakin ingin menghapus ' + taName + '? Tindakan ini tidak dapat dibatalkan.';
            deleteConfirmModal.querySelector('#deleteTahunAjaranForm').setAttribute('action', deleteUrl);
        });
    }
});