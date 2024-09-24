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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" href="../images/logasac.png">
</head>

<body>
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
 
 <form action="logout.php" method="post">
<?php include_once 'navs/nav.php'; ?>
    </form>
  

    <div class="main-content">
        <div class="header-content">
            <h1>Manage Subjects </h1>
            <form method="GET" class="search-form">
                <input type="text" class="search-bar" name="search" placeholder="Search section..."
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>
        <button class="btn" id="openModalBtn">Add New Subject</button>

        <!-- Modal Add Subject -->
        <div id="subjectModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Subject</h2>
                    <span id="closeModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <label for="subject_name">Subject Name:</label>
                    <input type="text" id="subject_name" name="subject_name" required>

                    <label for="subject_code">Subject Code:</label>
                    <input id="subject_code" name="subject_code" required></input>

                    <label for="grade_level">Grade Level:</label>
                    <select id="grade_level" name="grade_level" required>
                        <option value="">-- Select Grade Level --</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="modal-footer"> 
                    <button class="btn-close" id="cancelBtn">Cancel</button>
                    <button class="btn-save" id="saveSubjectBtn">Save Subject</button>
                </div>
            </div>
        </div>
        <!-- Edit Subject Modal -->
        <div id="editSubjectModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit subject</h2>
                    <span id="closeEditModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_subject_id" name="subject_id">

                    <label for="edit_subject_name">Subject Name:</label>
                    <input id="edit_subject_name" name="subject_name" required></input>

                    <label for="edit_subject_code">Subject Code:</label>
                    <input id="edit_subject_code" name="subject_code" required></input>

                    <label for="edit_grade_level">Grade Level:</label>
                    <select id="edit_grade_level" name="grade_level" required>
                        <option value="">-- Select Grade Level --</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelEditBtn">Cancel</button>
                    <button class="btn-save" id="saveEditSubjectBtn">Save Changes</button>
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
                    <p>Are you sure you want to remove this subject?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelRemoveBtn">Cancel</button>
                    <button class="btn-remove" id="confirmRemoveBtn">Confirm</button>
                </div>
            </div>
        </div>
        <div class="table-container">
            <?php

            include 'connect.php';


            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }


            $search = isset($_GET['search']) ? $_GET['search'] : '';


            if ($search) {
                $sql = "SELECT * FROM tbl_subject WHERE subject LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM tbl_subject";
            }


            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Grade Level</th><th>Subject</th><th>Subject Code</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["grade_level"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "<td>" . $row["subject_code"] . "</td>";
                    echo "<td>";
                    echo "<button class='btn' onclick='openEditModal(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button> ";
                    echo "<button class='btn btn-remove' onclick='location.href=\"remove_subject.php?id=" . $row["subID"] . "\"'>Archive</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No subjects found.</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>

        </div>
    </div>
    <script src="subject_script.js"></script>
</body>

</html>