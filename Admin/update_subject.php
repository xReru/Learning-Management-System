<?php
include 'connect.php';

// Get the POST data
$subject_id = $_POST['subject_id'];
$subject_name = $_POST['subject_name'];
$subject_code = $_POST['subject_code'];
$grade_level = $_POST['grade_level'];

// Prepare the SQL update query
$sql = "UPDATE tbl_subject SET subject = ?, subject_code = ?, grade_level = ? WHERE subID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $subject, $subject_code, $grade_level, $subject_id);

// Execute the query and check for success
if ($stmt->execute()) {
    echo "Subject updated successfully!";
} else {
    echo "Error updating course: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();


