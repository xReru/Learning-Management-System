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
        echo json_encode([
            'success' => true,
            'PID' => $PID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'parentID' => $parent_id,
            'address' => $address
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

$conn->close();

