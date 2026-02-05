<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loans</title>
    <link rel="stylesheet" href="/css/loans.css">
</head>

<body>
    <div class="loana">

        <div class="top-bar">
            <h1> My loans</h1>
            <select class="dropdown" id="loanFilter">
                <option value="all">All</option>
                <option value="loans">Current Loans</option>
                <option value="history">History</option>
            </select>
        </div>

        <div class="section" id="loans-section">
            <h3>Current Loans</h2>
            <div class="card">
                <table class="loan-data-table">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>BorrowDate</th>
                            <th>DateDue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($currentLoans)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Bạn chưa mượn cuốn sách nào.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($currentLoans as $loan): ?>
                                <tr>
                                    <td><?= htmlspecialchars($loan['Title']) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($loan['BorrowDate']))) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($loan['DueDate']))) ?></td>
                                    <td>
                                        <span class="status <?= strtolower(htmlspecialchars($loan['Status'])) ?>"><?= htmlspecialchars($loan['Status']) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section" id="history-section">
            <h3>History</h2>

            <div class="card">
                <table class="loan-data-table">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>BorrowDate</th>
                            <th>DateDue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($loanHistory)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Lịch sử mượn sách của bạn trống.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($loanHistory as $loan): ?>
                                <tr>
                                    <td><?= htmlspecialchars($loan['Title']) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($loan['BorrowDate']))) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($loan['DueDate']))) ?></td>
                                    <td>
                                        <span class="status <?= strtolower(htmlspecialchars($loan['Status'])) ?>"><?= htmlspecialchars($loan['Status']) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="/js/loans.js"></script>
</body>

</html>