// Sample data for demonstration - Replace with actual data from database
const peminjamanData = {
    'PM001': {
        id: 'PM001',
        user: 'Ahmad Fauzi',
        room: 'Ruang Seminar A',
        start: '15 Desember 2024 - 08:00',
        end: '15 Desember 2024 - 12:00',
        purpose: 'Seminar nasional tentang teknologi informasi dan digitalisasi pendidikan tinggi. Acara ini akan dihadiri oleh 150 peserta dari berbagai universitas di Indonesia. Kegiatan meliputi presentasi, diskusi panel, dan networking session.'
    },
    'PM002': {
        id: 'PM002',
        user: 'Siti Nurhaliza',
        room: 'Lab Komputer 1',
        start: '14 Desember 2024 - 13:00',
        end: '14 Desember 2024 - 16:00',
        purpose: 'Praktikum pemrograman web untuk mahasiswa semester 3. Kegiatan mencakup pembelajaran HTML, CSS, dan JavaScript dengan metode hands-on practice. Peserta berjumlah 40 mahasiswa.'
    },
    'PM003': {
        id: 'PM003',
        user: 'Budi Santoso',
        room: 'Aula Utama',
        start: '20 Desember 2024 - 09:00',
        end: '20 Desember 2024 - 15:00',
        purpose: 'Wisuda angkatan 2024 semester genap. Acara akan dihadiri oleh 300 wisudawan, keluarga, dan undangan. Rundown acara meliputi prosesi wisuda, pembacaan ijazah, foto bersama, dan resepsi.'
    },
    'PM004': {
        id: 'PM004',
        user: 'Dewi Lestari',
        room: 'Ruang Rapat B',
        start: '18 Desember 2024 - 10:00',
        end: '18 Desember 2024 - 14:00',
        purpose: 'Rapat koordinasi program kerja tahun 2025 untuk seluruh ketua program studi. Agenda meliputi evaluasi program kerja 2024, perencanaan strategis 2025, dan pembahasan anggaran.'
    }
};

// Current booking ID for modal actions
let currentBookingId = null;

// Navbar Scroll Effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
    } else {
        navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
    }
});

// Mobile Menu Toggle
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
    });

    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
        });
    });
}

// Profile Dropdown Toggle
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.querySelector('.profile-dropdown');

if (profileBtn && profileDropdown) {
    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('active');
        }
    });
}

// Search Functionality
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.peminjaman-card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.5s ease';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// Filter Functionality
const filterBtns = document.querySelectorAll('.filter-btn');
filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        // Remove active class from all buttons
        filterBtns.forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');

        const filter = this.getAttribute('data-filter');
        const cards = document.querySelectorAll('.peminjaman-card');

        cards.forEach(card => {
            const badge = card.querySelector('.badge');
            const badgeClass = badge.className;

            if (filter === 'all') {
                card.style.display = 'block';
            } else if (filter === 'pending' && badgeClass.includes('badge-pending')) {
                card.style.display = 'block';
            } else if (filter === 'urgent' && badgeClass.includes('badge-urgent')) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }

            // Re-trigger animation
            card.style.animation = 'none';
            setTimeout(() => {
                card.style.animation = 'fadeInUp 0.5s ease';
            }, 10);
        });
    });
});

// Show Detail Modal
function showDetail(bookingId) {
    currentBookingId = bookingId;
    const data = peminjamanData[bookingId];

    if (data) {
        document.getElementById('detailID').textContent = data.id;
        document.getElementById('detailUser').textContent = data.user;
        document.getElementById('detailRoom').textContent = data.room;
        document.getElementById('detailStart').textContent = data.start;
        document.getElementById('detailEnd').textContent = data.end;
        document.getElementById('detailPurpose').textContent = data.purpose;

        const modal = document.getElementById('detailModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// Close Modal
function closeModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
    currentBookingId = null;
}

// Close modal when pressing ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Approve Booking
function approveBooking(bookingId) {
    if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
        // Show loading
        showNotification('Memproses persetujuan...', 'info');

        // Simulate API call
        setTimeout(() => {
            // Remove card with animation
            const card = document.querySelector(`[data-id="${bookingId}"]`);
            if (card) {
                card.style.animation = 'fadeOut 0.5s ease';
                setTimeout(() => {
                    card.remove();
                    updateBadgeCount();
                }, 500);
            }

            showNotification('Peminjaman berhasil disetujui!', 'success');

            // In real implementation, send data to server:
            // fetch('/api/warek/approve', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ booking_id: bookingId })
            // });
        }, 1000);
    }
}

// Reject Booking
function rejectBooking(bookingId) {
    const reason = prompt('Masukkan alasan penolakan (opsional):');

    if (reason !== null) { // User didn't cancel
        showNotification('Memproses penolakan...', 'info');

        // Simulate API call
        setTimeout(() => {
            // Remove card with animation
            const card = document.querySelector(`[data-id="${bookingId}"]`);
            if (card) {
                card.style.animation = 'fadeOut 0.5s ease';
                setTimeout(() => {
                    card.remove();
                    updateBadgeCount();
                }, 500);
            }

            showNotification('Peminjaman telah ditolak!', 'error');

            // In real implementation, send data to server:
            // fetch('/api/warek/reject', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ booking_id: bookingId, reason: reason })
            // });
        }, 1000);
    }
}

// Approve from Modal
function approveFromModal() {
    if (currentBookingId) {
        closeModal();
        approveBooking(currentBookingId);
    }
}

// Reject from Modal
function rejectFromModal() {
    if (currentBookingId) {
        closeModal();
        rejectBooking(currentBookingId);
    }
}

// Update Badge Count
function updateBadgeCount() {
    const visibleCards = document.querySelectorAll('.peminjaman-card:not([style*="display: none"])');
    const badgeCount = document.querySelector('.badge-count');
    if (badgeCount) {
        const count = visibleCards.length;
        badgeCount.textContent = `${count} Peminjaman Menunggu`;
    }
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Fade-in Animation on Scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe cards for animation
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.peminjaman-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        card.style.transitionDelay = `${index * 0.1}s`;
        observer.observe(card);
    });
});

// Confirm before logout
document.querySelectorAll('.logout').forEach(link => {
    link.addEventListener('click', (e) => {
        if (!confirm('Apakah Anda yakin ingin keluar?')) {
            e.preventDefault();
        }
    });
});

// Auto-refresh data (optional)
function refreshData() {
    console.log('Refreshing peminjaman data...');
    // In real implementation:
    // fetch('/api/warek/peminjaman')
    //     .then(response => response.json())
    //     .then(data => updateCards(data));
}

// Refresh every 2 minutes
// setInterval(refreshData, 120000);

// Add CSS animations dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-30px);
        }
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Bulk Actions (Optional Enhancement)
function approveAllPending() {
    const pendingCards = document.querySelectorAll('.badge-pending');
    if (pendingCards.length === 0) {
        showNotification('Tidak ada peminjaman yang menunggu persetujuan', 'info');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin menyetujui ${pendingCards.length} peminjaman sekaligus?`)) {
        showNotification('Memproses persetujuan massal...', 'info');
        // Implementation for bulk approval
    }
}

// Export to PDF/Excel (Optional Enhancement)
function exportData(format) {
    showNotification(`Mengekspor data ke ${format.toUpperCase()}...`, 'info');
    // Implementation for data export
}

// Print functionality
function printList() {
    window.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Alt + S for search
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        searchInput.focus();
    }

    // Alt + A for approve all (if needed)
    if (e.altKey && e.key === 'a') {
        e.preventDefault();
        // approveAllPending();
    }
});

// Page load complete
window.addEventListener('load', () => {
    console.log('Halaman Konfirmasi Peminjaman Warek loaded successfully');
    updateBadgeCount();
});