<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['Title']) ?></title>
    <link rel="stylesheet" href="/css/bookDetail.css">
</head>

<body>

    <div class="abc">
        <div class="book-image">
            <img
                src="<?= $book['Image'] ?>"
                alt="<?= htmlspecialchars($book['Title']) ?> Book Cover">
        </div>

        <div class="book-info">
            <h1 class="book-title">
                <?= htmlspecialchars($book['Title']) ?>
            </h1>

            <div class="metadata-grid">
                <div class="metadata-item">
                    <span class="label">Author</span>
                    <p class="value">
                        <?= htmlspecialchars($book['Author']) ?>
                    </p>
                </div>

                <div class="metadata-item">
                    <span class="label">Categories</span>
                    <p class="value category-tag">
                        <?= htmlspecialchars($book['Category']) ?>
                    </p>
                </div>

                <div class="metadata-item">
                    <span class="label">Released</span>
                    <p class="value">
                        <?= $book['CreatedAt'] ?? 'N/A' ?>
                    </p>
                </div>
            </div>

            <div class="description">
                <p>
                    <?= nl2br(htmlspecialchars($book['Description'])) ?>
                </p>
            </div>
        </div>
    </div>


</body>

</html>