const btnAddBook = document.querySelector('.btn-primary');
const btnAddCategory = document.querySelector('.btn-icon-add'); 
const addBookForm = document.getElementById('addBookForm');
const addCategoryForm = document.getElementById('addCategoryForm');
const overlay = document.getElementById('overlay');

function closeModal() {
    if (addBookForm) addBookForm.style.display = 'none';
    if (addCategoryForm) addCategoryForm.style.display = 'none';
    if (overlay) overlay.style.display = 'none';
}

if (btnAddBook) {
    btnAddBook.addEventListener('click', () => {
        if (addBookForm) addBookForm.style.display = 'block';
        if (overlay) overlay.style.display = 'block';
    });
}

if (btnAddCategory) {
    btnAddCategory.addEventListener('click', () => {
        resetCategoryForm();
        if (addCategoryForm) addCategoryForm.style.display = 'block';
        if (overlay) overlay.style.display = 'block';
    });
}

if (overlay) {
    overlay.addEventListener('click', closeModal);
}
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

