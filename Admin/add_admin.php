<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $admin_id = $_POST['adminid'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $Role = $_POST['Roles'];

    // Prepare and execute the insertion
    $sql = "INSERT INTO tbl_admin (fname, lname, phone, username, Admin_ID, email, password, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssisisss", $first_name, $last_name, $phone_number, $username, $admin_id, $email, $hashed_password, $Role);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'Aid' => $stmt->insert_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'email' => $email,
            'admin_id' => $admin_id,
            'username' => $username 
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
