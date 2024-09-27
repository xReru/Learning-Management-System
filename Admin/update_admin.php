<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $AID = intval($_POST['AID']);
	$admin_id = intval($_POST['adminID']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$username = $_POST['admin_username'];
    $email = $_POST['email'];
    $phone_number = intval($_POST['phone_number']);

    $sql = "UPDATE tbl_admin SET Admin_ID = ?, fname = ?, lname = ?, username = ?, email = ?, phone = ? WHERE Aid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssii", $admin_id, $first_name, $last_name, $username, $email, $phone_number, $AID);
    
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

