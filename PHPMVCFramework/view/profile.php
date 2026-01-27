<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/profile.css">
</head>

<body>

    <div class="gapp">
        <div class="section mt-4">
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong><br>
                            <small>Library Member</small>
                        </div>
                        <div class="card-body">
                            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($_SESSION['user_phone']); ?></p>
                            <p>
                                <strong>Status:</strong>
                                <span class="badge bg-success">
                                    <?php echo htmlspecialchars($_SESSION['user_status']); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <strong>Account Information</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($_SESSION['user_register_date']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <strong>Change Password</strong>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/profile/changePassword">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="currentPassword" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="newPassword" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirmNewPassword" class="form-control" required>
                                </div>

                                <button class="btn btn-success">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>