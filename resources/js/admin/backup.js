import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    const table = $('#backupTable').DataTable({
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
        order: [[3, 'desc']] // Sort by date descending
    });

    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});

// Modal Hapus Backup
document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteBackupModal'); 
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const backupName = button.getAttribute('data-backup-name'); 
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const modalTitle = deleteConfirmModal.querySelector('.modal-title');
            const modalBody = deleteConfirmModal.querySelector('.modal-body-text');
            const deleteForm = deleteConfirmModal.querySelector('#deleteBackupForm');
            
            modalTitle.textContent = 'Hapus Backup: ' + backupName;
            modalBody.textContent = 'Apakah Anda yakin ingin menghapus backup "' + backupName + '"? Tindakan ini tidak dapat dibatalkan.';
            deleteForm.setAttribute('action', deleteUrl);
        });
    }
});