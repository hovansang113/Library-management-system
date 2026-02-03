<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
    <link href="css/bookRequest.css" rel="stylesheet">
</head>
<body>
        <div class="card">
    <h2>Book request</h2>
    <div class="subtitle">Submit a request for books you would like the library to add.</div>

    <form action="/bookRequest" method="POST">
        <label>Name Book</label>
        <input type="text" name="book_name" placeholder="Enter book title" required>

        <label>Author</label>
        <input type="text" name="author" placeholder="Enter author name" required>

        <label>Reason</label>
        <textarea name="reason" placeholder="Why do you want this book?" required></textarea>

        <button type="submit" class="btn">Send request</button>
    </form>
</div>

<div>
    <h3>Your request</h3>

    <?php if (empty($requests)): ?>
        <p>You have not made any book requests.</p>
    <?php else: ?>
        <?php foreach ($requests as $request): ?>
            <div class="request-card">
                <div class="request-title"><?= htmlspecialchars($request['Title']) ?></div>
                <div class="request-info">
                    Author: <?= htmlspecialchars($request['Author']) ?><br>
                    Reason: <?= htmlspecialchars($request['Reason']) ?><br>
                    Date sent: <?= date('Y-m-d', strtotime($request['RequestDate'])) ?>
                </div>
                <button class="status-btn"><?= htmlspecialchars($request['Status']) ?></button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>