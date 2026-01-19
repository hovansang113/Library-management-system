<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CateLog Browing</title>
    <link rel="stylesheet" href="/css/catalog.css">

</head>

<body>

    <h1 class="catalog">Library Catalog</h1>
    <div class="search-container">
        <h3 class="search-title">Search Books</h3>

        <div class="search-box">
            <div class="input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search for books by title or author..." name ="search" id="input">
            </div>
            <button class="btn-search">Search</button>
        </div>

        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-tag"></i> Category
                </label>
                <select class="filter-select">
                    <option value="">All Categories</option>
                    <option value="science">Science</option>
                    <option value="self-help">Self-help</option>
                    <option value="fiction">Fiction</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-user"></i> Author
                </label>
                <select class="filter-select">
                    <option value="">All Authors</option>
                    <option value="yuval">Yuval Noah Harari</option>
                    <option value="rosie">Rosie Nguyễn</option>
                    <option value="scott">Scott Galloway</option>
                </select>
            </div>
        </div>
    </div>
    <main class="container">
        <h2>New Arrivals</h2>

        <div class="book-grid">


            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <div class="book-image">
                        <img src="<?= $book['Image'] ?>" alt="<?= htmlspecialchars($book['Title']) ?>">
                    </div>

                    <div class="book-content">
                        <div class="book-header">
                            <h2><?= htmlspecialchars($book['Title']) ?></h2>

                            <?php if ($book['AvailableCopies'] > 0): ?>
                                <span class="badge available">Available</span>
                            <?php else: ?>
                                <span class="badge unavailable">Out of stock</span>
                            <?php endif; ?>
                        </div>

                        <div class="book-meta">
                            <span class="author">
                                <i class="fa-solid fa-user"></i>
                                <?= htmlspecialchars($book['Author']) ?>
                            </span>
                        </div>

                        <div class="book-tags">
                            <span class="tag">
                                <i class="fa-solid fa-tag"></i>
                                <?= htmlspecialchars($book['Category']) ?>
                            </span>
                        </div>

                        <div class="book-footer">
                            <span class="status">
                                Status: <?= $book['AvailableCopies'] ?>/<?= $book['Quantity'] ?>
                            </span>

                            <a href="/book/<?= $book['BookID'] ?>" class="btn-detail">
                                View details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>



    </main>
    <div class="pagination">
        <button id="prevBtn">Previous</button>
        <span id="pageInfo"></span>
        <button id="nextBtn">Next</button>
    </div>

    <script src="/js/catalog.js"></script>
</body>

</html>