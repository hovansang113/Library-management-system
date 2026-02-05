<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Management</title>
    <link rel="stylesheet" href="/css/admin/loanManagement.css">
</head>

<body>
    <div class="main">
        <div class="top">
            <h2>Loan Management</h2>
            <button id="recordLoanBtn" class="btn-primary">+ Record Book Loan</button>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Total Loans</div>
                <div class="stat-value"><?= $totalLoans ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Currently Borrowed</div>
                <div class="stat-value orange"><?= $borrowedCount ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Returned</div>
                <div class="stat-value green"><?= $returnedCount ?? 0 ?></div>
            </div>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by book title or borrower..." />
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
                        <th>Due Date</th>
                        <th>Actual Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="loanTable">
                    <?php if (!empty($loans)): ?>
                        <?php foreach ($loans as $loan): ?>
                            <tr>
                                <td><?= htmlspecialchars($loan['Title']) ?></td>
                                <td><?= htmlspecialchars($loan['UserName']) ?></td>
                                <td><?= htmlspecialchars($loan['BorrowDate']) ?></td>
                                <td><?= htmlspecialchars($loan['DueDate']) ?></td>
                                <td><?= htmlspecialchars($loan['ReturnDate'] ?? 'N/A') ?></td>
                                <td class="status" style="color: <?= $loan['Status'] === 'Borrowed' ? '#f97316' : '#16a34a' ?>; font-weight: bold;">
                                    <?= htmlspecialchars($loan['Status']) ?>
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
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No loan records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="overlay"></div>

    <div class="modal" style="display:none">
        <form action="/admin/loan/Store" method="POST">
            <div>
                <div class="modal-header">
                    <h3>Record Book Borrowing</h3>
                    <span class="close">×</span>
                </div>

                <div class="form-group">
                    <label>Select Member *</label>
                    <select name="user_id" required>
                        <option value="">-- Select member --</option>
                        <?php if (!empty($members)): ?>
                            <?php foreach ($members as $member): ?>
                                <option value="<?= $member['MemberID'] ?>">
                                    <?= htmlspecialchars($member['UserName']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Book *</label>
                    <select name="book_id" required>
                        <option value="">-- Select book --</option>
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $book): ?>
                                <option value="<?= $book['BookID'] ?>">
                                    <?= htmlspecialchars($book['Title']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                    <button type="submit" class="btn-primary">Confirm Borrowing</button>
                    <button type="button" class="btn-secondary" id="cancelModalBtn">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal handling
            const recordLoanBtn = document.getElementById('recordLoanBtn');
            const modal = document.querySelector('.modal');
            const overlay = document.querySelector('.overlay');
            const closeModalBtn = document.querySelector('.modal .close');
            const cancelBtn = document.getElementById('cancelModalBtn');

            function openModal() {
                if (modal && overlay) {
                    modal.style.display = 'block';
                    overlay.style.display = 'block';
                }
            }

            function closeModal() {
                if (modal && overlay) {
                    modal.style.display = 'none';
                    overlay.style.display = 'none';
                }
            }

            if (recordLoanBtn) recordLoanBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
            if (overlay) overlay.addEventListener('click', closeModal);

            // Table filtering
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const loanTableBody = document.getElementById('loanTable');

            if (searchInput && statusFilter && loanTableBody) {
                const tableRows = loanTableBody.getElementsByTagName('tr');

                function filterTable() {
                    const searchText = searchInput.value.toLowerCase();
                    const statusValue = statusFilter.value;
                    let visibleRows = 0;

                    for (let i = 0; i < tableRows.length; i++) {
                        const row = tableRows[i];
                        // Check if it's a data row (has cells)
                        if (row.cells.length > 1) {
                            const bookTitle = row.cells[0].textContent.toLowerCase();
                            const borrower = row.cells[1].textContent.toLowerCase();
                            const status = row.cells[5].textContent.trim();

                            const textMatch = bookTitle.includes(searchText) || borrower.includes(searchText);
                            const statusMatch = (statusValue === '' || status === statusValue);

                            if (textMatch && statusMatch) {
                                row.style.display = '';
                                visibleRows++;
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    }

                    // Handle "No results" message
                    const noResultsRow = document.getElementById('no-results-row');
                    if (visibleRows === 0 && tableRows.length > 0 && tableRows[0].cells.length > 1) {
                        if (!noResultsRow) {
                            const newRow = loanTableBody.insertRow();
                            newRow.id = 'no-results-row';
                            const cell = newRow.insertCell();
                            cell.colSpan = 7;
                            cell.style.textAlign = 'center';
                            cell.textContent = 'No matching records found.';
                        }
                    } else {
                        if (noResultsRow) {
                            noResultsRow.remove();
                        }
                    }
                }

                searchInput.addEventListener('keyup', filterTable);
                statusFilter.addEventListener('change', filterTable);
            }
        });
    </script>
</body>
</html>
