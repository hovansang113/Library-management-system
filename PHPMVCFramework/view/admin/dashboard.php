<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/admin/dashboard.css">
</head>
<body>

<div class="dashboard-container">

<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-info">
            <p class="title">Total Members</p>
            <h3><?= $stats['members'] ?? 3 ?></h3>
            <span class="sub-text">2 active</span>
        </div>
        <div class="stat-icon blue">
            👥
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <p class="title">Total Books</p>
            <h3><?= $data['total_quantity'] ?? 51 ?></h3>
            <span class="sub-text">5 titles</span>
        </div>
        <div class="stat-icon green">
            📘
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <p class="title">Borrowed</p>
            <h3><?= $stats['borrowed'] ?? 13 ?></h3>
            <span class="sub-text">3 borrowings</span>
        </div>
        <div class="stat-icon orange">
            📙
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <p class="title">Available books</p>
            <h3><?= $stats['available'] ?? 38 ?></h3>
            <span class="sub-text">Available for borrowing</span>
        </div>
        <div class="stat-icon purple">
            ✔
        </div>
    </div>
</div><br>

    <div class="table-card">
        <h3>Recent Borrowings</h3>

        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrower</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($recentBorrowings)): ?>
                    <?php foreach ($recentBorrowings as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['borrower']) ?></td>
                            <td><?= $row['borrowed_date'] ?></td>
                            <td><?= $row['due_date'] ?></td>
                            <td class="status">
                                <?= htmlspecialchars($row['status']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#888;">
                            No borrowing records found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- JS -->
<script src="admindashboard.js"></script>

</body>
</html>
