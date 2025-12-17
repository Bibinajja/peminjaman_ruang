// Current booking ID for modal actions
let currentBookingId = null;

// Convert PHP data to proper format
const peminjamanDataMap = {};
if (typeof peminjamanData !== 'undefined') {
    peminjamanData.forEach(item => {
        peminjamanDataMap[item.peminjaman_id] = {
            id: item.peminjaman_id,
            user: item.nama_peminjam,
            email: item.email_peminjam,
            room: item.nama_ruang,
            location: item.lokasi || '-',
            capacity: item.kapasitas + ' orang',
            start: new Date(item.tanggal_mulai).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }),
            end: new Date(item.tanggal_selesai).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }),
            purpose: item.keperluan || 'Tidak ada keterangan'
        };
    });
}

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

        updateBadgeCount();
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

        updateBadgeCount();
    });
});

// Show Detail Modal
function showDetail(bookingId) {
    currentBookingId = bookingId;
    const data = peminjamanDataMap[bookingId];

    if (data) {
        document.getElementById('detailID').textContent = 'PM' + String(data.id).padStart(3, '0');
        document.getElementById('detailUser').textContent = data.user;
        document.getElementById('detailEmail').textContent = data.email;
        document.getElementById('detailRoom').textContent = data.room;
        document.getElementById('detailLocation').textContent = data.location;
        document.getElementById('detailCapacity').textContent = data.capacity;
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
async function approveBooking(bookingId) {
    if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
        // Show loading
        showNotification('Memproses persetujuan...', 'info');

        try {
            const response = await fetch('proses_konfirmasi_warek.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    peminjaman_id: bookingId,
                    action: 'approve'
                })
            });

            const result = await response.json();

            if (result.success) {
                // Remove card with animation
                const card = document.querySelector(`[data-id="${bookingId}"]`);
                if (card) {
                    card.style.animation = 'fadeOut 0.5s ease';
                    setTimeout(() => {
                        card.remove();
                        updateBadgeCount();

                        // Check if no more cards
                        const remainingCards = document.querySelectorAll('.peminjaman-card');
                        if (remainingCards.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 500);
                }

                showNotification(result.message || 'Peminjaman berhasil disetujui!', 'success');
            } else {
                showNotification(result.message || 'Gagal menyetujui peminjaman', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat memproses persetujuan', 'error');
        }
    }
}

// Approve from Modal
function approveFromModal() {
    if (currentBookingId) {
        closeModal();
        approveBooking(currentBookingId);
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
        max-width: 400px;
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

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Alt + S for search
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        searchInput.focus();
    }
});

// Page load complete
window.addEventListener('load', () => {
    console.log('Halaman Konfirmasi Peminjaman Warek loaded successfully');
    updateBadgeCount();
});