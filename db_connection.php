<?php
$host = "localhost:3307";
$username = "root";
$password = "";
$database = "pangalan ng database mo sa hood";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
