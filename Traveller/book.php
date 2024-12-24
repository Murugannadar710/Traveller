<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "traveller"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request (from the front-end)
$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['image'];
$price = $_POST['price'];
$distance = $_POST['distance'];
$travel_mode = $_POST['travel_mode']; // A string, e.g., "Road, Waterway"

// Insert data into the database
$sql = "INSERT INTO bookings (title, description, image, price, distance, travel_mode)
        VALUES ('$title', '$description', '$image', '$price', '$distance', '$travel_mode')";

if ($conn->query($sql) === TRUE) {
    echo "Booking successful!";
    // Redirect or show success message (optional)
    // header("Location: confirmation.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
