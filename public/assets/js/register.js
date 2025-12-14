// Form elements
const registerForm = document.getElementById('registerForm');
const namaInput = document.getElementById('nama');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirmPassword');
const termsCheckbox = document.getElementById('terms');

// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId === 'password' ? 'togglePasswordIcon' : 'toggleConfirmIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validation Functions
function validateNama() {
    const nama = namaInput.value.trim();
    const error = document.getElementById('namaError');
    
    if (nama === '') {
        showError(namaInput, error, 'Nama lengkap harus diisi');
        return false;
    }
    
    if (nama.length < 3) {
        showError(namaInput, error, 'Nama minimal 3 karakter');
        return false;
    }
    
    if (!/^[a-zA-Z\s]+$/.test(nama)) {
        showError(namaInput, error, 'Nama hanya boleh berisi huruf');
        return false;
    }
    
    hideError(namaInput, error);
    return true;
}

function validateEmail() {
    const email = emailInput.value.trim();
    const error = document.getElementById('emailError');
    
    if (email === '') {
        showError(emailInput, error, 'Email harus diisi');
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError(emailInput, error, 'Format email tidak valid');
        return false;
    }
    
    hideError(emailInput, error);
    return true;
}

function validatePassword() {
    const password = passwordInput.value;
    const error = document.getElementById('passwordError');
    
    if (password === '') {
        showError(passwordInput, error, 'Password harus diisi');
        return false;
    }
    
    if (password.length < 8) {
        showError(passwordInput, error, 'Password minimal 8 karakter');
        return false;
    }
    
    hideError(passwordInput, error);
    return true;
}

function validateConfirmPassword() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const error = document.getElementById('confirmPasswordError');
    
    if (confirmPassword === '') {
        showError(confirmPasswordInput, error, 'Konfirmasi password harus diisi');
        return false;
    }
    
    if (password !== confirmPassword) {
        showError(confirmPasswordInput, error, 'Password tidak cocok');
        return false;
    }
    
    hideError(confirmPasswordInput, error);
    return true;
}

function validateTerms() {
    const error = document.getElementById('termsError');
    
    if (!termsCheckbox.checked) {
        showError(termsCheckbox, error, 'Anda harus menyetujui syarat & ketentuan');
        return false;
    }
    
    hideError(termsCheckbox, error);
    return true;
}

// Show/Hide Error
function showError(input, errorElement, message) {
    input.classList.add('error');
    errorElement.textContent = message;
    errorElement.classList.add('show');
}

function hideError(input, errorElement) {
    input.classList.remove('error');
    errorElement.classList.remove('show');
}

// Real-time Validation
namaInput.addEventListener('blur', validateNama);
emailInput.addEventListener('blur', validateEmail);
passwordInput.addEventListener('blur', validatePassword);
confirmPasswordInput.addEventListener('blur', validateConfirmPassword);
termsCheckbox.addEventListener('change', validateTerms);

// Form Submit
registerForm.addEventListener('submit', function(e) {
    // Validate all fields
    const isNamaValid = validateNama();
    const isEmailValid = validateEmail();
    const isPasswordValid = validatePassword();
    const isConfirmPasswordValid = validateConfirmPassword();
    const isTermsValid = validateTerms();
    
    if (!isNamaValid || !isEmailValid || !isPasswordValid || !isConfirmPasswordValid || !isTermsValid) {
        e.preventDefault();
        
        // Scroll to first error
        const firstError = document.querySelector('.form-input.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('.btn-submit');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
    submitBtn.disabled = true;
    
    // Form will submit normally (no AJAX)
    return true;
});

// Auto-capitalize first letter of name
namaInput.addEventListener('input', function() {
    const words = this.value.split(' ');
    const capitalizedWords = words.map(word => {
        if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word;
    });
    this.value = capitalizedWords.join(' ');
});

// Prevent spaces in email
emailInput.addEventListener('input', function() {
    this.value = this.value.replace(/\s/g, '');
});

// Auto-hide alert messages after 5 seconds
window.addEventListener('load', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.animation = 'slideUp 0.3s ease';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

// Add CSS animation for slideUp
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
`;
document.head.appendChild(style);

// Page load complete
window.addEventListener('load', () => {
    console.log('Register page loaded successfully');
});