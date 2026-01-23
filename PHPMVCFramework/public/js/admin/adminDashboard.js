document.addEventListener("DOMContentLoaded", () => {
    console.log("Admin Dashboard loaded");

    highlightStatus();
    formatDates();
});

/**
 * Tô màu trạng thái mượn sách
 * (có thể mở rộng cho Overdue / Returned sau này)
 */
function highlightStatus() {
    const statusCells = document.querySelectorAll(".status");

    statusCells.forEach(cell => {
        const text = cell.textContent.trim().toLowerCase();

        if (text.includes("đang")) {
            cell.classList.add("borrowing");
        } else if (text.includes("quá")) {
            cell.classList.add("overdue");
        } else if (text.includes("trả")) {
            cell.classList.add("returned");
        }
    });
}

/**
 * Format ngày tháng cho đẹp hơn (YYYY-MM-DD → DD/MM/YYYY)
 */
function formatDates() {
    const dateCells = document.querySelectorAll(
        "tbody td:nth-child(3), tbody td:nth-child(4)"
    );

    dateCells.forEach(cell => {
        const date = cell.textContent.trim();
        if (date.includes("-")) {
            const [year, month, day] = date.split("-");
            cell.textContent = `${day}/${month}/${year}`;
        }
    });
}