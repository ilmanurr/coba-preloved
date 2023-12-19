<?php
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
    $nama = $_POST["nama"];
    $noHp = $_POST["noHp"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $jenisKelamin = $_POST["jenis_kelamin"];

    // Perform SQL query to insert data into the table
    $sql = "INSERT INTO registrasi (username, nama, noHp, email, password, jenis_kelamin) VALUES ('$username', '$nama', '$noHp', '$email', '$password', '$jenisKelamin')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
