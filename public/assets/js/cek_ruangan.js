// cek_ruangan.js — versi bersih tanpa popup

document.addEventListener('DOMContentLoaded', function () {

    // Validasi tanggal (tidak boleh sebelum hari ini)
    const dateInput = document.getElementById('tanggal-cek');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
        dateInput.addEventListener('change', function () {
            if (this.value < today) {
                alert('Tidak dapat memilih tanggal sebelum hari ini!');
                this.value = today;
            }
        });
    }

    // Active navbar
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href').includes(location.pathname.split('/').pop())) {
            link.classList.add('active');
        }
    });

    // Real-time search
    const searchInput = document.getElementById('search-ruang');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            const term = this.value.toLowerCase().trim();
            timeout = setTimeout(() => {
                let visible = 0;
                document.querySelectorAll('.room-card').forEach(card => {
                    const name = card.querySelector('.room-header h3').textContent.toLowerCase();
                    const info = card.querySelector('.room-info').textContent.toLowerCase();
                    if (term === '' || name.includes(term) || info.includes(term)) {
                        card.style.display = '';
                        visible++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                updateNoResults(visible === 0);
            }, 300);
        });
    }

    // Filter lokasi (klik langsung submit)
    document.querySelectorAll('.filter-item').forEach(item => {
        item.addEventListener('click', function () {
            const radio = this.querySelector('input[type="radio"]');
            if (radio && !radio.checked) {
                radio.checked = true;
                this.closest('form').submit();
            }
        });
    });

    // Highlight kata kunci dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('search');
    if (searchTerm) {
        document.querySelectorAll('.room-header h3').forEach(el => {
            const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            el.innerHTML = el.textContent.replace(regex, '<mark style="background:#FFD93D;padding:2px 4px;border-radius:3px;">$1</mark>');
        });
    }

    // Tampilkan pesan "tidak ada hasil"
    function updateNoResults(show) {
        let msg = document.querySelector('.no-results-dynamic');
        if (show && !msg) {
            msg = document.createElement('div');
            msg.className = 'no-data no-results-dynamic';
            msg.innerHTML = `
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <h3>Tidak ada ruangan ditemukan</h3>
                <p>Coba ubah kata kunci atau filter lokasi</p>`;
            document.querySelector('.room-grid').appendChild(msg);
        } else if (!show && msg) {
            msg.remove();
        }
    }

    // Shortcut: Ctrl+K → fokus search, ESC → clear search
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput?.focus();
        }
        if (e.key === 'Escape' && searchInput?.value) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
    });
});