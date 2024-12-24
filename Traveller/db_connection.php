<?php
$servername = "localhost"; // Database server (usually localhost)
$username = "root"; // Database username (default for local development is usually 'root')
$password = ""; // Database password (leave blank for default or your custom password)
$dbname = "traveller"; // The database name where the booking details are stored

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
