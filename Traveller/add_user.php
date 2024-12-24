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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle user addition
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_insert = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('New user added successfully'); window.location.href = 'admin.php';</script>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Inline CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .action-buttons {
            display: inline-block;
            margin-top: 10px;
        }

        .action-buttons a {
            margin-right: 15px;
        }

        .table-container {
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container .password-container {
            position: relative;
        }

        .form-container .password-container input[type="password"] {
            width: calc(100% - 40px);
        }

        .form-container .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Add New User Form -->
    <div class="form-container">
        <h2>Add New User</h2>
        <form method="POST" action="">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <input type="submit" value="Add User">
        </form>
    </div>

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
                // Fetch data from the users table
                $sql_users = "SELECT * FROM users";
                $result_users = $conn->query($sql_users);

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
</div>

<!-- Inline JavaScript -->
<script>
    // Function to toggle password visibility
    function togglePassword() {
        var passwordInput = document.getElementById('password');
        var passwordIcon = document.querySelector('.toggle-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.textContent = '🙈';  // Change icon to 'Hide' (as an example)
        } else {
            passwordInput.type = 'password';
            passwordIcon.textContent = '👁️';  // Change icon to 'Show' (as an example)
        }
    }
</script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
