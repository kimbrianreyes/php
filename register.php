<?php
include 'db_connection.php';

if (isset($_POST['register'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Validation
    if (empty($lastname) || empty($firstname) || empty($email) || empty($password) || empty($repeat_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $repeat_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO users (lastname, firstname, email, password) VALUES ('$lastname', '$firstname', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful.";
        } else {
            $error = "Error occurred. Try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                    Register
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="repeat_password" class="form-label">Repeat Password</label>
                            <input type="password" class="form-control" id="repeat_password" name="repeat_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="register">Register</button>
                    </form>

                    <?php if (isset($error)) { echo '<div class="alert alert-danger mt-3">' . $error . '</div>'; } ?>
                    <?php if (isset($success)) { echo '<div class="alert alert-success mt-3">' . $success . '</div>'; } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
