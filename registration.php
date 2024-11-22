<?php
$errors = array();

$servername = "localhost"; 
$username = "root";       
$password = "";           
$dbname = "log_register"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    $LastName = $_POST["LastName"];
    $FirstName = $_POST["FirstName"];
    $email = $_POST["Email"];
    $password = $_POST["password"];
    $RepeatPassword = $_POST["repeat_password"];

    $passwordHush = password_hash($password, PASSWORD_DEFAULT);

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

    if (count($errors) == 0) {
        $sql = "INSERT INTO user (Last_Name, First_Name, email, password) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $LastName, $FirstName, $email, $passwordHush);
            
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Registration successful!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Close the connection
$conn->close();
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
