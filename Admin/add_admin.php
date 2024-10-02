<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $username = htmlspecialchars($_POST['username']);
    $admin_id = htmlspecialchars($_POST['adminid']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'Admin';

    // Insert into the database
    $sql = "INSERT INTO tbl_admin (fname, lname, phone, username, Admin_ID, email, password, Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssisisss", $first_name, $last_name, $phone_number, $username, $admin_id, $email, $password, $role);

        if ($stmt->execute()) {
            // Return JSON response
            echo json_encode([
                'success' => true,
                'Aid' => $stmt->insert_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'email' => $email
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
}
?>
