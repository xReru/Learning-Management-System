<?php
include "../connect.php";
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
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
<form action="logouts.php" method="post">
<?php include_once 'van.php'; ?>
    </form>

    <div class="main-content">
        <div class="header-content">
            <h1>Announcement</h1>
            <form method="GET" class="search-form">
                <input type="text" class="search-bar" name="search" placeholder="Search courses..."
                    value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

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
        
            include '../connect.php';

        
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve search input
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            // SQL query with search condition
            if ($search) {
                $sql = "SELECT * FROM tbl_archive_announcements WHERE course_name LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM tbl_archive_announcements";
            }

            $result = mysqli_query($conn, $sql);

            // Display list of courses
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Title</th><th>Description</th><th>Event Date</th><th>Created Date</th><th>Image</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["announcement_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                    $source = "../uploads/".$row['image'];
                    echo "<td  ><img src=$source width=100% heigth=60%/></td>";
            
                    echo "<td><button class='btn ' onclick='location.href=\"restoreannounce.php?id=" . $row["id"] . "\"'>Restore</button>";
                   echo"</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No Announcement found.</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="courses_script.js"></script>
</body>

</html>