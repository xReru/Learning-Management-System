<?php
if (isset($_POST['role']) && isset($_POST['user_id'])) {
    $role = $_POST['role'];
    $user_id = $_POST['user_id'];

    include 'connect.php'; // Database connection

    $archive_table = '';
    $user_table = '';
    $id_column = '';

    // Determine which table to use based on role
    switch ($role) {
        case 'admin':
            $archive_table = 'tbl_archive_admin';
            $user_table = 'tbl_admin';
            $id_column = 'Aid';
            break;
        case 'student':
            $archive_table = 'tbl_archive_student';
            $user_table = 'tbl_student';
            $id_column = 'SID';
            break;
        case 'teacher':
            $archive_table = 'tbl_archive_teacher';
            $user_table = 'tbl_teacher';
            $id_column = 'TID';
            break;
        case 'parent':
            $archive_table = 'tbl_archive_parent';
            $user_table = 'tbl_parent';
            $id_column = 'PID';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
            exit;
    }

    // Archive user by copying data to the archive table and deleting from the original table
    $sql = "INSERT INTO $archive_table SELECT * FROM $user_table WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    
    if ($stmt->execute()) {
        // Delete the user from the original table after archiving
        $delete_sql = "DELETE FROM $user_table WHERE $id_column = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param('i', $user_id);
        $delete_stmt->execute();

        echo json_encode(['status' => 'success', 'message' => ' archived successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to archive user']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
