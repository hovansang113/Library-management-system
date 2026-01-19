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

