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
<html>
    <head>
        <meta charset="utf-8">
        <title>Admin Dashboard</title>
        <link rel="icon" href="../images/logasac.png">
        <body>
        <form action="logouts.php" method="post">
<?php include_once 'van.php'; ?>
    </form>
        
    
        </body>
    </head>
</html>

