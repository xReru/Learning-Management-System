<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TID = intval($_POST['TID']);
	$teacher_id = intval($_POST['teacherID']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['teacher_address'];
    $email = $_POST['email'];
    $phone_number = intval($_POST['phone_number']);

    $sql = "UPDATE tbl_teacher SET teacherID = ?, first_name = ?, last_name = ?, address = ?, email = ?, phone_number = ? WHERE TID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssii", $teacher_id, $first_name, $last_name, $address, $email, $phone_number, $TID);
    
    if ($stmt->execute()) {
        // Redirect or respond with success message
        header("Location: manage_account.php"); // Change this to your success page
    } else {
        // Handle errors
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

