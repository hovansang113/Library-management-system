<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/main.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary box">
    <div class="container-fluid line">
      <a href="/"><img src="/img/Logo.png" alt="Logo" class="logo"></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav my-menu">
          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/catalog">Catalog</a></li>
          <li class="nav-item"><a class="nav-link" href="/loans">Loans</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
        </ul>

        <div class="ms-auto">
          <?php if (isset($_SESSION['user_name'])): ?>
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="/Login" class="btn-signin">Sign in</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
    {{content}}
  </div>

  <footer>
    <div class="footer">
        <div>
            <img src="/img/Logo.png" alt="Logo" class="logo-footer">

            <p class="title">Your community connector for learning, discovery, and innovation. Bridging knowledge and technology since 2026, now reimagined for the digital age.</p>
            <div class="icon">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-twitter"></i>
            </div>
        </div>
        <div>
            <div>
                <h3>Quick link</h3>
                <p>Home</p>
                <p>Catelog</p>
                <p>Loans</p>
                <p>Contact</p>
            </div>
        </div>
        <div>
            <div>
                <h3>Visit Us</h3>
                <p class="fontsize">123 Main Street Downtown, NY 10001</p>
                <p class="fontsize">0912102272</p>
                <p class="fontsize">sangsang93939@gmail.com</p>
            </div>
        </div>
        <div>
            <div>
                <h3>Members</h3>
                <p>Ho Van Sang</p>
                <p>Nguyen Tien Nhut</p>
                <p>Y Kim Tram</p>
            </div>
        </div>    
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>