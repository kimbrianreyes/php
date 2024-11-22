<?php
// Initialize error array
$errors = array();

// Only process if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $LastName = $_POST["LastName"];
    $FirstName = $_POST["FirstName"];
    $email = $_POST["Email"];
    $password = $_POST["password"];
    $RepeatPassword = $_POST["repeat_password"];

    // Validate fields
    if (empty($LastName) || empty($FirstName) || empty($email) || empty($password) || empty($RepeatPassword)) {
        array_push($errors, "All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }

    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    if ($password != $RepeatPassword) {
        array_push($errors, "Password does not match");
    }

    // If there are errors, show them
    if (count($errors) == 0) {
        // If no errors, proceed with registration (database insert, etc.)
        // You can insert the data here
        echo "<div class='alert alert-success'>Registration successful!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        // If there are any errors, display them
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        ?>

        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?php echo isset($LastName) ? $LastName : ''; ?>" >
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="FirstName" placeholder="First Name" value="<?php echo isset($FirstName) ? $FirstName : ''; ?>" >
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Input Password" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit" value="Register">
            </div>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
