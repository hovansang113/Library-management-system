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

        <div class="book-list">
            <?php foreach ($books as $book): ?>
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
                    
                    <div class="book-footer">
                        <p class="availability">
                            Status <?= $book['AvailableCopies']; ?> / <?= $book['Quantity']; ?>
                        </p>
                        <a href="/book/<?= $book['BookID']; ?>" class="btn-details">View details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<script src="/js/homePage.js"></script>
</html>
