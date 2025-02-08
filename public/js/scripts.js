// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeFormValidation();
    initializePasswordStrength();
    initializeComplaintId();
    initializeAnimations();
    initializeAlerts();
});

// Form validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            // Remove existing error messages
            form.querySelectorAll('.error-message').forEach(error => error.remove());
            
            requiredFields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                    showError(field);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Real-time validation
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', function() {
                validateField(this);
            });
        });
    });
}

// Field validation
function validateField(field) {
    let isValid = true;
    
    // Remove existing error styling
    field.classList.remove('error');
    
    // Check if empty
    if (field.hasAttribute('required') && !field.value.trim()) {
        isValid = false;
    }
    
    // Email validation
    if (field.type === 'email' && field.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
            isValid = false;
        }
    }
    
    // Phone validation
    if (field.type === 'tel' && field.value) {
        const phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(field.value)) {
            isValid = false;
        }
    }
    
    // Password validation
    if (field.type === 'password' && field.value) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (!passwordRegex.test(field.value)) {
            isValid = false;
        }
    }
    
    // Update field styling
    if (!isValid) {
        field.classList.add('error');
    }
    
    return isValid;
}

// Show error message
function showError(field) {
    const errorMessage = document.createElement('div');
    errorMessage.className = 'error-message';
    errorMessage.textContent = `Please enter a valid ${field.placeholder || field.name}`;
    field.parentNode.appendChild(errorMessage);
}

// Password strength checker
function initializePasswordStrength() {
    const passwordField = document.querySelector('input[type="password"]');
    if (passwordField) {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.className = 'password-strength';
        passwordField.parentNode.appendChild(strengthIndicator);
        
        passwordField.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updateStrengthIndicator(strength, strengthIndicator);
        });
    }
}

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[!@#$%^&*]+/)) strength++;
    
    return strength;
}

function updateStrengthIndicator(strength, indicator) {
    const strengthTexts = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
    const strengthColors = ['#ff0000', '#ff6600', '#ffcc00', '#99cc00', '#009900'];
    
    indicator.textContent = strengthTexts[strength - 1] || '';
    indicator.style.color = strengthColors[strength - 1] || '';
}

// Complaint ID generator
function initializeComplaintId() {
    const complaintIdField = document.getElementById('complaintid');
    if (complaintIdField) {
        const complaintId = 'CID-' + Math.random().toString(36).substr(2, 9).toUpperCase();
        complaintIdField.value = complaintId;
    }
}

// Animations
function initializeAnimations() {
    document.querySelectorAll('.wrapper, .form-container').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.5s ease-out';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 100);
    });
}

// Alert handling
function initializeAlerts() {
    const alerts = document.querySelectorAll('.error, .success');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
}

// AJAX form submission
function submitFormAjax(formElement, successCallback) {
    const formData = new FormData(formElement);
    
    fetch(formElement.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (successCallback) successCallback(data);
        } else {
            showError(data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred. Please try again.');
    });
}

// Utility functions
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

// Export functions for use in other scripts
window.validateForm = initializeFormValidation;
window.submitFormAjax = submitFormAjax; 