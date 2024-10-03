<?php
// Connection
require_once "connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $student_id = intval(trim($_POST['student_id'])); // Ensure student ID is an integer
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $phone_number = intval(trim($_POST['phone_number'])); // Ensure phone number is an integer
    $address = htmlspecialchars(trim($_POST['address']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = 'Student'; // Set the role as Student

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_student (studentID, first_name, last_name, phone_number, address, email, Role) VALUES (?,  ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the input data
        $stmt->bind_param("ississs", $student_id, $first_name, $last_name, $phone_number, $address, $email, $role);

        // Execute the statement
        if ($stmt->execute()) {
            // Return JSON response
            echo json_encode([
                'success' => true,
                'SID' => $stmt->insert_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone_number' => $phone_number,
                'address' => $address,
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
