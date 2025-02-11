<?php 
$title = 'Submit Complaint';
ob_start();
?>

<div class="student-registration">
    <header class="registration-header">
        <h1>Submit Complaint</h1>
        <div class="user-info">
            <span>Welcome, Student</span>
            <a href="/phplogin/logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="registration-form">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/phplogin/complaint/create" method="POST" onsubmit="return validateForm()">
            <div class="form-grid">
                <div class="form-group">
                    <label for="complaintid">Complaint ID</label>
                    <input type="text" id="complaintid" name="complaintid" required readonly>
                </div>

                <div class="form-group">
                    <label for="stuname">Name</label>
                    <input type="text" id="stuname" name="stuname" required>
                </div>

                <div class="form-group">
                    <label for="incdate">Date of Incident</label>
                    <input type="date" id="incdate" name="incdate" required>
                </div>

                <div class="form-group">
                    <label for="placeofinc">Place of Incident</label>
                    <input type="text" id="placeofinc" name="placeofinc" required>
                </div>

                <div class="form-group full-width">
                    <label for="descriptionn">Complaint Description</label>
                    <textarea id="descriptionn" name="descriptionn" rows="5" required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" name="submit">Submit Complaint</button>
            </div>
        </form>
    </div>
</div>

<script>
function validateForm() {
    const requiredFields = ['complaintid', 'stuname', 'incdate', 'placeofinc', 'descriptionn'];
    let isValid = true;

    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('error');
            isValid = false;
        } else {
            element.classList.remove('error');
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields');
        return false;
    }
    return true;
}

function generateComplaintId() {
    const complaintId = 'CID-' + Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
    document.getElementById('complaintid').value = complaintId;
}

window.onload = generateComplaintId;
</script>

<?php 
$content = ob_get_clean();
require_once 'views/layouts/main.php';
?> 