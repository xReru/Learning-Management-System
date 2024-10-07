<?php
include "connect.php";
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !isset($_POST['update_title']) || !isset($_POST['update_description']) || !isset($_POST['update_date'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['update_title']);
    $description = mysqli_real_escape_string($conn, $_POST['update_description']);
    $date = mysqli_real_escape_string($conn, $_POST['update_date']);

    $imagePath = '';
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES['fileToUpload']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            exit;
        }
    }

    if ($imagePath) {
        $query = "UPDATE tbl_announcements SET title = '$title', description = '$description', announcement_date = '$date', image = '$imagePath' WHERE id = $id";
    } else {
        $query = "UPDATE tbl_announcements SET title = '$title', description = '$description', announcement_date = '$date' WHERE id = $id";
    }

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Announcement updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating announcement: ' . $conn->error]);
    }
    
    $conn->close();
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
?>
