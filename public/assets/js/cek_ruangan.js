// cek_ruangan.js — versi fix: hanya auto-submit filter & tanggal, tanpa real-time search

document.addEventListener('DOMContentLoaded', function () {

    const dateInput = document.getElementById('tanggal-cek');
    const searchInput = document.getElementById('search-ruang');
    const filterForm = document.getElementById('filter-form');
    const searchForm = document.querySelector('.search-form');

    // 1. Auto-submit saat tanggal diubah
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);

        dateInput.addEventListener('change', function () {
            if (this.value < today) {
                alert('Tidak dapat memilih tanggal sebelum hari ini!');
                this.value = today;
            }
            searchForm.submit();
        });
    }

    // 2. Auto-submit saat klik radio filter (lokasi/jenis)
  document.querySelectorAll('#filter-form input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function () {
        // Form akan mengirimkan tanggal terbaru yang tersimpan di hidden input
        document.getElementById('filter-form').submit(); 
    });
});

    // 3. Auto-submit saat tekan Enter di search (bukan real-time)
    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
    }

    // 4. Highlight search term dari URL (tetap jalan)
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('search');
    if (searchTerm) {
        document.querySelectorAll('.room-header h3').forEach(el => {
            const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            el.innerHTML = el.textContent.replace(regex, '<mark style="background:#FFD93D;padding:2px 4px;border-radius:3px;">$1</mark>');
        });
    }

    // 5. Shortcut Ctrl+K fokus search
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput?.focus();
        }
    });
});