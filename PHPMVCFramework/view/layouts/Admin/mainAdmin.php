<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin/mainAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/userManagement.css">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white custom-navbar">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center">
                <a href=""><img src="/img/Logo.png" alt="Logo" class="logo-img"></a>
                <div class="ms-3 brand-info">
                    <h1 class="brand-title">Library Management System</h1>
                    <p class="brand-subtitle">Hello, Admin</p>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto custom-menu">
                    <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/bookInventory">Book Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/userManagement">User Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/loanManagement">Borrowing and Returning Management</a></li>
                </ul>

                <div class="ms-auto">
                    
                    <a href="/logout" class="logout-link">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                         Log out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        {{content}}
    </div>
</body>
</html>