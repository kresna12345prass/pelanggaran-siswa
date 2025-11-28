// Dark Mode
const theme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', theme);

document.addEventListener("DOMContentLoaded", () => {
    // Chart 1: Status Verifikasi
    const verifikasiChart = document.getElementById('verifikasiChart');
    if (verifikasiChart) {
        new Chart(verifikasiChart, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Terverifikasi'],
                datasets: [{
                    data: [
                        parseInt(document.querySelector('.stat-number').textContent) || 0,
                        parseInt(document.querySelectorAll('.stat-number')[1].textContent) || 0
                    ],
                    backgroundColor: ['#ed8936', '#48bb78'],
                    borderWidth: 4,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Chart 2: Status Sanksi
    const sanksiChart = document.getElementById('sanksiChart');
    if (sanksiChart) {
        new Chart(sanksiChart, {
            type: 'pie',
            data: {
                labels: ['Berjalan', 'Selesai'],
                datasets: [{
                    data: [
                        parseInt(document.querySelectorAll('.stat-number')[2].textContent) || 0,
                        parseInt(document.querySelectorAll('.stat-number')[3].textContent) || 0
                    ],
                    backgroundColor: ['#f56565', '#4299e1'],
                    borderWidth: 4,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
