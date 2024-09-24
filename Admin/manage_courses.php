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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses / Strand</title>
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
            <h1>Manage Courses / Strand</h1>
            <form method="GET" class="search-form">
                <input type="text" class="search-bar" name="search" placeholder="Search courses..."
                    value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <button class="btn" id="openModalBtn">Add New Course</button>
        <!-- Modal Add Courses -->
        <div id="courseModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Course</h2>
                    <span id="closeModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <label for="course_name">Course Name:</label>
                    <input type="text" id="course_name" name="course_name" required>

                    <label for="course_description">Course Description:</label>
                    <textarea id="course_description" name="course_description" required></textarea>

                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelBtn">Cancel</button>
                    <button class="btn-save" id="saveCourseBtn">Save Course</button>
                </div>
            </div>
        </div>

        <!-- Edit Course Modal -->
        <div id="editCourseModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Course</h2>
                    <span id="closeEditModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_course_id" name="course_id">

                    <label for="edit_course_name">Course Name:</label>
                    <input type="text" id="edit_course_name" name="course_name" required>

                    <label for="edit_course_description">Course Description:</label>
                    <textarea id="edit_course_description" name="course_description" required></textarea>

                    <label for="edit_course_code">Course Code:</label>
                    <input type="text" id="edit_course_code" name="course_code" required>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelEditBtn">Cancel</button>
                    <button class="btn-save" id="saveEditCourseBtn">Save Changes</button>
                </div>
            </div>
        </div>
        <!-- Remove Confirmation Modal -->
        <div id="removeConfirmationModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Confirm Removal</h2>
                    <span id="closeRemoveModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this course?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelRemoveBtn">Cancel</button>
                    <button class="btn-remove" id="confirmRemoveBtn">Confirm</button>
                </div>
            </div>
        </div>
        <div class="table-container">
            <?php
            // Connect to database
            include 'connect.php';

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve search input
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            // SQL query with search condition
            if ($search) {
                $sql = "SELECT * FROM courses WHERE course_name LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM courses";
            }

            $result = mysqli_query($conn, $sql);

            // Display list of courses
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Course Name</th><th>Course Description</th><th>Course Code</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["course_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["course_description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["course_code"]) . "</td>";
                    echo "<td>";
                    echo "<button class='btn' onclick='openEditModal(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button> ";
                    echo "<button class='btn btn-remove' onclick='location.href=\"remove_course.php?id=" . $row["course_id"] . "\"'>Archive</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No courses found.</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="courses_script.js"></script>
</body>

</html>