<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traveller";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$fact_id = isset($_POST['fact_id']) ? intval($_POST['fact_id']) : 0;

if ($fact_id > 0) {
    // Check if fact_id exists in the database
    $checkQuery = $conn->prepare("SELECT like_count FROM likes WHERE fact_id = ?");
    $checkQuery->bind_param("i", $fact_id);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        // Update like count
        $updateQuery = $conn->prepare("UPDATE likes SET like_count = like_count + 1 WHERE fact_id = ?");
        $updateQuery->bind_param("i", $fact_id);
        $updateQuery->execute();
    } else {
        // Insert new record
        $insertQuery = $conn->prepare("INSERT INTO likes (fact_id, like_count) VALUES (?, 1)");
        $insertQuery->bind_param("i", $fact_id);
        $insertQuery->execute();
    }

    // Retrieve updated like count
    $getLikesQuery = $conn->prepare("SELECT like_count FROM likes WHERE fact_id = ?");
    $getLikesQuery->bind_param("i", $fact_id);
    $getLikesQuery->execute();
    $likesResult = $getLikesQuery->get_result()->fetch_assoc();

    echo json_encode(["success" => true, "like_count" => $likesResult['like_count']]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid fact ID"]);
}

$conn->close();
?>
