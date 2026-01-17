document.addEventListener("DOMContentLoaded", function () {
  let index = 0;
  let direction = 1;
  const track = document.querySelector(".slider-track");
  const slides = document.querySelectorAll(".slide");
  const maxIndex = slides.length - 1;

    setInterval(() => { index = index + direction;
    // Đụng cuối thì đổi hướng
    if (index === maxIndex || index === 0) {
      direction *= -1;
    }
    track.style.transform = `translateX(-${index * 100}%)`;
  }, 2000);
});