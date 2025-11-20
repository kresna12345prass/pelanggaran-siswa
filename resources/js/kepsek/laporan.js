import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================================================
    // 1. INISIALISASI DATATABLES (UNTUK HALAMAN SHOW)
    // ==================================================
    if ($('#laporanTable').length) {
        const table = $('#laporanTable').DataTable({
            responsive: true,
            info: false,
            searching: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                paginate: {
                    first: '<i class="fa-solid fa-angles-left"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>',
                    next: '<i class="fa-solid fa-angle-right"></i>',
                    last: '<i class="fa-solid fa-angles-right"></i>'
                }
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            columnDefs: [
                { orderable: false, targets: 0 },
                { className: 'text-center', targets: '_all' }
            ]
        });

        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                cell.innerHTML = info.start + i + 1;
            });
        });
    }


    // ==================================================
    // 2. LOGIKA DASHBOARD KEPSEK (EXISTING CODE)
    // ==================================================
    
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    let autoRefreshInterval;
    const autoRefreshToggle = document.getElementById('autoRefreshToggle');
    
    if (autoRefreshToggle) {
        autoRefreshToggle.addEventListener('change', function() {
            if (this.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });
    }
    
    function startAutoRefresh() {
        autoRefreshInterval = setInterval(() => {
            refreshDashboardData();
        }, 300000); 
        showNotification('Auto-refresh diaktifkan (setiap 5 menit)', 'success');
    }
    
    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
        showNotification('Auto-refresh dinonaktifkan', 'info');
    }
    
    window.refreshDashboardData = function() {
        const refreshBtn = document.querySelector('.btn-refresh');
        const refreshIcon = document.querySelector('#refreshIcon');
        
        if (refreshBtn) {
            refreshBtn.disabled = true;
            refreshBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Memuat...';
        }
        
        if (refreshIcon) {
            refreshIcon.classList.add('refresh-btn');
        }
        
        setTimeout(() => {
            location.reload();
        }, 1000);
    };
    
    window.exportData = function(type, format) {
        const exportBtn = document.querySelector(`[onclick="exportData('${type}', '${format}')"]`);
        
        if (exportBtn) {
            exportBtn.disabled = true;
            exportBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mengekspor...';
        }
        
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = `/kepsek/laporan/export?jenis=${type}&format=${format}`;
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        
        setTimeout(() => {
            if (exportBtn) {
                exportBtn.disabled = false;
                exportBtn.innerHTML = `<i class="fa-solid fa-file-${format} me-1"></i>Export ${format.toUpperCase()}`;
            }
        }, 3000);
    };
    
    const filterForm = document.querySelector('form[action*="laporan/show"]');
    if (filterForm) {
        const jenisSelect = filterForm.querySelector('select[name="jenis"]');
        const tanggalMulai = filterForm.querySelector('input[name="tanggal_mulai"]');
        const tanggalSelesai = filterForm.querySelector('input[name="tanggal_selesai"]');
        
        if (jenisSelect) {
            jenisSelect.addEventListener('change', function() {
                updateFilterOptions(this.value);
            });
        }
        
        if (tanggalMulai && tanggalSelesai) {
            tanggalMulai.addEventListener('change', function() {
                tanggalSelesai.min = this.value;
                if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                    tanggalSelesai.value = this.value;
                }
            });
            
            tanggalSelesai.addEventListener('change', function() {
                tanggalMulai.max = this.value;
                if (tanggalMulai.value && tanggalMulai.value > this.value) {
                    tanggalMulai.value = this.value;
                }
            });
        }
    }
    
    function updateFilterOptions(jenisLaporan) {
        const formGroups = document.querySelectorAll('.filter-group');
        if (jenisLaporan === 'rekapitulasi_kelas') {
            formGroups.forEach(group => {
                if (group.classList.contains('date-filter')) {
                    group.style.display = 'none';
                }
            });
        } else {
            formGroups.forEach(group => {
                group.style.display = 'block';
            });
        }
    }
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    window.chartClickHandler = function(event, elements, chart) {
        if (elements.length > 0) {
            const elementIndex = elements[0].index;
            const datasetIndex = elements[0].datasetIndex;
            const value = chart.data.datasets[datasetIndex].data[elementIndex];
            const label = chart.data.labels[elementIndex];
            showNotification(`${label}: ${value} kasus`, 'info');
        }
    };

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            refreshDashboardData();
        }
    });

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses...';
            }
        });
    });
    
    console.log('Laporan Module Initialized');
});