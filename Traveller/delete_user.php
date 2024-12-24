<?php
// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "traveller"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user ID is passed
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE id = $user_id";

    // Execute the query and check if successful
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully.";
        header('Location: admin.php'); // Redirect to the admin dashboard after deletion
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No user ID provided.";
}

$conn->close();
?>
