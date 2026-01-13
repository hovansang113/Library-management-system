
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/Login.css">
</head>
<body>
    <div class="login-box"> 
        <h1 class="text-center">Login</h1>
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="/Login" method="POST">
            <div class="mb-4">
                <label class="form-label">Your email:</label>
                <input type="email" name="email" class="form-control" placeholder="Email address" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button class="button" type="submit" >Login</button>
        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
