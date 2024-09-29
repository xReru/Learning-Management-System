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
        echo json_encode([
            'success' => true,
            'SID' => $SID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'studentID' => $student_id,
            'address' => $address
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

$conn->close();

