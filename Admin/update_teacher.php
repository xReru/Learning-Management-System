<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $TID = $_POST['TID'];
    $teacher_id = intval($_POST['teacherID']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['teacher_address'];

    $sql = "UPDATE tbl_teacher SET teacherID = ?, first_name = ?, last_name = ?, address = ?, email = ?, phone_number = ? WHERE TID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $teacher_id, $first_name, $last_name, $address, $email, $phone_number, $TID);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'TID' => $TID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'teacherID' => $teacher_id,
            'address' => $address
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
