<?php $title = 'Student Registration'; ?>
<div class="form-container">
    <h1>Student Information</h1>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="/student/registration" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="namee" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}">
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <div class="form-group">
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>
        </div>

        <div class="form-group">
            <label for="year">Year:</label>
            <select id="year" name="yearr" required>
                <option value="">Select</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ktuid">KTU ID:</label>
            <input type="text" id="ktuid" name="ktuid" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</div> 