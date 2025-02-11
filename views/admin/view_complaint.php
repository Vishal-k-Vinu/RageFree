<?php 
$title = 'View Complaint';
ob_start();
?>

<div class="admin-dashboard">
    <header class="dashboard-header">
        <h1>Complaint Details</h1>
        <div class="user-info">
            <span>Welcome, Admin</span>
            <a href="/phplogin/logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="complaint-details">
        <?php if (isset($complaint)): ?>
            <div class="complaint-card">
                <div class="complaint-header">
                    <h2>Complaint ID: <span class="highlight"><?php echo htmlspecialchars($complaint['complaintid']); ?></span></h2>
                    <div class="complaint-date">
                        <i class='bx bx-calendar'></i>
                        <?php echo htmlspecialchars($complaint['incdate']); ?>
                    </div>
                </div>

                <div class="complaint-grid">
                    <div class="info-group">
                        <label>Student Name</label>
                        <div class="info-value">
                            <i class='bx bx-user'></i>
                            <?php echo htmlspecialchars($complaint['stuname']); ?>
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Place of Incident</label>
                        <div class="info-value">
                            <i class='bx bx-map'></i>
                            <?php echo htmlspecialchars($complaint['placeofinc']); ?>
                        </div>
                    </div>

                    <div class="info-group full-width">
                        <label>Description</label>
                        <div class="info-value description">
                            <i class='bx bx-message-square-detail'></i>
                            <?php echo nl2br(htmlspecialchars($complaint['descriptionn'])); ?>
                        </div>
                    </div>
                </div>

                <div class="complaint-actions">
                    <a href="/phplogin/admin/dashboard" class="back-btn">
                        <i class='bx bx-arrow-back'></i> Back to Dashboard
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="error-message">
                <i class='bx bx-error-circle'></i>
                <p>Complaint not found</p>
                <a href="/phplogin/admin/dashboard" class="back-btn">Back to Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.complaint-details {
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.complaint-card {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.complaint-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

.complaint-header h2 {
    color: #333;
    margin: 0;
    font-size: 1.5rem;
}

.highlight {
    color: #4070f4;
    font-weight: 600;
}

.complaint-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
}

.complaint-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-group.full-width {
    grid-column: 1 / -1;
}

.info-group label {
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    color: #333;
    font-size: 1.1rem;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #eee;
}

.info-value i {
    color: #4070f4;
    font-size: 1.25rem;
    margin-top: 2px;
}

.info-value.description {
    white-space: pre-line;
    line-height: 1.6;
}

.complaint-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 2px solid #eee;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #4070f4;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #2d5bd9;
    transform: translateY(-2px);
}

.back-btn i {
    font-size: 1.25rem;
}

.error-message {
    text-align: center;
    padding: 3rem;
    color: #dc3545;
}

.error-message i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.error-message p {
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .complaint-details {
        padding: 1rem;
    }

    .complaint-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .complaint-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-value {
        font-size: 1rem;
    }
}
</style>

<?php 
$content = ob_get_clean();
require_once 'views/layouts/main.php';
?> 