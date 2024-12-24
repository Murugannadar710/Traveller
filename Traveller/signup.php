<?php
// Database connection settings
$servername = "localhost"; // Change to your server if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "traveller"; // The database name you created earlier

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $password);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        // Success: Show alert and redirect to login.html
        echo "<script>
                alert('Signup successful! Redirecting to login...');
                setTimeout(function() {
                    window.location.href = 'login.html';
                }, 2000); // Redirect after 2 seconds
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
