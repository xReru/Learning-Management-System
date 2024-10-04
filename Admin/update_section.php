<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);
    $section_name = mysqli_real_escape_string($conn, $_POST['section_name']);
    $section_code = mysqli_real_escape_string($conn, $_POST['section_code']);
    $section_grade = mysqli_real_escape_string($conn, $_POST['section_grade']);

    $sql = "UPDATE tbl_section SET section='$section_name', section_code='$section_code', grade_level='$section_grade' WHERE secID='$section_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Section updated successfully.";
    } else {
        echo "Error updating section: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
