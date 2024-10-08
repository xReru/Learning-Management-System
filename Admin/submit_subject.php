<?php
// Connect to database
include __DIR__ . '/connect.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the correct variables are being captured
    $subject_id = $_POST["subject_id"];
    $subject_name = $_POST["subject"];
    $subject_code = $_POST["subject_code"];
    $grade_level = $_POST["grade_level"];

    // Update query
    $sql = "UPDATE tbl_subject SET subject='$subject_name', subject_code='$subject_code', grade_level='$grade_level' WHERE subID='$subject_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Subject updated successfully!";
    } else {
        echo "Error updating subject: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
// Connect to database
include __DIR__ . '/connect.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST["subject_name"];
    $subject_code = $_POST["subject_code"];
    $grade_level = $_POST["grade_level"];

    // Insert data into database
    $sql = "INSERT INTO tbl_subject (subject, subject_code, grade_level) VALUES ('$subject_name', '$subject_code', '$grade_level')";

    if (mysqli_query($conn, $sql)) {
        echo "Subject added successfully!";
    } else {
        echo "Error adding subject: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);