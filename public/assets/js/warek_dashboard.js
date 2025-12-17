// ============================================================================
// WAREK DASHBOARD - JAVASCRIPT
// ============================================================================

// Navbar Scroll Effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
        } else {
            navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        }
    }
});

// ============================================================================
// MOBILE MENU TOGGLE
// ============================================================================
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

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
        }
    });
}

// ============================================================================
// PROFILE DROPDOWN TOGGLE
// ============================================================================
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

    // Prevent dropdown from closing when clicking inside
    const dropdownMenu = document.getElementById('dropdownMenu');
    if (dropdownMenu) {
        dropdownMenu.addEventListener('click', (e) => {
            // Allow links to work
            if (e.target.tagName !== 'A') {
                e.stopPropagation();
            }
        });
    }
}

// ============================================================================
// SMOOTH SCROLLING
// ============================================================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        }
    });
});

// ============================================================================
// INTERSECTION OBSERVER FOR FADE-IN ANIMATIONS
// ============================================================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// ============================================================================
// INITIALIZE ANIMATIONS ON DOM LOAD
// ============================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Animate cards on scroll
    const animatedElements = document.querySelectorAll(
        '.info-card, .stat-card, .action-card, .history-table-container'
    );

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        fadeObserver.observe(el);
    });

    // Initialize counter animations
    initializeCounterAnimations();

    // Add active state to current page
    setActiveNavLink();
});

// ============================================================================
// COUNTER ANIMATION FOR STATISTICS
// ============================================================================
function animateCounter(element, target, duration = 1500) {
    let current = 0;
    const increment = target / (duration / 16);
    const startTime = performance.now();

    const updateCounter = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        current = Math.floor(target * progress);
        element.textContent = current;

        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    };

    requestAnimationFrame(updateCounter);
}

// Initialize counter animations when visible
function initializeCounterAnimations() {
    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                const number = entry.target.querySelector('.stat-number');
                if (number) {
                    const target = parseInt(number.getAttribute('data-target'));
                    if (!isNaN(target)) {
                        number.textContent = '0';
                        animateCounter(number, target);
                        entry.target.classList.add('animated');
                    }
                }
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-card').forEach(card => {
        statObserver.observe(card);
    });
}

// ============================================================================
// SET ACTIVE NAVIGATION LINK
// ============================================================================
function setActiveNavLink() {
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-link').forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'dashboard.php')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// ============================================================================
// CONFIRM BEFORE LOGOUT
// ============================================================================
document.querySelectorAll('.logout').forEach(link => {
    link.addEventListener('click', (e) => {
        if (!confirm('Apakah Anda yakin ingin keluar?')) {
            e.preventDefault();
        }
    });
});

// ============================================================================
// WELCOME ANIMATION ON PAGE LOAD
// ============================================================================
window.addEventListener('load', () => {
    const welcomeCard = document.querySelector('.welcome-card');
    if (welcomeCard) {
        setTimeout(() => {
            welcomeCard.style.animation = 'fadeInUp 0.8s ease';
        }, 100);
    }
});

// ============================================================================
// TABLE INTERACTIONS
// ============================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Add hover effect to table rows
    const tableRows = document.querySelectorAll('.history-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function () {
            this.style.transform = 'scale(1.005)';
        });

        row.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1)';
        });
    });

    // Tooltip for truncated text
    const truncatedElements = document.querySelectorAll('.keperluan-text, .alasan-text');
    truncatedElements.forEach(el => {
        if (el.scrollWidth > el.clientWidth) {
            el.style.cursor = 'help';
        }
    });
});

// ============================================================================
// NOTIFICATION SYSTEM
// ============================================================================
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;

    // Set icon based on type
    let icon = 'fa-info-circle';
    let bgColor = '#3498db';

    if (type === 'success') {
        icon = 'fa-check-circle';
        bgColor = '#27ae60';
    } else if (type === 'error') {
        icon = 'fa-times-circle';
        bgColor = '#e74c3c';
    } else if (type === 'warning') {
        icon = 'fa-exclamation-triangle';
        bgColor = '#f39c12';
    }

    notification.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-weight: 500;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Example: Show welcome notification on first visit
const isFirstVisit = !sessionStorage.getItem('warek_visited_today');
if (isFirstVisit) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            showNotification('Selamat datang di Dashboard Warek!', 'success');
            sessionStorage.setItem('warek_visited_today', 'true');
        }, 1000);
    });
}

// ============================================================================
// AUTO REFRESH FUNCTIONALITY (Optional - for real-time updates)
// ============================================================================
let autoRefreshInterval = null;

function enableAutoRefresh(intervalMinutes = 5) {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }

    autoRefreshInterval = setInterval(() => {
        console.log('Auto-refreshing statistics...');
        // You can implement AJAX call here to refresh stats without page reload
        // Example: fetchUpdatedStats();
    }, intervalMinutes * 60 * 1000);
}

function disableAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
}

// Optional: Enable auto-refresh (uncomment if needed)
// enableAutoRefresh(5);

// ============================================================================
// PRINT FUNCTIONALITY
// ============================================================================
function printTable() {
    window.print();
}

// ============================================================================
// EXPORT DATA FUNCTIONALITY (Optional)
// ============================================================================
function exportToCSV() {
    const table = document.querySelector('.history-table');
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvRow = [];
        cols.forEach((col, index) => {
            // Skip action column
            if (index < cols.length - 1) {
                csvRow.push('"' + col.textContent.trim().replace(/"/g, '""') + '"');
            }
        });
        csv.push(csvRow.join(','));
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', 'riwayat_konfirmasi_warek.csv');
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ============================================================================
// ADD DYNAMIC CSS ANIMATIONS
// ============================================================================
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
`;
document.head.appendChild(style);

// ============================================================================
// HANDLE PAGE VISIBILITY CHANGE
// ============================================================================
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        console.log('Page is hidden');
    } else {
        console.log('Page is visible');
        // Optional: Refresh data when user returns to tab
    }
});

// ============================================================================
// ERROR HANDLING FOR MISSING ELEMENTS
// ============================================================================
window.addEventListener('error', (e) => {
    console.error('JavaScript Error:', e.message);
}, true);

// ============================================================================
// CONSOLE LOG FOR DEBUGGING
// ============================================================================
console.log('Warek Dashboard JavaScript loaded successfully');
console.log('Current page:', window.location.pathname);
console.log('User session active:', document.querySelector('.welcome-title') ? 'Yes' : 'No');