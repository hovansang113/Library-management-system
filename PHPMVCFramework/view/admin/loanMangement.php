<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan</title>
    <link rel="stylesheet" href="/css/admin/loanManagement.css">
</head>

<body>
    <div class="main">
        <div class="top">
            <h2>Book Borrowing Management</h2>
            <button class="btn-primary">+ Record Book Borrowing</button>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Total Borrowings</div>
                <div class="stat-value">5</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Currently Borrowed</div>
                <div class="stat-value orange">3</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Returned</div>
                <div class="stat-value green">2</div>
            </div>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by book title or borrower name..." />
            <select id="statusFilter">
                <option value="">All</option>
                <option value="Borrowed">Borrowed</option>
                <option value="Returned">Returned</option>
            </select>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrower</th>
                        <th>Borrow Date</th>
                        <th>Expected Return Date</th>
                        <th>Actual Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="loanTable">
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?= $loan['Title'] ?></td>
                            <td><?= $loan['UserName'] ?></td>
                            <td><?= $loan['BorrowDate'] ?></td>
                            <td><?= $loan['DueDate'] ?></td>
                            <td><?= $loan['ReturnDate'] ?? 'null' ?></td>
                            <td id="status" class="status" style="color: <?= $loan['Status'] === 'Borrowed' ? 'red' : '#16a34a' ?>; font-weight: bold;">
                                <?= $loan['Status'] ?>
                            </td>
                            <td>
                                <?php if ($loan['Status'] === 'Borrowed'): ?>
                                    <form action="/admin/loan/Return" method="POST" onsubmit="return confirm('Confirm book return?');">
                                        <input type="hidden" name="loan_id" value="<?= $loan['LoanID'] ?>">
                                        <button type="submit" class="return" style="cursor: pointer;">Return</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="overlay"></div>

    <form action="/admin/loan/Store" method="POST">
        <div class="modal" style="display:none">
            <div>
                <div class="modal-header">
                    <h3>Record Book Borrowing</h3>
                    <span class="close">×</span>
                </div>

                <div class="form-group">
                    <label>Select Member *</label>
                    <select name="user_id">
                        <option value="">-- Select member --</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['MemberID'] ?>">
                                <?= htmlspecialchars($member['UserName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Book *</label>
                    <select name="book_id">
                        <option value="">-- Select book --</option>
                        <?php foreach ($books as $book): ?>
                            <option value="<?= $book['BookID'] ?>">
                                <?= htmlspecialchars($book['Title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Expected Return Date *</label>
                    <input type="date" name="expected_return_date" required>
                </div>

                <div class="note">
                    <strong>Note:</strong> After confirmation, the system will automatically
                    change the book status to <b>"Borrowed"</b> and decrease the available quantity.
                </div>

                <div class="actions">
                    <button class="btn-primary">Confirm Borrowing</button>
                    <button class="btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </form>

    <script src="/js/admin/loanManagement.js"></script>
</body>
</html>
