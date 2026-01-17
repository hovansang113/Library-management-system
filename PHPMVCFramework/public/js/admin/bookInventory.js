const btnAddBook = document.querySelector('.btn-primary');
const btnAddCategory = document.querySelector('.btn-icon-add'); 
const addBookForm = document.getElementById('addBookForm');
const addCategoryForm = document.getElementById('addCategoryForm');
const overlay = document.getElementById('overlay');

function closeModal() {
    if (addBookForm) {
        addBookForm.style.display = 'none';
    }

    if (addCategoryForm) {
        addCategoryForm.style.display = 'none';
    }

    if (overlay) {
        overlay.style.display = 'none';
    }
}

function resetBookForm() {
    document.getElementById('formAddNewBook').reset();
    document.getElementById('bookId').value = '';
    document.getElementById('bookFormTitle').textContent = 'Add New Book';
    document.getElementById('bookSubmitBtn').textContent = 'Save';
    document.getElementById('formAddNewBook').action = '/admin/addBook';
    document.getElementById('bookImage').required = true;
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('imageNote').textContent = 'Chọn ảnh cho sách';
    closeModal();
}

if (btnAddBook) {
    btnAddBook.addEventListener('click', () => {
        resetBookForm();
        if (addBookForm) {
            addBookForm.style.display = 'block';
        }

        if (overlay) {
            overlay.style.display = 'block';
        }
    });
}

if (btnAddCategory) {
    btnAddCategory.addEventListener('click', () => {
        resetCategoryForm();

        if (addCategoryForm) {
            addCategoryForm.style.display = 'block';
        }

        if (overlay) {
            overlay.style.display = 'block';
        }
    });
}

if (overlay) {
    overlay.addEventListener('click', closeModal);
}

// Xử lý nút edit sách
const editBookButtons = document.querySelectorAll('.btn-icon-edit[data-id]');
editBookButtons.forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-id');
        const row = this.closest('tr');
        
        // Lấy dữ liệu từ bảng
        const cells = row.querySelectorAll('td');
        const title = cells[1].textContent;
        const author = cells[2].textContent;
        const category = cells[3].textContent;
        const description = cells[4].textContent;
        const quantity = cells[5].textContent;
        
        // Điền vào form
        document.getElementById('bookId').value = bookId;
        document.getElementById('bookName').value = title;
        document.getElementById('author').value = author;
        document.getElementById('quantity').value = quantity;
        document.getElementById('description').value = description;
        
        // Set category
        const categorySelect = document.getElementById('category');
        const categoryOptions = categorySelect.querySelectorAll('option');
        categoryOptions.forEach(option => {
            if (option.textContent === category) {
                option.selected = true;
            }
        });
        
        // Cập nhật form cho mode edit
        document.getElementById('bookFormTitle').textContent = 'Edit Book';
        document.getElementById('bookSubmitBtn').textContent = 'Update';
        document.getElementById('formAddNewBook').action = '/admin/updateBook';
        document.getElementById('bookImage').required = false;
        document.getElementById('imageNote').textContent = 'Bỏ trống nếu không muốn thay đổi ảnh';
        
        // Hiển thị form
        addBookForm.style.display = 'block';
        overlay.style.display = 'block';
    });
});

function editCategory(id, name) {
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    document.getElementById('categoryFormTitle').textContent = 'Edit Category';
    document.getElementById('categorySubmitBtn').textContent = 'Update';
    document.getElementById('formAddNewCategory').action = '/admin/updateCategory';
    document.getElementById('addCategoryForm').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function deleteCategory(id) {
    if (confirm('Bạn có chắc muốn xóa danh mục này?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/deleteCategory';
        form.innerHTML = '<input type="hidden" name="id" value="' + id + '">';
        document.body.appendChild(form);
        form.submit();
    }
}

function resetCategoryForm() {
    document.getElementById('formAddNewCategory').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryFormTitle').textContent = 'Add New Category';
    document.getElementById('categorySubmitBtn').textContent = 'Save';
    document.getElementById('formAddNewCategory').action = '/admin/addCategory';
    document.getElementById('addCategoryForm').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Xử lý tìm kiếm sách
const searchInput = document.getElementById('searchInput');
let searchTimeout;

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const keyword = this.value.trim();

        if (keyword.length === 0) {
            // Nếu rỗng, tải lại trang
            location.reload();
            return;
        }

        searchTimeout = setTimeout(() => {
            // Gửi request tìm kiếm
            fetch('/admin/searchBooks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'keyword=' + encodeURIComponent(keyword)
            })
            .then(response => response.json())
            .then(data => {
                // Cập nhật bảng dữ liệu
                updateBooksTable(data.books);
            })
            .catch(error => console.error('Error:', error));
        }, 300);
    });
}

function updateBooksTable(books) {
    const tbody = document.querySelector('table.data-table tbody');
    
    if (books.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;">Không tìm thấy sách nào</td></tr>';
        return;
    }

    let html = '';
    books.forEach((book, index) => {
        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(book.Title)}</td>
                <td>${escapeHtml(book.Author)}</td>
                <td>${escapeHtml(book.CategoryName)}</td>
                <td>${escapeHtml(book.Description)}</td>
                <td class="text-green">${book.Quantity}</td>
                <td>${book.Status}</td>
                <td>
                    <button class="btn-icon-edit" data-id="${book.BookID}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <button class="btn-icon-delete" data-id="${book.BookID}">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;

    // Re-attach event listeners cho nút edit và delete
    attachEditDeleteListeners();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function attachEditDeleteListeners() {
    const editButtons = document.querySelectorAll('.btn-icon-edit[data-id]');
    const deleteButtons = document.querySelectorAll('.btn-icon-delete[data-id]');

    editButtons.forEach(button => {
        button.removeEventListener('click', handleEditClick);
        button.addEventListener('click', handleEditClick);
    });

    deleteButtons.forEach(button => {
        button.removeEventListener('click', handleDeleteClick);
        button.addEventListener('click', handleDeleteClick);
    });
}

function handleEditClick(event) {
    const bookId = this.getAttribute('data-id');
    const row = this.closest('tr');
    
    // Lấy dữ liệu từ bảng
    const cells = row.querySelectorAll('td');
    const title = cells[1].textContent;
    const author = cells[2].textContent;
    const category = cells[3].textContent;
    const description = cells[4].textContent;
    const quantity = cells[5].textContent;
    
    // Điền vào form
    document.getElementById('bookId').value = bookId;
    document.getElementById('bookName').value = title;
    document.getElementById('author').value = author;
    document.getElementById('quantity').value = quantity;
    document.getElementById('description').value = description;
    
    // Set category
    const categorySelect = document.getElementById('category');
    const categoryOptions = categorySelect.querySelectorAll('option');
    categoryOptions.forEach(option => {
        if (option.textContent === category) {
            option.selected = true;
        }
    });
    
    // Cập nhật form cho mode edit
    document.getElementById('bookFormTitle').textContent = 'Edit Book';
    document.getElementById('bookSubmitBtn').textContent = 'Update';
    document.getElementById('formAddNewBook').action = '/admin/updateBook';
    document.getElementById('bookImage').required = false;
    document.getElementById('imageNote').textContent = 'Bỏ trống nếu không muốn thay đổi ảnh';
    
    // Hiển thị form
    addBookForm.style.display = 'block';
    overlay.style.display = 'block';
}

function handleDeleteClick(event) {
    const bookId = this.getAttribute('data-id');
    
    if (confirm('Bạn có chắc muốn xóa sách này?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/deleteBook';
        form.innerHTML = '<input type="hidden" name="id" value="' + bookId + '">';
        document.body.appendChild(form);
        form.submit();
    }
}

// Gắn event listeners cho nút edit/delete khi trang load
attachEditDeleteListeners();
