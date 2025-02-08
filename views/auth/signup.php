<?php $title = 'Sign Up'; ?>
<div class="wrapper">
    <form action="/signup" method="POST">
        <h1>Sign up</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="input-box">
            <input type="text" id="fname" name="fname" placeholder="Firstname" required>
            <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
            <input type="text" id="lname" name="lname" placeholder="Lastname" required>
            <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
            <input type="text" id="uname" name="uname" placeholder="Username" required>
            <i class='bx bx-user'></i>
        </div>
        <div class="input-box">
            <input type="text" id="email" name="email" placeholder="email" required>
            <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
            <input type="password" id="pass" name="pass" placeholder="Password" required>
            <i class='bx bx-lock-alt'></i>
        </div>
        <div class="input-box">
            <label for="roles">Role:</label>
            <select id="roles" name="roles" required>
                <option value="admin">Admin</option>
                <option value="users">Student</option>
            </select>
        </div>
        <button type="submit" class="btn" name="submit">Submit</button>
        <div class="register-link">
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </form>
</div> 