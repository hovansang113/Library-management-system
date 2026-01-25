<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/admin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="dashboard-container">

        <div class="stat-grid">

            <div class="stat-card">
                <div class="stat-info">
                    <p class="title">Total Members</p>
                    <h3><?= $totalUsers ?? 0 ?></h3>
                    <span class="sub-text">Users</span>
                </div>
                <div class="stat-icon blue">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p class="title">Total Books</p>
                    <h3><?= $totalBooks ?? 0 ?></h3>
                    <span class="sub-text">Copies</span>
                </div>
                <div class="stat-icon green">
                    <i class="fa-solid fa-book-open"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p class="title">Borrowed</p>
                    <h3><?= $totalBorrowedCopies ?? 0 ?></h3>
                    <span class="sub-text">Borrowings</span>
                </div>
                <div class="stat-icon orange">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <p class="title">Available books</p>
                    <h3><?= $totalAvailableCopies ?? 0 ?></h3>
                    <span class="sub-text">In stock</span>
                </div>
                <div class="stat-icon purple">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>
        </div><br>

        <div class="dashboard-grid">
            <div class="chart-card">
                <h3>Xu hướng mượn trả sách</h3>
                <canvas id="borrowReturnChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Phân bố thể loại sách</h3>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>


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
                                <td><?= htmlspecialchars($row['Title']) ?></td>
                                <td><?= htmlspecialchars($row['UserName']) ?></td>
                                <td><?= $row['BorrowDate'] ?></td>
                                <td><?= $row['DueDate'] ?></td>
                                <td class="status">
                                    <?= htmlspecialchars($row['Status']) ?>
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

    <script>
        window.borrowReturnStats = <?= json_encode($borrowReturnStats ?? []) ?>;
        window.categoryStats = <?= json_encode($categoryStats ?? []) ?>;
    </script>
    <script src="/js/admin/adminDashboard.js"></script>

</body>

</html>