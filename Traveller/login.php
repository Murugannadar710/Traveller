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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if user exists with the given email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user is found
    if ($result->num_rows > 0) {
        // User exists, now check password
        $user = $result->fetch_assoc();
        
        // Validate password (no hashing here since you requested plain text)
        if ($user['password'] === $password) {
            // Password is correct, start session and redirect to home.html
            session_start();
            $_SESSION['user_id'] = $user['id'];  // Store user info in session
            $_SESSION['user_name'] = $user['full_name'];  // Store user's full name in session
            echo "<script>
                    alert('Login successful! Redirecting to home...');
                    setTimeout(function() {
                        window.location.href = 'home.html'; // Redirect to home.html
                    }, 2000); // Redirect after 2 seconds
                  </script>";
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('No user found with that email. Please check and try again.');</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
