
<link rel="stylesheet" href="/css/login.css">
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
        <button class="button" name="button" type="submit" >Login</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
