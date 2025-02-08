<?php $title = 'Complaint Registration'; ?>
<div class="container">
    <h1>Complaint Registration</h1>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="/complaint/create" method="POST">
        <label for="complaintid">Complaint ID</label>
        <input type="text" id="complaintid" name="complaintid" required readonly>

        <label for="name">Name</label>
        <input type="text" id="stuname" name="stuname" required>

        <label for="date">Date of Incident</label>
        <input type="date" id="incdate" name="incdate" required>

        <label for="place">Place of Incident</label>
        <input type="text" id="placeofinc" name="placeofinc" required>

        <label for="descriptionn">Complaint Description</label>
        <textarea id="descriptionn" name="descriptionn" rows="7" required></textarea>

        <input type="submit" value="Submit" name="submit" class="submit-btn">
    </form>
</div>

<script>
function generateComplaintId() {
    const complaintId = 'CID-' + Math.floor(Math.random() * 1000000);
    document.getElementById("complaintid").value = complaintId;
}
window.onload = generateComplaintId;
</script> 