<?php
include "connect.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("refresh:0; ../login.php");
    exit;
} else if (isset($_SESSION['AID'])) {
    $userid = $_SESSION['AID'];

    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE AID ='$userid'");
    while ($rowedit = mysqli_fetch_assoc($getrecord)) {
        $type = $rowedit['Role'];
        $name = $rowedit['lname'] . " " . $rowedit['fname']; // Corrected to use fname
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $ID = $_POST['id'];

    // Move the announcement to the archive
    $archiveQuery = "INSERT INTO tbl_archive_announcements (id, title, description, announcement_date, created_at, image)
                    SELECT id, title, description, announcement_date, created_at, image 
                    FROM tbl_announcements 
                    WHERE id = '$ID'";

    // Start a transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Execute the archive query
        if (mysqli_query($conn, $archiveQuery)) {
            // Delete the announcement from tbl_announcements
            $deleteQuery = "DELETE FROM tbl_announcements WHERE id = '$ID'";
            if (mysqli_query($conn, $deleteQuery)) {
                // Commit the transaction
                mysqli_commit($conn);
                echo json_encode(['status' => 'success', 'message' => 'Announcement archived and deleted successfully.']);
            } else {
                throw new Exception('Failed to delete announcement.');
            }
        } else {
            throw new Exception('Failed to archive announcement.');
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    exit; // Ensure no further output is sent
}

$conn->close();
?>
