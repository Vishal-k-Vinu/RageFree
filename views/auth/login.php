<?php $title = 'Login'; ?>
<div class="wrapper">
    <form action="/login" method="POST">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="input-box">
            <input type="text" id="uname" name="uname" placeholder="Username" required>
        </div>
        <div class="input-box">
            <input type="password" id="pass" name="pass" placeholder="Password" required>
        </div>
        <div class="input-box">
            <label for="roles">Role:</label>
            <select id="roles" name="roles" required>
                <option value="admin">Admin</option>
                <option value="users">Student</option>
            </select>
        </div>
        <button type="submit" class="btn" name="submit">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="/signup">Sign up</a></p>
        </div>
    </form>
</div> 