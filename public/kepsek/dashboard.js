(function() {
    "use strict";
    const colors = ['#667eea','#48bb78','#f56565','#ed8936','#4299e1'];

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    font: { size: 12, weight: '600' },
                    padding: 15,
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: 'rgba(44, 62, 80, 0.95)',
                padding: 12,
                cornerRadius: 8
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
        }
    };

    document.addEventListener("DOMContentLoaded", () => {
        
        const c1 = document.getElementById('trendChart');
        if (c1) {
            const ctx1 = c1.getContext('2d');
            const gradient = ctx1.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
            gradient.addColorStop(1, 'rgba(118, 75, 162, 0.05)');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: JSON.parse(c1.dataset.labels),
                    datasets: [{
                        label: 'Jumlah Pelanggaran',
                        data: JSON.parse(c1.dataset.data),
                        borderColor: colors[0],
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }},
                        x: { grid: { display: false }}
                    }
                }
            });
        }

        const c2 = document.getElementById('kategoriChart');
        if (c2) {
            new Chart(c2, {
                type: 'bar',
                data: {
                    labels: JSON.parse(c2.dataset.labels),
                    datasets: [{
                        label: 'Jumlah',
                        data: JSON.parse(c2.dataset.data),
                        backgroundColor: colors,
                        borderRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }},
                        x: { grid: { display: false }}
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        const c3 = document.getElementById('kelasChart');
        if (c3) {
            new Chart(c3, {
                type: 'bar',
                data: {
                    labels: JSON.parse(c3.dataset.labels),
                    datasets: [{
                        label: 'Jumlah Pelanggaran',
                        data: JSON.parse(c3.dataset.data),
                        backgroundColor: colors[2],
                        borderRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }},
                        y: { grid: { display: false }}
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        const c4 = document.getElementById('statusChart');
        if (c4) {
            new Chart(c4, {
                type: 'doughnut',
                data: {
                    labels: JSON.parse(c4.dataset.labels),
                    datasets: [{
                        data: JSON.parse(c4.dataset.data),
                        backgroundColor: ['#fbbf24', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '60%'
                }
            });
        }

    });
})();
