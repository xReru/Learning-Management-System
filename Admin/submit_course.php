<?php
include 'connect.php';

$courseName = $_POST['course_name'];
$courseDescription = $_POST['course_description'];
$courseCode = $_POST['course_code'];

// Insert the course into the database
$sql = "INSERT INTO courses (course_name, course_description, course_code) VALUES ('$courseName', '$courseDescription', '$courseCode')";

if ($conn->query($sql) === TRUE) {
    $course_id = $conn->insert_id; // Get the inserted course ID
    // Send a success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Course added successfully',
        'course_id' => $course_id,
        'course' => [
            'course_id' => $course_id,
            'course_name' => $courseName,
            'course_description' => $courseDescription,
            'course_code' => $courseCode
        ]
    ]);
} else {
    // Send an error response
    echo json_encode(['status' => 'error', 'message' => 'Failed to add course']);
}

?>
