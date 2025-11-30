// Dark Mode
const theme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', theme);

$(document).ready(function() {
    const table = $('.table').DataTable({
        responsive: true,
        info: false,
        pagingType: 'full_numbers',
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
        order: [[1, 'asc']]
    });

    table.on('draw', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const deleteModal = document.getElementById('deleteModal');
    
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nama = button.getAttribute('data-nama');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            deleteModal.querySelector('.modal-title').textContent = 'Hapus Kategori: ' + nama;
            deleteModal.querySelector('.modal-body-text').textContent = 'Apakah Anda yakin ingin menghapus kategori "' + nama + '"? Tindakan ini tidak dapat dibatalkan.';
            deleteModal.querySelector('#deleteForm').setAttribute('action', deleteUrl);
        });
    }

    const kategoriIndukBaru = document.getElementById('kategori_induk_baru');
    const kategoriIndukSelect = document.getElementById('kategori_induk');
    
    if (kategoriIndukBaru && kategoriIndukSelect) {
        kategoriIndukBaru.addEventListener('input', function() {
            if(this.value) {
                kategoriIndukSelect.value = this.value;
            }
        });
    }
});

