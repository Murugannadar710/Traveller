<?php
// Database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "traveller";  // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $date_time = date("Y-m-d H:i:s");  // Get current date and time

    // SQL query to insert data into the database
    $sql = "INSERT INTO contact_messages (name, email, message, date_time)
            VALUES ('$name', '$email', '$message', '$date_time')";

    if ($conn->query($sql) === TRUE) {
        $alertMessage = "Your message has been successfully sent!";
        $alertType = "success";  // You can customize the alert type (e.g., success, error)
    } else {
        $alertMessage = "Error: " . $conn->error;
        $alertType = "error";
    }

    // Close the database connection
    $conn->close();
} else {
    $alertMessage = "Invalid request!";
    $alertType = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup Alert</title>
    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            display: none;
        }

        .popup.success {
            background-color:rgb(3, 24, 4);
        }

        .popup.error {
            background-color: #f44336;
        }

        .popup button {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
        }

        .popup button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

    <!-- Popup Alert -->
    <div id="popup" class="popup <?php echo $alertType; ?>">
        <p><?php echo $alertMessage; ?></p>
        <button onclick="closePopup()">Close</button>
    </div>

    <script>
        // Show the popup after form submission
        window.onload = function() {
            document.getElementById('popup').style.display = 'block';
        };

        // Function to close the popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            // Optionally, redirect to another page after closing the popup
            window.location.href = 'home.html';  // Redirect to home or another page
        }
    </script>
</body>
</html>
