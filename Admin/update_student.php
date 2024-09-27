<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SID = intval($_POST['SID']);
	$student_id = intval($_POST['studentID']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['student_address'];
    $email = $_POST['email'];
    $phone_number = intval($_POST['phone_number']);

    $sql = "UPDATE tbl_student SET studentID = ?, first_name = ?, last_name = ?, address = ?, email = ?,phone_number = ? WHERE SID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssii", $student_id, $first_name, $last_name, $address, $email, $phone_number, $SID);
    
    if ($stmt->execute()) {
        // Redirect or respond with success message
        header("Location: manage_account.php"); 
    } else {
        // Handle errors
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

