import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    var table = $('#pelanggaranTable').DataTable({
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
            { orderable: false, targets: [0, 6] },
            { className: 'text-center', targets: [4, 5, 6] }
        ],
        order: [[4, 'desc']]
    });
    
    table.on('draw.dt', function() {
        var info = table.page.info();
        table.column(0, { page: 'current' }).nodes().each(function(cell, i) {
            cell.innerHTML = info.start + i + 1;
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById('deletePelanggaranModal');
    
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const siswaName = button.getAttribute('data-siswa-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const siswaNameElement = deleteModal.querySelector('#siswaNameToDelete');
            const deleteForm = deleteModal.querySelector('#deletePelanggaranForm');
            
            if (siswaNameElement) {
                siswaNameElement.textContent = siswaName;
            }
            
            if (deleteForm) {
                deleteForm.setAttribute('action', deleteUrl);
            }
        });
    }
});
