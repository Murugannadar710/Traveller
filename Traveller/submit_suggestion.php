<?php
// Database connection variables
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password if any
$database = "traveller";

// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $suggestion = $conn->real_escape_string($_POST['suggestion']);

    // Insert data into the database
    $sql = "INSERT INTO suggestions (name, suggestion) VALUES ('$name', '$suggestion')";

    if ($conn->query($sql) === TRUE) {
        echo "Thank you for your suggestion!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
