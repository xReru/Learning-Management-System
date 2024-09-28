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
        echo json_encode([
            'success' => true,
            'Aid' => $AID,
            'adminID' => $admin_id,
            'username' => $username,
            'fname' => $first_name,
            'lname' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

$conn->close();



