<?php
// Connect to database
include 'connect.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    
    $subject_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM tbl_subject WHERE subID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "i", $subject_id);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the main page with a success message
            header("Location: manage_subject.php?message=Subject removed successfully");
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "No Subject ID specified.";
}

// Close connection
mysqli_close($conn);

