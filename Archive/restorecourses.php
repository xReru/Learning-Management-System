<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID = $_POST['course_id'];

    // Insert the course back into courses table
    $sql = "INSERT INTO courses SELECT * FROM archive_courses WHERE course_id = '$ID'";

    if ($conn->query($sql) === TRUE) {
        // If insertion successful, delete the course from archive
        $deleteQuery = "DELETE FROM archive_courses WHERE course_id = '$ID'";
        if ($conn->query($deleteQuery) === TRUE) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failure']);
        }
    } else {
        echo json_encode(['status' => 'failure']);
    }
}
?>
