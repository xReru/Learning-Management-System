<?php
include 'connect.php';

if (isset($_GET['category']) && isset($_GET['id'])) {
    $category = $_GET['category'];
    $id = intval($_GET['id']);
    
    // Prepare SQL query based on category
    switch ($category) {
        case 'teacher':
            $sql = "SELECT TID, teacherID, first_name, last_name, address, email, phone_number FROM tbl_teacher WHERE TID = ?";
            break;
        case 'student':
            $sql = "SELECT SID, studentID, first_name, last_name, address, email, phone_number FROM tbl_student WHERE SID = ?";
            break;
        case 'parent':
            $sql = "SELECT PID, parentID, first_name, last_name, address, email, phone_number FROM tbl_parent WHERE PID = ?";
            break;
        case 'admin':
            $sql = "SELECT Aid, Admin_ID, fname, lname, username, email, phone FROM tbl_admin WHERE Aid = ?";
            break;
        default:
            echo json_encode(['error' => 'Invalid category']);
            exit;
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Failed to prepare statement']);
        exit;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);  // Return the fetched data
    } else {
        echo json_encode(['error' => 'No records found']);
    }
    $stmt->close();
}

$conn->close();
