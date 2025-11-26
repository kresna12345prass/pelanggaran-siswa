document.addEventListener('DOMContentLoaded', function() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    // Chart Verifikasi
    const verifikasiCtx = document.getElementById('verifikasiChart');
    if (verifikasiCtx && statNumbers.length >= 2) {
        new Chart(verifikasiCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diverifikasi'],
                datasets: [{
                    data: [
                        parseInt(statNumbers[0].textContent) || 0,
                        parseInt(statNumbers[1].textContent) || 0
                    ],
                    backgroundColor: ['#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // Chart Sanksi
    const sanksiCtx = document.getElementById('sanksiChart');
    if (sanksiCtx && statNumbers.length >= 4) {
        new Chart(sanksiCtx, {
            type: 'bar',
            data: {
                labels: ['Berjalan', 'Selesai'],
                datasets: [{
                    label: 'Jumlah Sanksi',
                    data: [
                        parseInt(statNumbers[2].textContent) || 0,
                        parseInt(statNumbers[3].textContent) || 0
                    ],
                    backgroundColor: ['#dc3545', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
