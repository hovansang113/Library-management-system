<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/membermanagement.css">
</head>

<body>

    <div class="app-container">
        <main class="main-content" style="flex: 1;">

            <header class="top-bar">
                <div class="page-title">
                    <i class="fa-solid fa-users"></i> Member Management
                </div>

                <div class="actions">
                    <div class="search-box">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search member...">
                    </div>
                    <button class="btn-primary" onclick="showAddMemberModal()">
                        <i class="fa-solid fa-plus"></i> Add Member
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
                        <tr>
                            <td>1</td>
                            <td>Nguyễn Văn A</td>
                            <td>nguyenvana@gmail.com</td>
                            <td>0901234567</td>
                            <td><span class="status-active">Active</span></td>
                            <td style="text-align: center;">
                                <button class="btn-icon-edit" title="Edit">
                                    <p>bolocked</p>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="overlay" id="overlay" onclick="closeMemberModal()"></div>

    <div class="modal-content add-member-form" id="memberModal" style="display: none;">
        <h2 id="modalTitle">Add New Member</h2>
        <form id="formMember" method="POST" action="/admin/saveMember">
            <input type="hidden" id="memberId" name="id">
            
            <div class="form-group full-width">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="name" placeholder="E.g. Nguyễn Văn A" required>
            </div>

            <div class="form-row" style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="090..." required>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Banned">Banned</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save Member</button>
                <button type="button" class="btn-exit" onclick="closeMemberModal()">Cancel</button>
            </div>
        </form>
    </div>

    
</body>