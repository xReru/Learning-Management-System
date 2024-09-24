<?php
include "../connect.php";
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
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="../css_admin/manage_account.css">
    <link rel="icon" href="../images/logasac.png">

</head>
<body>

<?php include_once 'van.php'; ?>
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
                    <option value="students" <?php echo isset($_POST['category']) && $_POST['category'] == 'students' ? 'selected' : ''; ?>>Students</option>
                    <option value="teachers" <?php echo isset($_POST['category']) && $_POST['category'] == 'teachers' ? 'selected' : ''; ?>>Teachers</option>
                    <option value="parents" <?php echo isset($_POST['category']) && $_POST['category'] == 'parents' ? 'selected' : ''; ?>>Parents</option>
                    <option value="admin" <?php echo isset($_POST['category']) && $_POST['category'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </form>
        </div>

        <div id="tableContainer">
            <?php include_once 'archiveaccounts.php'; ?>
        </div>

   
</body>
</html>