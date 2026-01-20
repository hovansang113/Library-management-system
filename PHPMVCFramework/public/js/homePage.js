document.addEventListener("DOMContentLoaded", function () {
  // ảnh đang được hiển thị
  let index = 0;
  // xác định hướng trượt của ảnh
  let direction = 1;
  // Lấy phần tử track và tất cả các slide
  const track = document.querySelector(".slider-track");
  // Lấy tất cả các slide
  const slides = document.querySelectorAll(".slide");
  // giúp slider biết giới hạn cuối cùng để hoạt động đúng và an toàn
  const maxIndex = slides.length - 1;

    // Tự động chuyển slide mỗi 2 giây
    setInterval(() => { index = index + direction;
    // Đụng cuối thì đổi hướng
    if (index === maxIndex || index === 0) {
      direction *= -1;
    }
    // Di chuyển slider bằng CSS transform
    // Mỗi slide chiếm 100% chiều ngang
    // index = 1 → dịch -100%
    // index = 2 → dịch -200%
    track.style.transform = `translateX(-${index * 100}%)`;
  }, 2000);
});

