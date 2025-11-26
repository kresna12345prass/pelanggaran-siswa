$(document).ready(function() {
    if ($('#siswaTable').length) {
        $('#siswaTable').DataTable({
            responsive: true,
            info: false,
            paging: false,
            searching: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json'
            },
            columnDefs: [
                { orderable: false, targets: [0] },
                { className: 'text-center', targets: [0, 3, 4] }
            ],
            order: [[3, 'desc']]
        });
    }
});
