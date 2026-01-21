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
            <h2>Quản lý mượn trả sách</h2>
            <button class="btn-primary">+ Ghi nhận mượn sách</button>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Tổng lượt mượn</div>
                <div class="stat-value">5</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Đang mượn</div>
                <div class="stat-value orange">3</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Đã trả</div>
                <div class="stat-value green">2</div>
            </div>
        </div>

        <div class="search-box">
            <input type="text"  id="searchInput" placeholder="Tìm kiếm theo tên sách hoặc người mượn..." />
            <select id="statusFilter">
                <option value="">Tất cả</option>
                <option value="Borrowed">Đang mượn</option>
                <option value="Returned">Đã trả</option>
            </select>
        </div>


        <div class="table-wrapper">
            <table>
                <thead> 
                    <tr>
                        <th>Tên sách</th>
                        <th>Người mượn</th>
                        <th>Ngày mượn</th>
                        <th>Ngày trả dự kiến</th>
                        <th>Ngày trả thực tế</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="loanTable">
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?= $loan['Title'] ?></td>
                            <td><?= $loan['UserName'] ?></td>
                            <td><?= $loan['BorrowDate'] ?></td>
                            <td><?= $loan['DueDate'] ?></td>
                            <td><?= $loan['ReturnDate'] ?? '-' ?></td>
                            <td id="status"><?= $loan['Status'] ?></td>
                            <td><button class="return">Return</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="overlay"></div>

    <form action="/admin/loan/Store" method="POST" >
        <div class="modal" style="display:none" >
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
    </form>
</div>

    <script src="/js/admin/loanManagement.js"></script>
</body>


</html>