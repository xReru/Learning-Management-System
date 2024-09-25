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
      <form action="logouts.php" method="post">
<?php include_once 'van.php'; ?>
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
    
        <!-- Remove Confirmation Modal -->
      
            <?php

            include '../connect.php';


            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }


            $search = isset($_GET['search']) ? $_GET['search'] : '';


            if ($search) {
                $sql = "SELECT * FROM tbl_archive_subject WHERE subject LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM tbl_archive_subject";
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
                    echo "<button class='btn ' onclick='location.href=\"restoresubject.php?id=" . $row["subID"] . "\"'>Restore</button>";
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