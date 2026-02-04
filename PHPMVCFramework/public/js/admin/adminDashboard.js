document.addEventListener("DOMContentLoaded", () => {
    console.log("Admin Dashboard loaded");

    highlightStatus();
    formatDates();
});


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



const borrowReturnStats = window.borrowReturnStats || [];
const categoryStats = window.categoryStats || [];


const borrowLabels = borrowReturnStats.map(i => 'T' + i.month);
const borrowedData = borrowReturnStats.map(i => i.borrowed);
const returnedData = borrowReturnStats.map(i => i.returned);

new Chart(document.getElementById('borrowReturnChart'), {
    type: 'bar',
    data: {
        labels: borrowLabels,
        datasets: [
            {
                label: 'Borrowed',
                data: borrowedData,
                backgroundColor: '#3b82f6'
            },
            {
                label: 'Returned',
                data: returnedData,
                backgroundColor: '#10b981'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});


const categoryLabels = categoryStats.map(c => c.CategoryName);
const categoryData = categoryStats.map(c => c.total_books);

new Chart(document.getElementById('categoryChart'), {
    type: 'pie',
    data: {
        labels: categoryLabels,
        datasets: [{
            data: categoryData,
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
