document.addEventListener('DOMContentLoaded', () => {
    const bookCards = document.querySelectorAll('.book-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');

    const itemsPerPage = 8; // 2 dòng × 4 cuốn
    let currentPage = 1;
    const totalPages = Math.ceil(bookCards.length / itemsPerPage);

    function showPage(page) {
        bookCards.forEach((card, index) => {
            card.style.display =
                (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage)
                ? 'flex'
                : 'none';
        });

        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    showPage(currentPage);
});

const searchInput = document.getElementById('input');
let searchTimeout;

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const keyword = this.value.trim();

        if (keyword.length === 0) {
            location.reload();
            return;
        }

        searchTimeout = setTimeout(() => {
            // Gửi request tìm kiếm
            fetch('/user/searchBooks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'keyword=' + encodeURIComponent(keyword)
            })
            .then(response => response.json())
            .then(data => {
                updateBooksTable(data.books);
            })
            .catch(error => console.error('Error:', error));
        }, 300);
    });
}
function updateBooksTable(books) {
    const grid = document.querySelector('.book-grid');
    grid.innerHTML = '';

    if (!books || books.length === 0) {
        grid.innerHTML = '<p>No books found.</p>';
        return;
    }

    books.forEach(book => {
        grid.innerHTML += `
            <div class="book-card">
                <div class="book-image">
                    <img src="${book.Image ?? '/img/default.jpg'}" alt="${book.Title}">
                </div>

                <div class="book-content">
                    <div class="book-header">
                        <h2>${book.Title}</h2>
                        <span class="badge available">Available</span>
                    </div>

                    <div class="book-meta">
                        <span class="author">
                            <i class="fa-solid fa-user"></i>
                            ${book.Author}
                        </span>
                    </div>

                    <div class="book-tags">
                        <span class="tag">
                            <i class="fa-solid fa-tag"></i>
                            ${book.CategoryName ?? 'Unknown'}
                        </span>
                    </div>

                    <div class="book-footer">
                        <a href="/book/${book.BookID}" class="btn-detail">View details</a>
                    </div>
                </div>
            </div>
        `;
    });
}
