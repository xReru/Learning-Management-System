<?php
include "connect.php";

$sql = "SELECT secID, section, section_code, grade_level FROM tbl_section";
$result = mysqli_query($conn, $sql);
$sections = [];

while ($row = mysqli_fetch_assoc($result)) {
    $sections[] = $row;
}

mysqli_close($conn);
echo json_encode($sections);
?>
