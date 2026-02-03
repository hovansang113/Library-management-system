<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Approval</title>
    <link rel="stylesheet" href="/css/admin/requestApproval.css">
</head>
<body>
    <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-error" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
    ?>

    <div class="cards">
        <div class="card">
            <h4>Total Requests</h4>
            <div class="number"><?= $stats['total'] ?? 0 ?></div>
        </div>
        <div class="card">
            <h4>Pending</h4>
            <div class="number"><?= $stats['pending'] ?? 0 ?></div>
        </div>
        <div class="card">
            <h4>Approved</h4>
            <div class="number"><?= $stats['approved'] ?? 0 ?></div>
        </div>
        <div class="card">
            <h4>Rejected</h4>
            <div class="number"><?= $stats['rejected'] ?? 0 ?></div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by book title, author, or member...">
        </div>
        <div class="filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="Pending">
                Pending (<?= $stats['pending'] ?? 0 ?>)
            </button>
            <button class="filter-btn" data-filter="Approved">Approved</button>
            <button class="filter-btn" data-filter="Rejected">Rejected</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Request Date</th>
                <th>Member</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="requestTableBody">
            <?php if (!empty($requests)): ?>
                <?php foreach ($requests as $request): ?>
                    <tr data-status="<?= htmlspecialchars($request['Status']) ?>">
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($request['RequestDate']))) ?></td>
                        <td class="member-name"><?= htmlspecialchars($request['MemberName']) ?></td>
                        <td class="book-title"><?= htmlspecialchars($request['Title']) ?></td>
                        <td class="author"><?= htmlspecialchars($request['Author']) ?></td>
                        <td><?= htmlspecialchars($request['Reason']) ?></td>
                        <td>
                            <span class="status <?= strtolower(htmlspecialchars($request['Status'])) ?>">
                                <?= htmlspecialchars(
                                    $request['Status'] === 'Pending'
                                        ? 'Pending'
                                        : ($request['Status'] === 'Approved'
                                            ? 'Approved'
                                            : 'Rejected')
                                ) ?>
                            </span>
                        </td>
                        <td class="actions">
                            <?php if ($request['Status'] === 'Pending'): ?>
                                <form action="/admin/request/approve" method="POST" style="display: inline;">
                                    <input type="hidden" name="request_id" value="<?= $request['RequestID'] ?>">
                                    <button type="submit" class="btn-approve">✔ Approve</button>
                                </form>
                                <form action="/admin/request/reject" method="POST" style="display: inline;">
                                    <input type="hidden" name="request_id" value="<?= $request['RequestID'] ?>">
                                    <button type="submit" class="btn-reject">✖ Reject</button>
                                </form>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">
                        No requests found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const tableBody = document.getElementById('requestTableBody');
            const rows = tableBody.querySelectorAll('tr');

            function filterAndSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

                rows.forEach(row => {
                    const status = row.dataset.status;
                    const memberName = row.querySelector('.member-name').textContent.toLowerCase();
                    const bookTitle = row.querySelector('.book-title').textContent.toLowerCase();
                    const author = row.querySelector('.author').textContent.toLowerCase();

                    const statusMatch = activeFilter === 'all' || status === activeFilter;
                    const searchMatch =
                        memberName.includes(searchTerm) ||
                        bookTitle.includes(searchTerm) ||
                        author.includes(searchTerm);

                    row.style.display = (statusMatch && searchMatch) ? '' : 'none';
                });
            }

            searchInput.addEventListener('keyup', filterAndSearch);

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filterAndSearch();
                });
            });
        });
    </script>
</body>
</html>
