<?php 
$title = 'Student Registration'; 
ob_start();
?>

<div class="student-registration">
    <header class="registration-header">
        <h1>Student Registration</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Student'); ?></span>
            <a href="/phplogin/logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="registration-form">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/phplogin/student/registration" method="POST" onsubmit="return validateForm()">
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="namee" required 
                           value="<?php echo htmlspecialchars($_POST['namee'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required 
                           pattern="[0-9]{10}" placeholder="10 digits number"
                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                    <small>Format: 10 digits number</small>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required
                           value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>"
                           max="<?php echo date('Y-m-d', strtotime('-16 years')); ?>">
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" required
                           value="<?php echo htmlspecialchars($_POST['department'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="year">Year of Study</label>
                    <select id="year" name="yearr" required>
                        <option value="">Select Year</option>
                        <?php
                        $years = [
                            '1' => '1st Year',
                            '2' => '2nd Year',
                            '3' => '3rd Year',
                            '4' => '4th Year'
                        ];
                        foreach ($years as $value => $label): ?>
                            <option value="<?php echo $value; ?>" 
                                <?php echo (isset($_POST['yearr']) && $_POST['yearr'] === $value) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ktuid">KTU ID</label>
                    <input type="text" id="ktuid" name="ktuid" required pattern="[A-Za-z0-9]+"
                           value="<?php echo htmlspecialchars($_POST['ktuid'] ?? ''); ?>"
                           placeholder="Enter your KTU ID">
                    <small>Only letters and numbers allowed</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" name="submit">Submit Registration</button>
            </div>
        </form>

        <?php if (isset($success)): ?>
            <div class="success-message">
                <p>Registration successful! You will be redirected to the complaint form...</p>
                <p>If you are not redirected, <a href="/phplogin/complaint/create">click here</a>.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function validateForm() {
    const requiredFields = ['name', 'phone', 'gender', 'dob', 'department', 'year', 'ktuid'];
    let isValid = true;
    let errorMessages = [];

    // Clear previous error states
    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.remove('has-error');
    });

    // Validate each field
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.closest('.form-group').classList.add('has-error');
            errorMessages.push(`${field.charAt(0).toUpperCase() + field.slice(1)} is required`);
            isValid = false;
        }
    });

    // Phone number validation
    const phone = document.getElementById('phone');
    if (phone.value && !phone.value.match(/^[0-9]{10}$/)) {
        phone.closest('.form-group').classList.add('has-error');
        errorMessages.push('Phone number must be 10 digits');
        isValid = false;
    }

    // KTU ID validation
    const ktuid = document.getElementById('ktuid');
    if (ktuid.value && !ktuid.value.match(/^[A-Za-z0-9]+$/)) {
        ktuid.closest('.form-group').classList.add('has-error');
        errorMessages.push('KTU ID can only contain letters and numbers');
        isValid = false;
    }

    // Date of birth validation
    const dob = document.getElementById('dob');
    if (dob.value) {
        const age = new Date().getFullYear() - new Date(dob.value).getFullYear();
        if (age < 16) {
            dob.closest('.form-group').classList.add('has-error');
            errorMessages.push('You must be at least 16 years old');
            isValid = false;
        }
    }

    if (!isValid) {
        alert(errorMessages.join('\n'));
    }
    return isValid;
}

// Add error class styling
document.querySelectorAll('.form-group input, .form-group select').forEach(element => {
    element.addEventListener('input', function() {
        this.closest('.form-group').classList.remove('has-error');
    });
});

if (document.querySelector('.success-message')) {
    setTimeout(function() {
        window.location.href = '/phplogin/complaint/create';
    }, 2000);
}
</script>

<style>
.form-group.has-error input,
.form-group.has-error select {
    border-color: #dc3545;
}

.form-group small {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #6c757d;
}

.form-group.has-error small {
    color: #dc3545;
}
</style>

<?php 
$content = ob_get_clean();
require_once 'views/layouts/main.php';
?> 