<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sách</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/bookInventory.css">
</head>

<body>

    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fa-regular fa-folder"></i> Danh mục</h3>
                <button class="btn-icon-add"><i class="fa-solid fa-plus"></i></button>
            </div>

            <div class="category-list">
                <div class="category-card active">
                    <h4 class="space">Kỹ năng sống</h4>
                    <button class="btn-icon-edit"><i class="fa-regular fa-pen-to-square"></i></button>
                    <button class="btn-icon-delete"><i class="fa-regular fa-trash-can"></i></button>
                </div>

            </div>

            <div class="sidebar-footer alert-box">
                <strong>Lưu ý:</strong> Phải tạo danh mục trước khi thêm sách.
            </div>
        </aside>


        <main class="main-content">

            <header class="top-bar">
                <div class="page-title">
                    <i class="fa-solid fa-book-open"></i> Quản lý sách
                </div>

                <div class="actions">
                    <div class="search-box">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" placeholder="Tìm kiếm sách...">
                    </div>
                    <button class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Thêm sách
                    </button>
                </div>
            </header>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dac Nhan Tam</td>
                            <td>Ho Van A</td>
                            <td>Tam Ly</td>
                            <td>The book talk about life</td>
                            <td class="text-green">7</td>
                            <td>Available</td>
                            <td>
                                <button class="btn-icon-edit"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button class="btn-icon-delete"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </main>

    </div>

    <div class="modal-content add-book-form">
        <h2>Add New Book</h2>

        <form id="formAddNewBook" method="POST" enctype="multipart/form-data">
            <div class="form-group full-width">
                <label for="bookName">Name</label>
                <input type="text" id="bookName" name="bookName" placeholder="Đắc Nhân Tâm" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder="Dale Carnegie" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <div class="select-wrapper">
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Education & Knowledge</option>
                            <option value="skills">Kỹ năng sống</option>
                            <option value="novel">Tiểu thuyết</option>
                        </select>
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bookImage">Image</label>
                    <input type="file" id="bookImage" name="bookImage" accept="image/*" required>
                    
                    <div id="imagePreview" style="margin-top: 10px; display: none;">
                        <img id="previewImg" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" placeholder="50" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="This book helps you overcome your fears and inner barriers..." required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-exit" onclick="closeModal()">Exit</button>
            </div>
        </form>
    </div> <br></body>

    <div class="add-category-form">
        <h2>Add New Category</h2>

        <form id="formAddNewCategory" method="POST">
            <div class="form-group full-width">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" placeholder="Kỹ năng sống">
            </div>
         <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-exit" onclick="closeModal()">Exit</button>
            </div>
        </form>

</body>

</html>