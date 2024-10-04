<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section_name = mysqli_real_escape_string($conn, $_POST['section_name']);
    $section_code = mysqli_real_escape_string($conn, $_POST['section_code']);
    $section_grade = mysqli_real_escape_string($conn, $_POST['section_grade']);

    $sql = "INSERT INTO tbl_section (section, section_code, grade_level) VALUES ('$section_name', '$section_code', '$section_grade')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Section added successfully.";
    } else {
        echo "Error adding section: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
