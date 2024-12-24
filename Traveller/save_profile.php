<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traveller";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int)$_POST['age'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Prepare the SQL query to insert data
    $sql = "INSERT INTO profiles (name, email, age, address) VALUES ('$name', '$email', $age, '$address')";

    // Execute the query and check if it's successful
    if ($conn->query($sql) === TRUE) {
        header("Location: profile.html?status=success");
    } else {
        header("Location: profile.html?status=error");
    }
}

// Close the connection
$conn->close();
?>
