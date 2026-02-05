document.addEventListener('DOMContentLoaded', function () {
    const filter = document.getElementById('loanFilter');
    const loansSection = document.getElementById('loans-section');
    const historySection = document.getElementById('history-section');

    function applyFilter() {
        const selectedValue = filter.value;

        if (selectedValue === 'all') {
            loansSection.style.display = 'block';
            historySection.style.display = 'block';
        } else if (selectedValue === 'loans') {
            loansSection.style.display = 'block';
            historySection.style.display = 'none';
        } else if (selectedValue === 'history') {
            loansSection.style.display = 'none';
            historySection.style.display = 'block';
        }
    }

    // Apply filter on change
    filter.addEventListener('change', applyFilter);
});