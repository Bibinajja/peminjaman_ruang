// ===== Typing Animation =====
const typingText = document.getElementById('typingText');
const text = 'MyRoom';
let index = 0;

function typeWriter() {
    if (index < text.length) {
        typingText.textContent += text.charAt(index);
        index++;
        setTimeout(typeWriter, 200);
    }
}

// Start typing animation when page loads
window.addEventListener('load', () => {
    setTimeout(typeWriter, 500);
});

// ===== Sticky Navbar =====
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ===== Mobile Menu Toggle =====
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');

navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});

// Close menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
    });
});

// ===== FAQ Accordion =====
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');
    
    question.addEventListener('click', () => {
        const isActive = item.classList.contains('active');
        
        // Close all items
        faqItems.forEach(otherItem => {
            otherItem.classList.remove('active');
            otherItem.querySelector('.faq-answer').style.maxHeight = null;
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
        }
    });
});

// ===== Team Slider =====
const teamContainer = document.getElementById('teamContainer');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

prevBtn.addEventListener('click', () => {
    teamContainer.scrollBy({
        left: -300,
        behavior: 'smooth'
    });
});

nextBtn.addEventListener('click', () => {
    teamContainer.scrollBy({
        left: 300,
        behavior: 'smooth'
    });
});

// Auto scroll team slider
let autoScrollInterval;

function startAutoScroll() {
    autoScrollInterval = setInterval(() => {
        if (teamContainer.scrollLeft >= teamContainer.scrollWidth - teamContainer.clientWidth) {
            teamContainer.scrollTo({
                left: 0,
                behavior: 'smooth'
            });
        } else {
            teamContainer.scrollBy({
                left: 270,
                behavior: 'smooth'
            });
        }
    }, 3000);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval);
}

// Start auto scroll
startAutoScroll();

// Pause on hover
teamContainer.addEventListener('mouseenter', stopAutoScroll);
teamContainer.addEventListener('mouseleave', startAutoScroll);

// ===== Contact Form WhatsApp Integration =====
const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const name = document.getElementById('contactName').value;
    const email = document.getElementById('contactEmail').value;
    const message = document.getElementById('contactMessage').value;
    
    // Format WhatsApp message
    const whatsappNumber = '6283129313931'; // Nomor dari prompt
    const whatsappMessage = `Nama: ${name}%0AEmail: ${email}%0APesan: ${message}`;
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;
    
    // Open WhatsApp
    window.open(whatsappUrl, '_blank');
    
    // Reset form
    contactForm.reset();
});

// ===== Login Modal Functions =====
function checkLoginStatus() {
    const modal = document.getElementById('loginModal');
    
    // Check if user is logged in (you can modify this logic)
    const isLoggedIn = false; // This should check actual session/login status
    
    if (!isLoggedIn) {
        modal.classList.add('active');
    } else {
        // Redirect to peminjaman page
        window.location.href = 'app/view/peminjam/cek_ketersediaan.php';
    }
}

function closeModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.remove('active');
}

function redirectToLogin() {
    window.location.href = 'login.php';
}

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    const modal = document.getElementById('loginModal');
    if (e.target === modal) {
        closeModal();
    }
});

// ===== Scroll Animations =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// ===== Smooth Scroll for Navigation Links =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offsetTop = target.offsetTop - 70; // Account for navbar height
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// ===== Add Entrance Animations on Scroll =====
window.addEventListener('scroll', () => {
    const fadeElements = document.querySelectorAll('.fade-in');
    
    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;
        
        if (elementTop < window.innerHeight && elementBottom > 0) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
});

// ===== Initialize Fade Animations =====
document.addEventListener('DOMContentLoaded', () => {
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.8s ease';
    });
});