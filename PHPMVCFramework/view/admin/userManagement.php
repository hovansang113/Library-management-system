<div class="app-container">
    <main class="main-content" style="flex: 1;">

        <header class="top-bar">
            <div class="page-title">
                <i class="fa-solid fa-users"></i> User Management
            </div>

            <div class="actions">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search user...">
                </div>
                <button class="btn-primary" onclick="showAddUserModal()">
                    <i class="fa-solid fa-plus"></i> Add User
                </button>
            </div>
        </header>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['MemberID']) ?></td>
                                <td><?= htmlspecialchars($user['UserName']) ?></td>
                                <td><?= htmlspecialchars($user['Email']) ?></td>
                                <td><?= htmlspecialchars($user['Phone'] ?? 'N/A') ?></td>
                                <td><span class="status-<?= strtolower($user['Status']) ?>"><?= htmlspecialchars($user['Status']) ?></span></td>
                                <td style="text-align: center;">
                                    <?php if ($user['Status'] === 'Active'): ?>
                                        <form method="POST" action="/admin/user/block" style="display:inline;">
                                            <input type="hidden" name="MemberID" value="<?= $user['MemberID'] ?>">
                                            <button type="submit" class="btn-icon-block" title="Block User">
                                                <i class="fa-solid fa-ban"></i> Block
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="/admin/user/unblock" style="display:inline;">
                                            <input type="hidden" name="MemberID" value="<?= $user['MemberID'] ?>">
                                            <button type="submit" class="btn-icon-unblock" title="Unblock User">
                                                <i class="fa-solid fa-check-circle"></i> Unblock
                                            </button>
                                        </form>
                                    <?php endif; ?>x
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<div class="overlay" id="overlay" onclick="closeUserModal()"></div>

<div class="modal-content add-user-form" id="userModal" style="display: none;">
    <h2 id="modalTitle">Add New User</h2>
    <form id="formUser" method="POST" action="/admin/saveUser">
        <input type="hidden" id="userId" name="id">

        <div class="form-group full-width">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="UserName" placeholder="E.g. Nguyễn Văn A" required>
        </div>


        <div class="form-group" style="flex: 1;">
            <label for="email">Email</label>
            <input type="email" id="email" name="Email" placeholder="example@gmail.com" required>
        </div>
        <div class="form-group" style="flex: 1;">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="Phone" placeholder="090..." required>
        </div>


        <div class="form-group full-width">
            <label for="password">Password</label>
            <input type="password" id="password" name="Password" placeholder="Enter password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save User</button>
            <button type="button" class="btn-exit" onclick="closeUserModal()">Cancel</button>
        </div>
    </form>
</div>

<script src="/js/admin/userManagement.js"></script>