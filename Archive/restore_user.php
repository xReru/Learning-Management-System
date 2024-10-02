<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Admin/connect.php'; // Database connection

if (isset($_POST['role']) && isset($_POST['user_id'])) {
    $role = $_POST['role'];
    $user_id = $_POST['user_id'];

    error_log('User ID received: ' . $user_id);
    error_log('Role received: ' . $role);

    if (!$conn) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }

    $archive_table = '';
    $user_table = '';
    $id_column = '';

    // Determine which table to use based on role
    switch ($role) {
        case 'admin':
            $archive_table = 'tbl_admin';
            $user_table = 'tbl_archive_admin';
            $id_column = 'Aid';
            break;
        case 'student':
            $archive_table = 'tbl_student';
            $user_table = 'tbl_archive_student';
            $id_column = 'SID';
            break;
        case 'teacher':
            $archive_table = 'tbl_teacher';
            $user_table = 'tbl_archive_teacher';
            $id_column = 'TID';
            break;
        case 'parent':
            $archive_table = 'tbl_parent';
            $user_table = 'tbl_archive_parent';
            $id_column = 'PID';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
            exit;
    }

    // Check if the user exists in the user table
    $check_sql = "SELECT * FROM $user_table WHERE $id_column = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('i', $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found in the original table']);
        exit;
    }

    // Archive user by copying data to the archive table and deleting from the original table
    $sql = "INSERT INTO $archive_table SELECT * FROM $user_table WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'SQL prepare failed']);
        exit;
    }

    $stmt->bind_param('i', $user_id);
    
    if ($stmt->execute()) {
        // Delete the user from the original table after archiving
        $delete_sql = "DELETE FROM $user_table WHERE $id_column = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param('i', $user_id);
        
        if ($delete_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User archived successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user from original table']);
        }

        $delete_stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to archive user']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
