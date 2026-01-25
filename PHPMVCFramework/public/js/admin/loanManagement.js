const openBtn = document.querySelector('.top .btn-primary');
const modal = document.querySelector('.modal');
const closeBtn = document.querySelector('.close');
const cancelBtn = document.querySelector('.btn-secondary');
const overlay = document.querySelector('.overlay');


openBtn.addEventListener('click', () => {
    modal.style.display = 'block';
    overlay.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
});
cancelBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
});

overlay.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
});

const searchInput = document.getElementById("searchInput");
const statusFilter = document.getElementById("statusFilter");
const rows = document.querySelectorAll("#loanTable tr");

function filterLoans() {
    const keyword = searchInput.value.toLowerCase();
    const status = statusFilter.value;

    rows.forEach(row => {
        const book = row.children[0].textContent.toLowerCase();
        const user = row.children[1].textContent.toLowerCase();
        const rowStatus = row.querySelector("#status").textContent;

        const matchKeyword =
            book.includes(keyword) || user.includes(keyword);

        const matchStatus =
            status === "" || rowStatus === status;

        row.style.display =
            matchKeyword && matchStatus ? "" : "none";
    });
}

searchInput.addEventListener("input", filterLoans);
statusFilter.addEventListener("change", filterLoans);
