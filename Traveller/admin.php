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

// Fetch data from the users table
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

// Fetch data from other tables (bookings, contact_messages, etc.)
$sql_bookings = "SELECT * FROM bookings";
$result_bookings = $conn->query($sql_bookings);

$sql_contact_messages = "SELECT * FROM contact_messages";
$result_contact_messages = $conn->query($sql_contact_messages);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Inline CSS -->
    <style>
       /* Global Styles */
       body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            margin: 0 auto;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Card Container */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 18px;
            color: #333;
        }

        .card p {
            font-size: 16px;
            color: #666;
        }

        .card .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .card .btn:hover {
            background-color: #0056b3;
        }

        /* Buttons */
        .add-user-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-align: center;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-user-btn:hover {
            background-color: #218838;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .action-buttons a {
            margin-right: 15px;
            padding: 8px 15px;
            background-color: #ffc107;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .action-buttons a:hover {
            background-color: #e0a800;
        }

        /* Exit Icon Styling */
.exit-icon {
    display: inline-block;
    padding: 10px 20px;
    background-color: #dc3545; /* Red background */
    color: white;
    font-size: 18px;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}

.exit-icon:hover {
    background-color: #c82333; /* Darker red on hover */
}

.exit-icon i {
    margin-right: 8px; /* Space between icon and text */
}

.exit-icon:focus {
    outline: none;
}


    </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <!-- Exit Icon -->
<a href="index.html" class="exit-icon">
    <i class="fas fa-sign-out-alt"></i> Exit
</a>
        

            <!-- Add User Button -->
            <a href="add_user.php" class="add-user-btn">Add User</a>

        <!-- Users Table -->
        <div class="table-container">
            <h2>Users Table</h2>
            <table id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_users->num_rows > 0) {
                        while ($row = $result_users->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['password']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                                <td class='action-buttons'>
    <a href='edit_user.php?id=" . $row['id'] . "' class='btn'>Edit</a>
    <a href='delete_user.php?id=" . $row['id'] . "' class='btn'>Delete</a>
</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Bookings Table -->
        <div class="table-container">
            <h2>Bookings Table</h2>
            <table id="bookings-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User ID</th>
                        <th>Booking Date</th>
                        <th>Booking Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_bookings->num_rows > 0) {
                        while ($row = $result_bookings->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['user_id']) . "</td>
                                <td>" . htmlspecialchars($row['booking_date']) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

      <!-- Contact Messages Table -->
<div class="table-container">
    <h2>Contact Messages Table</h2>
    <table id="contact-messages-table">
        <thead>
            <tr>
                <th>Message ID</th>
                <th>User ID</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_contact_messages->num_rows > 0) {
                while ($row = $result_contact_messages->fetch_assoc()) {
                    // Check if 'user_id' and 'created_at' exist in the row before accessing them
                    $user_id = isset($row['user_id']) ? $row['user_id'] : 'N/A';
                    $created_at = isset($row['created_at']) ? $row['created_at'] : 'N/A';
                    $message = isset($row['message']) ? $row['message'] : 'No message content';
                    
                    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $user_id . "</td>
                        <td>" . $message . "</td>
                        <td>" . $created_at . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

        <!-- Add more tables here as needed -->

    </div>

    <!-- Inline JavaScript -->
    <script>
        // Add interactivity if needed
        document.addEventListener('DOMContentLoaded', function () {
            // You can add interactivity here, such as confirmation before deleting records, etc.
        });
    </script>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
