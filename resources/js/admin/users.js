import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function() {
    $('#usersTable').DataTable({
        responsive: true,
        info: false,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Tidak ada data tersedia",
            loadingRecords: "Memuat...",
            processing: "Memproses...",
            paginate: {
                first: '<i class="fa-solid fa-angles-left"></i>',
                previous: '<i class="fa-solid fa-angle-left"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
                last: '<i class="fa-solid fa-angles-right"></i>'
            }
        },
        columnDefs: [
            { orderable: false, targets: [0, 4] },
            { className: 'text-center', targets: [0, 4] }
        ],
        order: [[1, 'asc']],
        drawCallback: function() {
            const api = this.api();
            const pageInfo = api.page.info();
            api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                cell.innerHTML = pageInfo.start + i + 1;
            });
        }
    });
});


// 3. KODE MODAL HAPUS (Tetap sama)
document.addEventListener("DOMContentLoaded", function() {
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userName = button.getAttribute('data-user-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const modalTitle = deleteConfirmModal.querySelector('.modal-title');
            const modalBody = deleteConfirmModal.querySelector('.modal-body-text');
            const deleteForm = deleteConfirmModal.querySelector('#deleteForm');
            
            modalTitle.textContent = 'Hapus Pengguna: ' + userName;
            modalBody.textContent = 'Apakah Anda yakin ingin menghapus pengguna "' + userName + '"? Tindakan ini tidak dapat dibatalkan.';
            deleteForm.setAttribute('action', deleteUrl);
        });
    }
});