import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    const table = $('#siswaTable').DataTable({
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
            { orderable: false, targets: [0, 1, -1] },
            { className: 'text-center', targets: [0, 1, -1] }
        ],
        order: [[3, 'asc']]
    });

    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});


// 3. KODE MODAL HAPUS
document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteSiswaModal'); 
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const siswaName = button.getAttribute('data-siswa-name'); 
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const siswaNameElement = deleteConfirmModal.querySelector('#siswaNameToDelete');
            const deleteForm = deleteConfirmModal.querySelector('#deleteSiswaForm');
            
            // Update nama siswa di modal
            if (siswaNameElement) {
                siswaNameElement.textContent = siswaName;
            }
            
            // Update action form
            if (deleteForm) {
                deleteForm.setAttribute('action', deleteUrl);
            }
        });
    }
});