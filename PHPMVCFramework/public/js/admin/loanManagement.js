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