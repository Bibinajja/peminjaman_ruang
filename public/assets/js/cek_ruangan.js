// cek_ruangan.js

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // 1. VALIDASI TANGGAL
    // ============================================
    const dateInput = document.getElementById('tanggal-cek');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
        
        // Validasi saat tanggal berubah
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const currentDate = new Date(today);
            
            if (selectedDate < currentDate) {
                alert('⚠️ Tidak dapat memilih tanggal sebelum hari ini!');
                this.value = today;
            }
        });
        
        // Prevent manual input tanggal lama
        dateInput.addEventListener('blur', function() {
            if (this.value && this.value < today) {
                this.value = today;
            }
        });
    }
    
    // ============================================
    // 2. ACTIVE LINK NAVBAR
    // ============================================
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split('/').pop();
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
            link.classList.add('active');
        }
        
        link.addEventListener('click', function(e) {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // ============================================
    // 3. REAL-TIME SEARCH (CLIENT-SIDE)
    // ============================================
    const searchInput = document.getElementById('search-ruang');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.toLowerCase().trim();
            
            // Debounce untuk performa lebih baik
            searchTimeout = setTimeout(() => {
                const roomCards = document.querySelectorAll('.room-card');
                let visibleCount = 0;
                
                roomCards.forEach(card => {
                    const roomName = card.querySelector('.room-header h3').textContent.toLowerCase();
                    const roomInfo = card.querySelector('.room-info').textContent.toLowerCase();
                    
                    if (searchTerm === '' || roomName.includes(searchTerm) || roomInfo.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                        
                        // Animasi fade in
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Show/hide no results message
                updateNoResultsMessage(visibleCount);
            }, 300);
        });
    }
    
    // ============================================
    // 4. ANIMATION ROOM CARDS ON LOAD
    // ============================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'all 0.5s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe semua room cards
    const roomCards = document.querySelectorAll('.room-card');
    roomCards.forEach((card, index) => {
        setTimeout(() => {
            observer.observe(card);
        }, index * 50); // Staggered animation
    });
    
    // ============================================
    // 5. KONFIRMASI SEBELUM BOOKING
    // ============================================
    const btnPinjam = document.querySelectorAll('.btn-pinjam');
    btnPinjam.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const roomCard = this.closest('.room-card');
            const roomName = roomCard.querySelector('.room-header h3').textContent;
            const tanggalInput = document.getElementById('tanggal-cek');
            const tanggal = tanggalInput ? tanggalInput.value : '';
            const tanggalFormat = tanggal ? formatTanggalIndonesia(tanggal) : 'Tanggal tidak dipilih';
            
            const confirmMessage = 
                `🏢 Anda akan meminjam ruangan:\n\n` +
                `📍 Ruangan: ${roomName}\n` +
                `📅 Tanggal: ${tanggalFormat}\n\n` +
                `Lanjutkan ke formulir peminjaman?`;
            
            const confirm = window.confirm(confirmMessage);
            
            if (!confirm) {
                e.preventDefault();
            }
        });
    });
    
    // ============================================
    // 6. TOOLTIP UNTUK STATUS RUANGAN
    // ============================================
    const statusElements = document.querySelectorAll('.room-status');
    statusElements.forEach(status => {
        if (status.classList.contains('status-active')) {
            status.setAttribute('title', '✓ Ruangan aktif dan dapat dipinjam');
        } else {
            status.setAttribute('title', '✗ Ruangan tidak tersedia untuk peminjaman');
        }
    });
    
    // ============================================
    // 7. SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ============================================
    // 8. FILTER ANIMATION & LOADING
    // ============================================
    const filterItems = document.querySelectorAll('.filter-item');
    filterItems.forEach(item => {
        item.addEventListener('click', function() {
            const roomGrid = document.querySelector('.room-grid');
            if (roomGrid) {
                // Show loading effect
                roomGrid.style.opacity = '0.5';
                roomGrid.style.pointerEvents = 'none';
                
                // Add loading spinner
                showLoadingSpinner();
                
                // Submit form after animation
                setTimeout(() => {
                    this.querySelector('input[type="radio"]').checked = true;
                    this.closest('form').submit();
                }, 200);
            }
        });
    });
    
    // ============================================
    // 9. HIGHLIGHT SEARCH TERMS
    // ============================================
    function highlightSearchTerm() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('search');
        
        if (searchTerm && searchTerm.trim() !== '') {
            const roomCards = document.querySelectorAll('.room-card');
            roomCards.forEach(card => {
                const roomName = card.querySelector('.room-header h3');
                const originalText = roomName.textContent;
                const regex = new RegExp(`(${escapeRegex(searchTerm)})`, 'gi');
                const highlightedText = originalText.replace(
                    regex, 
                    '<mark style="background: #D4BD7D; padding: 2px 4px; border-radius: 3px; color: #2C3E50;">$1</mark>'
                );
                
                if (originalText !== highlightedText) {
                    roomName.innerHTML = highlightedText;
                }
            });
        }
    }
    
    highlightSearchTerm();
    
    // ============================================
    // 10. KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K untuk fokus ke search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('search-ruang');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // ESC untuk clear search
        if (e.key === 'Escape') {
            const searchInput = document.getElementById('search-ruang');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        }
    });
    
    // ============================================
    // 11. STATUS INFO ANIMATION
    // ============================================
    const statusInfo = document.querySelector('.status-info');
    if (statusInfo) {
        setTimeout(() => {
            statusInfo.style.animation = 'fadeInUp 0.5s ease forwards';
        }, 300);
    }
    
    // ============================================
    // 12. PREVENT DOUBLE CLICK ON SUBMIT
    // ============================================
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-cek');
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Loading...';
            
            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Cek';
            }, 3000);
        });
    }
    
    // ============================================
    // 13. HANDLE BACK BUTTON (RESTORE SCROLL)
    // ============================================
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    
    // Save scroll position before leaving
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('scrollPosition', window.scrollY);
    });
    
    // Restore scroll position on load
    const savedScroll = sessionStorage.getItem('scrollPosition');
    if (savedScroll) {
        window.scrollTo(0, parseInt(savedScroll));
        sessionStorage.removeItem('scrollPosition');
    }
});

// ============================================
// HELPER FUNCTIONS
// ============================================

/**
 * Format tanggal ke Bahasa Indonesia
 */
function formatTanggalIndonesia(dateString) {
    const bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    const date = new Date(dateString);
    const tanggal = date.getDate();
    const namaBulan = bulan[date.getMonth()];
    const tahun = date.getFullYear();
    
    return `${tanggal} ${namaBulan} ${tahun}`;
}

/**
 * Show/Hide no results message
 */
function updateNoResultsMessage(visibleCount) {
    const roomGrid = document.querySelector('.room-grid');
    let noResultsDiv = document.querySelector('.no-results-dynamic');
    
    if (visibleCount === 0) {
        if (!noResultsDiv) {
            noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'no-data no-results-dynamic';
            noResultsDiv.innerHTML = `
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <line x1="11" y1="8" x2="11" y2="14"></line>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
                <h3>Tidak ada hasil yang ditemukan</h3>
                <p>Coba gunakan kata kunci lain atau ubah filter pencarian</p>
            `;
            roomGrid.appendChild(noResultsDiv);
        }
    } else {
        if (noResultsDiv) {
            noResultsDiv.remove();
        }
    }
}

/**
 * Show loading spinner
 */
function showLoadingSpinner() {
    const roomGrid = document.querySelector('.room-grid');
    if (roomGrid && !document.querySelector('.loading-spinner-overlay')) {
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'loading-spinner-overlay';
        loadingDiv.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        
        loadingDiv.innerHTML = `
            <div style="text-align: center;">
                <div style="
                    width: 50px;
                    height: 50px;
                    border: 5px solid #f3f3f3;
                    border-top: 5px solid #4A8FBA;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 1rem;
                "></div>
                <p style="color: #5A6C7D; font-weight: 600;">Memuat data...</p>
            </div>
        `;
        
        document.body.appendChild(loadingDiv);
    }
}

/**
 * Escape regex special characters
 */
function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * Show error message
 */
function showError(message) {
    const roomGrid = document.querySelector('.room-grid');
    if (roomGrid) {
        roomGrid.innerHTML = `
            <div class="error-message" style="
                grid-column: 1 / -1;
                text-align: center;
                padding: 3rem;
                background: white;
                border-radius: 12px;
                border: 2px solid #E74C3C;
            ">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#E74C3C" stroke-width="2" style="margin-bottom: 1rem;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h3 style="color: #E74C3C; margin-bottom: 0.5rem;">Terjadi Kesalahan</h3>
                <p style="color: #5A6C7D;">${message}</p>
            </div>
        `;
    }
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add CSS animation keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .no-results-dynamic {
        animation: fadeInUp 0.5s ease forwards;
    }
`;
document.head.appendChild(style);