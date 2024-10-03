<?php
include "../connect.php";
session_start();


?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../Admin/styles.css">
<link rel="icon" href="../images/logasac.png">

</head>
<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    position: relative;
}

table, th, td {
    border: 1px solid #ddd;
}

th {
    background-color: #b40404;
    color: white;
    padding: 12px;
    text-align: left;
    position: sticky;
    top: 0;
    z-index: 2;
}

td {
    padding: 12px;
    text-align: left;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}
    </style>
<body>

<?php include_once 'van.php'; ?>
    </form>
    <div class="main-content">

    <div class="header-content">
    <h1>Manage Classes / Sections</h1>
    <form method="GET" class="search-form">
        <div class="search-container">
            <input type="text" class="search-bar" name="search" placeholder="Search section..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn-search">Search</button>
        </div>
    </form>
</div>

   
    <?php

include "../connect.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query with search condition
if ($search) {
    $sql = "SELECT tbl_archive_gradelevel.grade_level, tbl_archive_section.section_code,tbl_archive_section.section, tbl_archive_section.secID AS secID
            FROM tbl_archive_section
            JOIN tbl_archive_gradelevel ON tbl_archive_section.secID = tbl_archive_gradelevel.gradeID
            WHERE tbl_archive_section.section LIKE '%$search%' OR tbl_archive_section.section_code LIKE '%$search%' OR tbl_archive_gradelevel.grade_level LIKE '%$search%'";
} else {
    $sql = "SELECT tbl_archive_gradelevel.grade_level, tbl_archive_section.section_code,tbl_archive_section.section, tbl_archive_section.secID AS secID
            FROM tbl_archive_section
            JOIN tbl_archive_gradelevel ON tbl_archive_section.secID = tbl_archive_gradelevel.gradeID";
}

$result = mysqli_query($conn, $sql);

// Display list of students with their sections
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Section</th><th>Grade Level</th><th>Section Code</th><th>Actions</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["section"] . "</td>";
        echo "<td>" . $row["grade_level"] . "</td>";
        echo "<td>" . $row["section_code"] . "</td>";
        echo "<td>";
        echo "<button class='btn' onclick='openEditModal(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button> ";
        echo "<button class='btn btn-remove' onclick='location.href=\"remove_section.php?id=" . $row["secID"] . "\"'>Archive</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No students found.</p>";
}

// Close connection
mysqli_close($conn);
?>

    </div>
</div>
<script src="section_script.js"></script>
</body>

</html>
