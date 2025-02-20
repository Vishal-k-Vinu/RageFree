
<?php 
$title = 'Admin Dashboard'; 
ob_start();
?>

<div class="admin-dashboard">
    <header class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="user-info">
            <span>Welcome, Admin</span>
            <a href="/phplogin/logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Complaints</h3>
            <div class="stat-value"><?php echo $totalComplaints; ?></div>
        </div>
        <!-- Add more stat cards as needed -->
    </div>

    <div class="complaints-list">
        <h2>Recent Complaints</h2>
        <?php if (!empty($complaints)): ?>
            <div class="complaints-table">
                <table>
                    <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Place</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($complaints as $complaint): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($complaint['complaintid']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['stuname']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['incdate']); ?></td>
                                <td><?php echo htmlspecialchars($complaint['placeofinc']); ?></td>
                                <td>
                                    <form action="/phplogin/complaint/view" method="POST">
                                        <input type="hidden" name="complaintid" value="<?php echo htmlspecialchars($complaint['complaintid']); ?>">
                                        <button type="submit" class="view-btn">View Details</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-complaints">No complaints found.</p>
        <?php endif; ?>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once 'views/layouts/main.php';
?> 
