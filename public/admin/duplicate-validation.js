document.addEventListener('DOMContentLoaded', function() {
    const errorMessages = {
        'nama_jurusan': 'Nama jurusan sudah ada!',
        'kode_jurusan': 'Kode jurusan sudah ada!',
        'nama_prestasi': 'Nama prestasi sudah ada!',
        'nama_kategori': 'Nama kategori sudah ada!',
        'kode_kategori': 'Kode kategori sudah ada!',
        'pasal': 'Pasal sudah ada!',
        'urutan': 'Urutan sudah ada!',
        'nama_sanksi': 'Nama sanksi sudah ada!',
        'nama_pelanggaran': 'Nama pelanggaran sudah ada!',
        'nama_kelas': 'Nama kelas sudah ada!',
        'username': 'Username sudah ada!',
        'email': 'Email sudah ada!',
        'nis': 'NIS sudah ada!',
        'nisn': 'NISN sudah ada!',
        'nip': 'NIP sudah ada!',
        'kode_ajaran': 'Kode ajaran sudah ada!',
        'tahun_ajaran_id': 'Kombinasi tahun ajaran dan kelas/guru sudah ada!',
        'guru_id': 'Guru ini sudah menjadi wali kelas untuk tahun ajaran tersebut!',
        'kelas_id': 'Kelas ini sudah memiliki wali kelas untuk tahun ajaran tersebut!'
    };

    function showBootstrapAlert(message) {
        const existingAlert = document.querySelector('.alert-danger');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        const contentSection = document.querySelector('.mb-4');
        if (contentSection) {
            contentSection.insertAdjacentHTML('afterend', alertHTML);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    const sessionError = document.querySelector('.alert-danger');
    if (sessionError && !sessionError.classList.contains('alert-dismissible')) {
        const errorText = sessionError.textContent.toLowerCase();
        if (errorText.includes('kepala sekolah sudah ada')) {
            showBootstrapAlert('Kepala sekolah sudah ada. Hanya boleh ada satu kepala sekolah.');
            sessionError.remove();
            return;
        }
        if (errorText.includes('kelas') && errorText.includes('wali kelas')) {
            return;
        }
        if (errorText.includes('guru') && errorText.includes('wali kelas')) {
            return;
        }
    }

    document.querySelectorAll('.invalid-feedback, .text-danger').forEach(element => {
        const errorText = element.textContent.toLowerCase();
        if (errorText.includes('has already been taken') || errorText.includes('sudah ada')) {
            const input = element.previousElementSibling || element.parentElement.querySelector('input, select, textarea');
            if (input && errorMessages[input.name]) {
                showBootstrapAlert(errorMessages[input.name]);
                return;
            }
        }
    });
});