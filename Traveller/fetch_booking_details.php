<?php
// Include database connection
include 'db_connection.php';

// Query to fetch the latest booking details from the database
$query = "SELECT * FROM bookings ORDER BY booking_date DESC"; // Fetching all bookings ordered by booking_date
$result = mysqli_query($conn, $query);

// Check if any booking exists
if (mysqli_num_rows($result) > 0) {
    $bookings = []; // Array to hold all bookings data
    // Fetch all rows and store them in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    // Return the bookings data as an array
    echo json_encode($bookings);
} else {
    echo json_encode([]);
}

// Close the database connection
mysqli_close($conn);
?>
