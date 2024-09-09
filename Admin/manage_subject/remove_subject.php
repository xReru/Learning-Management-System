// remove_subject.php
<?php
include 'connect.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $subID = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Change the table to tbl_subject
    $sql = "DELETE FROM tbl_subject WHERE subID = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $subID);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: manage_subject.php?message=Subject removed successfully");
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "No subject ID specified.";
}

mysqli_close($conn);
?>
