<?php
include "../connect.php";
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="../css_admin/manage_account.css">
    <link rel="icon" href="../images/logasac.png">

</head>
<body>

<form action="logouts.php" method="post">
<?php include_once 'van.php'; ?>
    </form>
    <div class="whitebox">
        <p>Manage Accounts</p>
       

        <div class="filter-container">
            <form action="manage_account.php" method="get">
            <input type="text" class="search-bar" placeholder="Search" alt="search">
            <button class="search-button">Search</button>
            </form>

            <form method="POST" action="">
                <select id="category" name="category" onchange="this.form.submit()">
                    <option value disabled selected>Select a user account</option>
                    <option value="student" <?php echo isset($_POST['category']) && $_POST['category'] == 'student' ? 'selected' : ''; ?>>Students</option>
                    <option value="teacher" <?php echo isset($_POST['category']) && $_POST['category'] == 'teacher' ? 'selected' : ''; ?>>Teachers</option>
                    <option value="parent" <?php echo isset($_POST['category']) && $_POST['category'] == 'parent' ? 'selected' : ''; ?>>Parents</option>
                    <option value="admin" <?php echo isset($_POST['category']) && $_POST['category'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </form>
        </div>

        <div id="tableContainer">
            <?php include_once 'archiveaccounts.php'; ?>
        </div>

   
</body>
</html>