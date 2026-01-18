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
                <h3><i class="fa-regular fa-folder"></i>Category</h3>
                <button class="btn-icon-add"><i class="fa-solid fa-plus"></i></button>
            </div>

            <div class="category-list">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="category-card">
                            <h4 class="space"><?= htmlspecialchars($category['CategoryName']) ?></h4>
                            <button class="btn-icon-edit" type="button" onclick="editCategory(<?= $category['CategoryID'] ?>, '<?= htmlspecialchars($category['CategoryName']) ?>')"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button class="btn-icon-delete" type="button" onclick="deleteCategory(<?= $category['CategoryID'] ?>)"><i class="fa-regular fa-trash-can"></i></button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="padding: 10px; color: #999;">No categories yet.</p>
                <?php endif; ?>
            </div>

            <div class="sidebar-footer alert-box">
                <strong>Note:</strong>You must create a catalog before adding books.
            </div>
        </aside>


        <main class="main-content">

            <header class="top-bar">
                <div class="page-title">
                    <i class="fa-solid fa-book-open"></i>Book management
                </div>

                <div class="actions">
                    <div class="search-box">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Tìm kiếm sách...">
                    </div>
                    <button class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Add Book
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $index => $book): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($book['Title']) ?></td>
                                    <td><?= htmlspecialchars($book['Author']) ?></td>
                                    <td><?= htmlspecialchars($book['CategoryName']) ?></td>
                                    <td><?= htmlspecialchars($book['Description']) ?></td>
                                    <td class="text-green"><?= $book['Quantity'] ?></td>
                                    <td><?= $book['Status'] ?></td>
                                    <td>
                                        <button 
                                            class="btn-icon-edit"
                                            data-id="<?= $book['BookID'] ?>">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>

                                    <form method="post" action="/admin/deleteBook"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa sách này không?');"
                                        style="display:inline;">

                                        <input type="hidden" name="id" value="<?= $book['BookID'] ?>">

                                        <button type="submit" class="btn-icon-delete">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align:center;">No books yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </main>

    </div>

    <div class="modal-content add-book-form" id="addBookForm" style="display: none;">
        <h2 id="bookFormTitle">Add New Book</h2>

        <form id="formAddNewBook" method="POST" action="/admin/addBook" enctype="multipart/form-data">
            <input type="hidden" id="bookId" name="BookID" value="">
            <div class="form-group full-width">
                <label for="bookName">Name</label>
                <input type="text" id="bookName" name="Title" placeholder="Đắc Nhân Tâm" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="Author" placeholder="Dale Carnegie" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <div class="select-wrapper">
                        <select id="category" name="CategoryID" required>
                        <option value="" disabled selected>Chọn danh mục</option>

                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['CategoryID'] ?>">
                                <?= htmlspecialchars($cat['CategoryName']) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bookImage">Image</label>
                    <input type="file" id="bookImage" name="Image" accept="image/*">
                    
                    <div id="imagePreview" style="margin-top: 10px; display: none;">
                        <img id="previewImg" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 5px;">
                    </div>
                    <small id="imageNote" style="color: #999;">Bỏ trống nếu không muốn thay đổi ảnh</small>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="Quantity" placeholder="50" required>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">Description</label>
                <textarea id="description" name="Description" rows="4" placeholder="This book helps you overcome your fears and inner barriers..." required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save" id="bookSubmitBtn">Save</button>
                <button type="button" class="btn-exit" onclick="resetBookForm()">Exit</button>
            </div>
        </form>
    </div> <br>

    <div class="overlay" id="overlay"></div>

    <div class="add-category-form" id="addCategoryForm" style="display: none;">
        <h2 id="categoryFormTitle">Add New Category</h2>

        <form id="formAddNewCategory" method="POST" action="/admin/addCategory">
            <input type="hidden" id="categoryId" name="id" value="">
            <div class="form-group full-width">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="CategoryName" placeholder="Kỹ năng sống" required>
            </div>
         <div class="form-actions">
                <button type="submit" class="btn-save" id="categorySubmitBtn">Save</button>
                <button type="button" class="btn-exit" onclick="resetCategoryForm()">Cancel</button>
            </div>
        </form>
    </div>


    <script src="/js/admin/bookInventory.js"></script>
</body>

</html>