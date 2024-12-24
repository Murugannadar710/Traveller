<?php
// cancel_booking.php

// Database connection
$servername = "localhost";
$username = "root";  // Adjust as necessary
$password = "";      // Adjust as necessary
$dbname = "traveller"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // SQL query to delete the booking
    $sql = "DELETE FROM bookings WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $booking_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]); // Return success response
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete booking']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Booking ID not provided']);
}

$conn->close();
?>
