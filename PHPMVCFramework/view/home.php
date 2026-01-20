<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Home</title>
    <link rel="stylesheet" href="/css/home.css">

</head>
<body>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-text">
            <h1>Discover Your Next<br>Great Read</h1>
            <p>
                Welcome to Libcon – where knowledge meets innovation.
                Explore thousands of books, digital resources, and community programs
                in our modern library ecosystem.
            </p>
        </div>

        <div class="hero-image">
            <div class="slider">
                <div class="slider-track">
                    <img src="/img/homepage/deep-work.jpg" class="slide active">
                    <img src="/img/homepage/slide1.jpg" class="slide"> 
                    <img src="/img/homepage/slide2.jpg" class="slide"> 
                    <img src="/img/homepage/slide3.jpg" class="slide">
                </div>
            </div>
        </div>
    </section>

    <section class="new-arrivals">
        <h2 class="section-title">New Arrivals</h2>
        <p class="subtitle">Fresh additions to our collection</p>

        <!-- Book list (dữ liệu từ Controller) -->
         <!-- Hiển thị DANH SÁCH SÁCH (Book List) một cách ĐỘNG
        dựa trên dữ liệu $books được Controller truyền sang View -->
        <div class="book-list">
            <!-- Mục đích:
            Lặp qua từng cuốn sách
            Mỗi vòng lặp:
            Sinh ra 1 khối HTML book-card
            $books:
            Là mảng dữ liệu
            Lấy từ Database qua Model
            Được Controller truyền sang View -->
            <?php foreach ($books as $book): ?>
                <!-- 1 CARD = 1 CUỐN SÁCH -->
                <div class="book-card">
                    <div class="book-cover">
                        <img src="<?php echo $book['Image']; ?>" alt="<?php echo $book['Title']; ?>">
                    </div>
                    
                    <div class="book-header">
                        <h3 class="book-title"><?php echo $book['Title']; ?></h3>
                        <span class="status-badge"><?php echo $book['Status']; ?></span>
                    </div>
                    
                    <div class="book-info">
                        <div class="info-item">
                            <i class="fa-regular fa-circle-user"></i>
                            <p><?php echo $book['Author']; ?></p>
                        </div>
                        <div class="info-item category">
                            <i class="fa-solid fa-tags"></i>
                            <p><?php echo $book['Category']; ?></p>
                        </div>
                    </div>

                    <div class="divider"></div>
                    
                    <!-- Book Footer – TÌNH TRẠNG + HÀNH ĐỘNG -->
                    <div class="book-footer">
                        <p class="availability">
                            Status <?= $book['AvailableCopies']; ?> / <?= $book['Quantity']; ?>
                        </p>
                        <!-- Điều hướng tới: /book/5
                        Controller xử lý:BookController@detail(5) -->
                        <!-- View KHÔNG xử lý logic -->
                        <a href="/book/<?= $book['BookID']; ?>" class="btn-details">View details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<!-- Đoạn code này dùng để render danh sách sách động trong View.
Controller truyền dữ liệu $books từ Model, View sử dụng vòng lặp foreach để hiển thị mỗi cuốn sách dưới dạng một book-card. -->
<script src="/js/homePage.js"></script>
</html>
