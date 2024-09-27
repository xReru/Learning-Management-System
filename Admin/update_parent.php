<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PID = intval($_POST['PID']);
	$parent_id = intval($_POST['parentID']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['parent_address'];
    $email = $_POST['email'];
    $phone_number = intval($_POST['phone_number']);

    $sql = "UPDATE tbl_parent SET parentID = ?, first_name = ?, last_name = ?, address = ?, email = ?, phone_number = ? WHERE PID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssii", $parent_id, $first_name, $last_name, $address, $email, $phone_number, $PID);
    
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

