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
            <input type="text" placeholder="Tìm kiếm theo tên sách hoặc người mượn..." />
            <select>
                <option>Tất cả</option>
                <option>Đang mượn</option>
                <option>Đã trả</option>
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
                <tbody>
                    <tr>
                        <td>Nhà Giả Kim</td>
                        <td>Nguyễn Văn A</td>
                        <td>2024-12-25</td>
                        <td class="overdue">2025-01-25 (Quá hạn)</td>
                        <td>-</td>
                        <td><span class="status status-borrowing">Đang mượn</span></td>
                        <td><button class="btn-return">✔ Trả sách</button></td>
                    </tr>
                    <tr>
                        <td>Đắc Nhân Tâm</td>
                        <td>Nguyễn Văn A</td>
                        <td>2024-12-20</td>
                        <td class="overdue">2025-01-20 (Quá hạn)</td>
                        <td>-</td>
                        <td><span class="status status-borrowing">Đang mượn</span></td>
                        <td><button class="btn-return">✔ Trả sách</button></td>
                    </tr>
                    <tr>
                        <td>Tôi Thấy Hoa Vàng Trên Cỏ Xanh</td>
                        <td>Trần Thị B</td>
                        <td>2024-12-15</td>
                        <td class="overdue">2025-01-15 (Quá hạn)</td>
                        <td>-</td>
                        <td><span class="status status-borrowing">Đang mượn</span></td>
                        <td><button class="btn-return">✔ Trả sách</button></td>
                    </tr>
                    <tr>
                        <td>Đắc Nhân Tâm</td>
                        <td>Trần Thị B</td>
                        <td>2024-11-10</td>
                        <td>2024-12-10</td>
                        <td>2024-12-08</td>
                        <td><span class="status status-returned">Đã trả</span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Nhà Giả Kim</td>
                        <td>Nguyễn Văn A</td>
                        <td>2024-11-01</td>
                        <td>2024-12-01</td>
                        <td>2024-11-28</td>
                        <td><span class="status status-returned">Đã trả</span></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <div class="overlay"></div>

    <div class="modal" style="display:none" >
        <div>
            <div class="modal-header">
                <h3>Record Book Borrowing</h3>
                <span class="close">×</span>
            </div>

            <div class="form-group">
                <label>Select Member *</label>
                <select>
                    <option>-- Select member --</option>
                    <option>Nguyen Van A</option>
                    <option>Tran Thi B</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select Book *</label>
                <select>
                    <option>-- Select book --</option>
                    <option>The Alchemist</option>
                    <option>How to Win Friends & Influence People</option>
                </select>
            </div>

            <div class="form-group">
                <label>Expected Return Date *</label>
                <input type="date">
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

    <script src="/js/admin/loanManagement.js"></script>
</body>


</html>