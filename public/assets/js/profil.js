// Get DOM elements
const editBtn = document.getElementById('editBtn');
const saveBtn = document.getElementById('saveBtn');
const cancelBtn = document.getElementById('cancelBtn');
const profileForm = document.getElementById('profileForm');
const formInputs = document.querySelectorAll('.form-input');
const passwordGroup = document.getElementById('passwordGroup');

// Store original values
let originalValues = {};

// Initialize original values
function storeOriginalValues() {
    formInputs.forEach(input => {
        originalValues[input.name] = input.value;
    });
}

// Enable edit mode
function enableEditMode() {
    // Enable all inputs
    formInputs.forEach(input => {
        input.disabled = false;
    });

    // Show password field
    passwordGroup.style.display = 'block';

    // Change button visibility
    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline-block';
    cancelBtn.style.display = 'inline-block';

    // Store original values
    storeOriginalValues();
}

// Disable edit mode
function disableEditMode() {
    // Disable all inputs
    formInputs.forEach(input => {
        input.disabled = true;
    });

    // Hide password field
    passwordGroup.style.display = 'none';

    // Change button visibility
    editBtn.style.display = 'inline-block';
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
}

// Restore original values
function restoreOriginalValues() {
    formInputs.forEach(input => {
        if (originalValues[input.name] !== undefined) {
            input.value = originalValues[input.name];
        }
    });
    // Clear password field
    document.getElementById('password').value = '';
}

// Event Listeners
editBtn.addEventListener('click', function () {
    enableEditMode();
});

cancelBtn.addEventListener('click', function () {
    restoreOriginalValues();
    disableEditMode();
});

// Form validation before submit
profileForm.addEventListener('submit', function (e) {
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();

    if (nama === '') {
        e.preventDefault();
        alert('Nama tidak boleh kosong!');
        return false;
    }

    if (email === '') {
        e.preventDefault();
        alert('Email tidak boleh kosong!');
        return false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid!');
        return false;
    }

    // If validation passes, allow form submission
    return true;
});

// Auto-hide alerts after 5 seconds
window.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';

            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Initialize
document.addEventListener('DOMContentLoaded', function () {
    // Disable all inputs on page load
    disableEditMode();
});