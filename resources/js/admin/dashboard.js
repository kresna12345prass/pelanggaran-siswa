import Chart from 'chart.js/auto';

(function() {
    "use strict";
    const colors = ['#667eea','#48bb78','#f56565','#ed8936','#4299e1','#9f7aea','#38b2ac','#dd6b20'];
    const gradients = [
        ['#667eea', '#764ba2'],
        ['#48bb78', '#38ef7d'],
        ['#f56565', '#ff6a88'],
        ['#ed8936', '#ffa94d'],
        ['#4299e1', '#00d4ff'],
        ['#9f7aea', '#c471ed'],
        ['#38b2ac', '#5ce1e6'],
        ['#dd6b20', '#ff9068']
    ];

    const createGradient = (ctx, color1, color2, horizontal = false) => {
        const gradient = horizontal ? 
            ctx.createLinearGradient(0, 0, 400, 0) : 
            ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    font: { size: 12, weight: '600' },
                    padding: 15,
                    usePointStyle: true,
                    boxWidth: 8,
                    boxHeight: 8
                }
            },
            tooltip: {
                backgroundColor: 'rgba(44, 62, 80, 0.95)',
                padding: 12,
                titleFont: { size: 14, weight: 'bold' },
                bodyFont: { size: 13 },
                cornerRadius: 8,
                displayColors: true,
                boxPadding: 6
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
        }
    };

    document.addEventListener("DOMContentLoaded", () => {
        
        // Chart 1: Siswa per Kelas
        const c1 = document.getElementById('siswaPerKelasChart');
        if (c1) {
            const ctx1 = c1.getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: JSON.parse(c1.dataset.labels),
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: JSON.parse(c1.dataset.data),
                        backgroundColor: createGradient(ctx1, gradients[0][0], gradients[0][1]),
                        borderRadius: 8,
                        borderSkipped: false,
                        hoverBackgroundColor: gradients[0][0]
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { font: { size: 11 }}
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 }}
                        }
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        // Chart 2: User per Role
        const c2 = document.getElementById('userRoleChart');
        if (c2) {
            new Chart(c2, {
                type: 'doughnut',
                data: {
                    labels: JSON.parse(c2.dataset.labels),
                    datasets: [{
                        data: JSON.parse(c2.dataset.data),
                        backgroundColor: colors,
                        borderWidth: 4,
                        borderColor: '#fff',
                        hoverOffset: 15,
                        hoverBorderWidth: 5
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '65%',
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                font: { size: 12, weight: '600' }, 
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Chart 3: Top Pelanggaran
        const c3 = document.getElementById('pelanggaranChart');
        if (c3) {
            const ctx3 = c3.getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: JSON.parse(c3.dataset.labels),
                    datasets: [{
                        label: 'Poin',
                        data: JSON.parse(c3.dataset.data),
                        backgroundColor: createGradient(ctx3, gradients[2][0], gradients[2][1], true),
                        borderRadius: 8,
                        borderSkipped: false,
                        hoverBackgroundColor: gradients[2][0]
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    scales: {
                        x: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { font: { size: 11 }}
                        },
                        y: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 }}
                        }
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        // Chart 4: Sanksi Bertahap
        const c4 = document.getElementById('sanksiChart');
        if (c4) {
            new Chart(c4, {
                type: 'pie',
                data: {
                    labels: JSON.parse(c4.dataset.labels),
                    datasets: [{
                        data: JSON.parse(c4.dataset.data),
                        backgroundColor: colors,
                        borderWidth: 4,
                        borderColor: '#fff',
                        hoverOffset: 12,
                        hoverBorderWidth: 5
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                font: { size: 11, weight: '600' }, 
                                padding: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Chart 5: Kelas per Jurusan
        const c5 = document.getElementById('kelasJurusanChart');
        if (c5) {
            new Chart(c5, {
                type: 'polarArea',
                data: {
                    labels: JSON.parse(c5.dataset.labels),
                    datasets: [{
                        data: JSON.parse(c5.dataset.data),
                        backgroundColor: colors.map(c => c + 'CC'),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        r: {
                            ticks: { 
                                backdropColor: 'transparent',
                                font: { size: 11 }
                            },
                            grid: { color: 'rgba(0,0,0,0.1)' },
                            angleLines: { color: 'rgba(0,0,0,0.1)' }
                        }
                    },
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                font: { size: 11, weight: '600' }, 
                                padding: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Chart 6: Tahun Ajaran
        const c6 = document.getElementById('tahunAjaranChart');
        if (c6) {
            const ctx6 = c6.getContext('2d');
            const gradient6 = ctx6.createLinearGradient(0, 0, 0, 300);
            gradient6.addColorStop(0, 'rgba(72, 187, 120, 0.4)');
            gradient6.addColorStop(1, 'rgba(56, 239, 125, 0.05)');
            new Chart(ctx6, {
                type: 'line',
                data: {
                    labels: JSON.parse(c6.dataset.labels),
                    datasets: [{
                        label: 'Status',
                        data: JSON.parse(c6.dataset.data),
                        borderColor: gradients[1][0],
                        backgroundColor: gradient6,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: gradients[1][0],
                        pointBorderWidth: 3,
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { font: { size: 11 }}
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 }}
                        }
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        // Chart 7: Kategori Pelanggaran
        const c7 = document.getElementById('kategoriPelanggaranChart');
        if (c7) {
            new Chart(c7, {
                type: 'radar',
                data: {
                    labels: JSON.parse(c7.dataset.labels),
                    datasets: [{
                        label: 'Jumlah',
                        data: JSON.parse(c7.dataset.data),
                        borderColor: gradients[2][0],
                        backgroundColor: 'rgba(245, 101, 101, 0.2)',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointBackgroundColor: gradients[2][0],
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        r: {
                            ticks: { 
                                backdropColor: 'transparent',
                                font: { size: 11 }
                            },
                            grid: { color: 'rgba(0,0,0,0.1)' },
                            angleLines: { color: 'rgba(0,0,0,0.1)' }
                        }
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

        // Chart 8: Range Poin Sanksi
        const c8 = document.getElementById('rangePoinChart');
        if (c8) {
            const ctx8 = c8.getContext('2d');
            new Chart(ctx8, {
                type: 'bar',
                data: {
                    labels: JSON.parse(c8.dataset.labels),
                    datasets: [{
                        label: 'Poin Maksimal',
                        data: JSON.parse(c8.dataset.data),
                        backgroundColor: createGradient(ctx8, gradients[3][0], gradients[3][1]),
                        borderRadius: 8,
                        borderSkipped: false,
                        hoverBackgroundColor: gradients[3][0]
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { font: { size: 11 }}
                        },
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 11 }}
                        }
                    },
                    plugins: { legend: { display: false }}
                }
            });
        }

    });
})();