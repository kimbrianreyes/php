<?php
session_start();
include 'db_connection.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation
    if (empty($email) || empty($password)) {
        $login_error = "Both fields are required.";
    } else {
        // Check if email exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: portfolio.php");
                exit();
            } else {
                $login_error = "Incorrect password.";
            }
        } else {
            $login_error = "Email not found.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    body {
        background: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .form-container {
        max-width: 400px;
        margin: 0 auto;
    }

    .card-header {
        background-color: #343a40;
        color: white;
        text-align: center;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .alert {
        font-size: 0.875rem;
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="form-container">
            <div class="card shadow-sm">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                    </form>

                    <?php if (isset($login_error)) { echo '<div class="alert alert-danger mt-3">' . $login_error . '</div>'; } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
