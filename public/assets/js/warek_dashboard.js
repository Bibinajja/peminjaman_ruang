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

    // Prevent dropdown from closing when clicking inside
    const dropdownMenu = document.getElementById('dropdownMenu');
    if (dropdownMenu) {
        dropdownMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
}

// Smooth Scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offsetTop = target.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// Intersection Observer for Fade-in Animations
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

// Observe elements for animation
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll(
        '.info-card, .stat-card, .action-card, .quick-card, .activity-card'
    );

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// Counter Animation for Statistics
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16); // 60fps

    const updateCounter = () => {
        current += increment;
        if (current < target) {
            element.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    };

    updateCounter();
}

// Animate counters when they come into view
const statObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
            const number = entry.target.querySelector('.stat-number');
            if (number) {
                const target = parseInt(number.textContent);
                number.textContent = '0';
                animateCounter(number, target);
                entry.target.classList.add('animated');
            }
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stat-card').forEach(card => {
    statObserver.observe(card);
});

// Add hover effect sound feedback (optional)
document.querySelectorAll('.stat-card, .quick-card, .activity-item').forEach(card => {
    card.addEventListener('mouseenter', function () {
        this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});

// Welcome animation on page load
window.addEventListener('load', () => {
    const welcomeCard = document.querySelector('.welcome-card');
    if (welcomeCard) {
        setTimeout(() => {
            welcomeCard.style.animation = 'fadeInUp 0.8s ease';
        }, 100);
    }
});

// Auto-refresh activity feed (optional - untuk real-time updates)
function refreshActivityFeed() {
    // Implementasi fetch data terbaru dari server
    console.log('Refreshing activity feed...');
    // Contoh: fetch('/api/warek/recent-activities')
    //     .then(response => response.json())
    //     .then(data => updateActivityList(data));
}

// Refresh setiap 5 menit
// setInterval(refreshActivityFeed, 300000);

// Confirm before logout
document.querySelectorAll('.logout').forEach(link => {
    link.addEventListener('click', (e) => {
        if (!confirm('Apakah Anda yakin ingin keluar?')) {
            e.preventDefault();
        }
    });
});

// Add active state to current page in navigation
const currentPage = window.location.pathname.split('/').pop();
document.querySelectorAll('.nav-link').forEach(link => {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage) {
        link.classList.add('active');
    }
});

// Tooltip functionality (optional)
const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
tooltipTriggers.forEach(trigger => {
    trigger.addEventListener('mouseenter', function () {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = this.getAttribute('data-tooltip');
        document.body.appendChild(tooltip);

        const rect = this.getBoundingClientRect();
        tooltip.style.cssText = `
            position: fixed;
            top: ${rect.bottom + 10}px;
            left: ${rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)}px;
            background: #333;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        `;

        this._tooltip = tooltip;
    });

    trigger.addEventListener('mouseleave', function () {
        if (this._tooltip) {
            this._tooltip.remove();
            delete this._tooltip;
        }
    });
});

// Print functionality for reports (optional)
function printReport() {
    window.print();
}

// Export data functionality (optional)
function exportData(format) {
    console.log(`Exporting data in ${format} format...`);
    // Implementasi export ke CSV, PDF, Excel, dll
}

// Search functionality (optional)
const searchInput = document.querySelector('.search-input');
if (searchInput) {
    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        // Implementasi filter/search logic
        console.log('Searching for:', searchTerm);
    });
}

// Notification system (optional)
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Example: Show welcome notification on first visit
const isFirstVisit = !localStorage.getItem('warek_visited');
if (isFirstVisit) {
    setTimeout(() => {
        showNotification('Selamat datang di Dashboard Warek!', 'success');
        localStorage.setItem('warek_visited', 'true');
    }, 1000);
}

// Add CSS animations dynamically
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
`;
document.head.appendChild(style);