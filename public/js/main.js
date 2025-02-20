
// Form validation and AJAX handling
document.addEventListener('DOMContentLoaded', function() {
    // Complaint ID generation
    if (document.getElementById('complaintid')) {
        generateComplaintId();
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // Password strength indicator
    const passwordInput = document.getElementById('pass');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthIndicator(strength);
        });
    }
});

function generateComplaintId() {
    const complaintId = 'CID-' + Math.floor(Math.random() * 1000000);
    document.getElementById('complaintid').value = complaintId;
}

function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    return strength;
}

function updatePasswordStrengthIndicator(strength) {
    const indicator = document.getElementById('password-strength');
    if (!indicator) return;

    const strengthTexts = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
    const strengthColors = ['#ff0000', '#ff6600', '#ffcc00', '#99cc00', '#009900'];

    indicator.textContent = strengthTexts[strength - 1];
    indicator.style.color = strengthColors[strength - 1];
} 
