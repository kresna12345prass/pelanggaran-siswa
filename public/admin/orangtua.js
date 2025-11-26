$(document).ready(function() {
    $('#orangtuaTable').DataTable({
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
        order: [[1, 'asc']]
    });
});


// 3. KODE MODAL HAPUS
document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteOrangtuaModal'); 
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const orangtuaName = button.getAttribute('data-orangtua-name'); 
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const modalTitle = deleteConfirmModal.querySelector('.modal-title');
            const modalBody = deleteConfirmModal.querySelector('.modal-body-text');
            const deleteForm = deleteConfirmModal.querySelector('#deleteOrangtuaForm');
            
            modalTitle.textContent = 'Hapus Orang Tua: ' + orangtuaName;
            modalBody.textContent = 'Apakah Anda yakin ingin menghapus data orang tua "' + orangtuaName + '"? Akun user yang terkait juga akan terhapus. Tindakan ini tidak dapat dibatalkan.';
            deleteForm.setAttribute('action', deleteUrl);
        });
    }
});
