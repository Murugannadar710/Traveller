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

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the user details from the database
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Get the user's data
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User ID not provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // You can add password hashing here
    $created_at = $_POST['created_at'];

    // Update the user details in the database
    $update_sql = "UPDATE users SET full_name = '$full_name', email = '$email', password = '$password', created_at = '$created_at' WHERE id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully.";
        header('Location: admin.php'); // Redirect to the admin dashboard
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Global Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    width: 80%;
    max-width: 1200px;
    margin: 40px auto;
}

/* Heading Styles */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 32px;
}

h2 {
    text-align: center;
    color: #666;
    font-size: 22px;
}

/* Form Styling */
form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
}

form label {
    font-size: 16px;
    color: #333;
    display: block;
    margin-bottom: 8px;
}

form input[type="text"], 
form input[type="email"], 
form input[type="password"], 
form input[type="date"] {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease;
}

form input[type="text"]:focus,
form input[type="email"]:focus,
form input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
}

form input[type="submit"] {
    background-color: #28a745;
    color: white;
    font-size: 18px;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

form input[type="submit"]:hover {
    background-color: #218838;
}

/* Card Styling */
.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.card {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.card h3 {
    font-size: 20px;
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
    transition: background-color 0.3s ease;
}

.card .btn:hover {
    background-color: #0056b3;
}

/* Buttons */
.add-user-btn {
    display: block;
    width: 220px;
    margin: 30px auto;
    padding: 14px;
    background-color: #28a745;
    color: white;
    text-align: center;
    font-size: 18px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.add-user-btn:hover {
    background-color: #218838;
}

/* Table Styles */
table {
    width: 100%;
    margin-top: 40px;
    border-collapse: collapse;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 14px;
    text-align: left;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
}

th {
    background-color: #007bff;
    color: white;
}

td {
    background-color: #f9f9f9;
}

/* Action Buttons */
.action-buttons a {
    padding: 10px 18px;
    background-color: #ffc107;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-right: 10px;
}

.action-buttons a:hover {
    background-color: #e0a800;
}

.action-buttons a:focus {
    outline: none;
}

/* Back Button Styling */
.back-btn {
    display: inline-block;
    padding: 12px 20px;
    background-color: #007bff;
    color: white;
    text-align: center;
    font-size: 18px;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-bottom: 20px;
}

.back-btn:hover {
    background-color: #0056b3;
}

.back-btn:focus {
    outline: none;
}

    </style>
</head>

<body>

    <h1>Edit User Details</h1>

    <a href="admin.php" class="back-btn">← Back to Admin Dashboard</a>


    <form method="POST">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required><br><br>

        <label for="created_at">Created At:</label><br>
        <input type="text" id="created_at" name="created_at" value="<?php echo htmlspecialchars($user['created_at']); ?>" required><br><br>

        <input type="submit" value="Update User">
    </form>

</body>

</html>
