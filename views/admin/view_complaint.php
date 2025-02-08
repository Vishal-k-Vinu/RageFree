<?php $title = 'Complaint Details'; ?>
<div class="container">
    <h1>Complaint Details</h1>

    <?php if ($complaint): ?>
        <div class="complaint-details">
            <span><strong>Complaint-ID:</strong> <?php echo htmlspecialchars($complaint['complaintid']); ?></span>
            <span><strong>Student Name:</strong> <?php echo htmlspecialchars($complaint['stuname']); ?></span>
            <span><strong>Incident Date:</strong> <?php echo htmlspecialchars($complaint['incdate']); ?></span>
            <span><strong>Place of Incident:</strong> <?php echo htmlspecialchars($complaint['placeofinc']); ?></span>
            <span><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($complaint['descriptionn'])); ?></span>
        </div>
    <?php else: ?>
        <p class="error-message">Complaint not found.</p>
    <?php endif; ?>

    <div class="go-back">
        <a href="/admin/dashboard">Go Back to Complaints List</a>
    </div>
</div> 