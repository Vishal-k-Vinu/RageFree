<?php $title = 'Admin Dashboard'; ?>
<header>
    <h1>Admin Complaint Report</h1>
</header>
<div class="container">
    <h1>Complaint List</h1>
    <p>Total Complaints: <?php echo $totalComplaints; ?></p>

    <ul>
        <?php if (!empty($complaints)): ?>
            <?php foreach ($complaints as $complaint): ?>
                <li>
                    <div class="complaint">
                        <span class="complaint-title">Complaint-ID: <?php echo htmlspecialchars($complaint['complaintid']); ?></span>
                        <span class="complaint-details">Student Name: <?php echo htmlspecialchars($complaint['stuname']); ?></span>
                        <span class="complaint-details">Incident Date: <?php echo htmlspecialchars($complaint['incdate']); ?></span>
                        <span class="complaint-details">Place of Incident: <?php echo htmlspecialchars($complaint['placeofinc']); ?></span>
                    </div>
                    <div class="actions">
                        <form method="POST" action="/complaint/view">
                            <input type="hidden" name="complaintid" value="<?php echo htmlspecialchars($complaint['complaintid']); ?>">
                            <button type="submit" class="view">View</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No complaints found</li>
        <?php endif; ?>
    </ul>
</div> 