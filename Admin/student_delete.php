<?php
include "connect.php";

// Retrieve the 'id' parameter from the GET request
$SID = $conn->real_escape_string($_GET['id']);

// Prepare separate delete queries for each table
$queries = [
    "DELETE FROM tbl_student WHERE SID = '$SID'",
    "DELETE FROM tbl_section WHERE secID = '$SID'",
    "DELETE FROM tbl_subject WHERE subID = '$SID'",
    "DELETE FROM tbl_gradelevel WHERE gradeID = '$SID'"
];

// Execute each query
$success = true;
foreach ($queries as $query) {
    if (!$conn->query($query)) {
        $success = false;
        break;
    }
}

if ($success) {
    ?>
    <script>
    alert("Successfully Deleted");
    </script>
    <?php
    header("refresh:0;url=account.php");
} else {
    echo "Error: " . $conn->error;
}

?>