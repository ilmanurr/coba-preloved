<?php
session_start();

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coba_preloved";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform SQL query to check if the user exists
    $sql = "SELECT * FROM registrasi WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Set the session variable after successful login
        $_SESSION['username'] = $username;
        echo "Login successful";
    } else {
        echo "Login failed. Invalid username or password.";
    }
}

$conn->close();
?>
