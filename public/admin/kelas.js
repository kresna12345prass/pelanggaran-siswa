$(document).ready(function() {
    $('#kelasTable').DataTable({
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
            { orderable: false, targets: [0, 3] },
            { className: 'text-center', targets: [0, 3] }
        ],
        order: [[1, 'asc']],
        drawCallback: function(settings) {
            var api = this.api();
            var startIndex = api.context[0]._iDisplayStart;
            api.column(0, {page:'current'}).nodes().each(function(cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
        }
    });
});


// 3. KODE MODAL HAPUS
document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteKelasModal'); 
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Ganti atribut data-
            const kelasName = button.getAttribute('data-kelas-name'); 
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const modalTitle = deleteConfirmModal.querySelector('.modal-title');
            const modalBody = deleteConfirmModal.querySelector('.modal-body-text');
            const deleteForm = deleteConfirmModal.querySelector('#deleteKelasForm');
            
            modalTitle.textContent = 'Hapus Kelas: ' + kelasName;
            modalBody.textContent = 'Apakah Anda yakin ingin menghapus kelas "' + kelasName + '"? Pastikan tidak ada siswa yang terdaftar di kelas ini. Tindakan ini tidak dapat dibatalkan.';
            deleteForm.setAttribute('action', deleteUrl);
        });
    }
});