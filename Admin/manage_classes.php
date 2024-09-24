<?php
include "connect.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("refresh:0; ../login.php");
    exit;
} else if (isset($_SESSION['AID'])) {
    $userid = $_SESSION['AID'];
    
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE AID ='$userid'");
    while ($rowedit = mysqli_fetch_assoc($getrecord)) {
        $type = $rowedit['Role'];
        $name = $rowedit['lname']." ".$rowedit['lname'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../images/logasac.png">
<link rel="stylesheet" type="text/css" href="styles.css">


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




<form action="logout.php" method="post">
<?php include_once 'navs/nav.php'; ?>
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

    <button class="btn" id="openModalBtn">Add New Section</button>
<!--AModal Add Section -->
    <div id="sectionModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Section</h2>
                    <span id="closeModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <label for="section_name">Section Name:</label>
                    <input type="text" id="section_name" name="section_name" required>

                    <label for="section_description">Section Description:</label>
                    <textarea id="section_description" name="section_description" required></textarea>

                    <label for="section_code">Section Code:</label>
                    <input type="text" id="section_code" name="section_code" required>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelBtn">Cancel</button>
                    <button class="btn-save" id="saveSectionBtn">Save Section</button>
                </div>
            </div>
        </div>
    <div class="table-container">
    <!-- Edit Section Modal -->
        <div id="editSectionModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Section</h2>
                    <span id="closeEditModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_section_id" name="section_id">

                    <label for="edit_section_name">Section Name:</label>
                    <input type="text" id="edit_section_name" name="section_name" required>

                    <label for="edit_section_description">Section Description:</label>
                    <textarea id="edit_section_description" name="section_description" required></textarea>

                    <label for="edit_section_code">Section Code:</label>
                    <input type="text" id="edit_section_code" name="section_code" required>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelEditBtn">Cancel</button>
                    <button class="btn-save" id="saveEditSectionBtn">Save Changes</button>
                </div>
            </div>
        </div>
    <?php
// Connect to database
include "connect.php";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query with search condition
if ($search) {
    $sql = "SELECT tbl_gradelevel.grade_level, tbl_section.section_code,tbl_section.section, tbl_section.secID AS secID
            FROM tbl_section
            JOIN tbl_gradelevel ON tbl_section.secID = tbl_gradelevel.gradeID
            WHERE tbl_section.section LIKE '%$search%' OR tbl_section.section_code LIKE '%$search%' OR tbl_gradelevel.grade_level LIKE '%$search%'";
} else {
    $sql = "SELECT tbl_gradelevel.grade_level, tbl_section.section_code,tbl_section.section, tbl_section.secID AS secID
            FROM tbl_section
            JOIN tbl_gradelevel ON tbl_section.secID = tbl_gradelevel.gradeID";
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
