<?php
include "connect.php";

$ID = $_GET['id'];

// Move the course to the archive table
$sql = "INSERT INTO archive_courses SELECT * FROM courses WHERE course_id = '$ID'";
$result = $conn->query($sql);

if ($result) {
    $query = "DELETE FROM courses WHERE course_id = '$ID'";
    if ($conn->query($query)) {
        // Respond with JSON for success
        echo json_encode(['status' => 'success', 'message' => 'Successfully archived course']);
    } else {
        // Respond with JSON for failure
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete course']);
    }
} else {
    // Respond with JSON for failure
    echo json_encode(['status' => 'error', 'message' => 'Failed to archive course']);
}
?>
