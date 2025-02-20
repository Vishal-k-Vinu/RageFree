<?php $title = 'Sign Up'; ?>
<div class="wrapper">
    <form action="/phplogin/signup" method="POST" onsubmit="return validateForm()">
        <h1>Sign up</h1>
        <?php if (isset($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $field => $message): ?>
                    <div class="error"><?php echo htmlspecialchars($message); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="input-box">
            <input type="text" id="fname" name="fname" placeholder="Firstname" required
                   value="<?php echo htmlspecialchars($_POST['fname'] ?? ''); ?>">
            <i class='bx bx-user'></i>
        </div>
        
        <div class="input-box">
            <input type="text" id="lname" name="lname" placeholder="Lastname" required
                   value="<?php echo htmlspecialchars($_POST['lname'] ?? ''); ?>">
            <i class='bx bx-user'></i>
        </div>
        
        <div class="input-box">
            <input type="text" id="uname" name="uname" placeholder="Username" required
                   pattern="[a-zA-Z0-9_]+" minlength="5"
                   value="<?php echo htmlspecialchars($_POST['uname'] ?? ''); ?>">
            <i class='bx bx-user'></i>
            <small>Username must be at least 5 characters and can only contain letters, numbers, and underscores</small>
        </div>
        
        <div class="input-box">
            <input type="email" id="email" name="email" placeholder="Email" required
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            <i class='bx bxs-envelope'></i>
        </div>
        
        <div class="input-box">
            <input type="password" id="pass" name="pass" placeholder="Password" required
                   pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+" 
                   minlength="8">
            <i class='bx bx-lock-alt'></i>
            <small>Password must be at least 8 characters and include uppercase, lowercase, number, and special character</small>
            <div id="password-strength"></div>
        </div>
        
        <div class="input-box">
            <label for="roles">Role:</label>
            <select id="roles" name="roles" required>
                
                <option value="admin" <?php echo (isset($_POST['roles']) && $_POST['roles'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="users" <?php echo (isset($_POST['roles']) && $_POST['roles'] === 'users') ? 'selected' : ''; ?>>Student</option>
            </select>
        </div>
        
        <button type="submit" class="btn" name="submit">Submit</button>
        <div class="register-link">
            <p>Already have an account? <a href="/phplogin/login">Login here</a></p>
        </div>
    </form>
</div>

<style>
.error-messages {
    margin-bottom: 15px;
}

.error {
    color: #dc3545;
    font-size: 0.9em;
    margin-bottom: 5px;
}

.input-box small {
    display: block;
    font-size: 0.8em;
    color: #666;
    margin-top: 5px;
}

#password-strength {
    margin-top: 5px;
    font-size: 0.9em;
}

.input-box.error input {
    border-color: #dc3545;
}
</style>

<script>
function validateForm() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select');
    let isValid = true;

    inputs.forEach(input => {
        input.classList.remove('error');
        const parent = input.closest('.input-box');
        if (parent) {
            parent.classList.remove('error');
        }

        if (!input.checkValidity()) {
            isValid = false;
            if (parent) {
                parent.classList.add('error');
            }
        }
    });

    // Password strength check
    const password = document.getElementById('pass').value;
    if (password) {
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChar = /[@$!%*?&]/.test(password);
        const isLongEnough = password.length >= 8;

        if (!(hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChar && isLongEnough)) {
            isValid = false;
            document.getElementById('pass').closest('.input-box').classList.add('error');
        }
    }

    return isValid;
}

// Password strength indicator
document.getElementById('pass').addEventListener('input', function() {
    const password = this.value;
    const strengthDiv = document.getElementById('password-strength');
    let strength = 0;
    let message = '';

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[@$!%*?&]/.test(password)) strength++;

    switch(strength) {
        case 0:
        case 1:
            message = '<span style="color: #dc3545;">Very Weak</span>';
            break;
        case 2:
            message = '<span style="color: #ffc107;">Weak</span>';
            break;
        case 3:
            message = '<span style="color: #fd7e14;">Moderate</span>';
            break;
        case 4:
            message = '<span style="color: #28a745;">Strong</span>';
            break;
        case 5:
            message = '<span style="color: #20c997;">Very Strong</span>';
            break;
    }

    strengthDiv.innerHTML = 'Password Strength: ' + message;
});
</script> 
