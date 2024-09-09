<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="manage_subject/styles.css">
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
   
<form method="POST" action="navs/nav.php">
<?php include_once 'navs/nav.php'; ?>
</form>
  
    <div class="main-content">
    <div class="header-content">
        <h1>Manage Subjects </h1>
        <form method="GET" class="search-form">
            <input type="text" class="search-bar" name="search" placeholder="Search section..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
    <button class="btn" onclick="location.href='add_subject.php'">Add New Subject</button>
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
        echo "<button class='btn' onclick='location.href=\"edit_subject.php?id=" . $row["subID"] . "\"'>Edit</button> ";
        echo "<button class='btn btn-remove' onclick='location.href=\"remove_subject.php?id=" . $row["subID"] . "\"'>Remove</button>";
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
</body>

</html>
