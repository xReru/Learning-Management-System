<?php
session_start();
include "../connect.php"; // Ensure this path is correct

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit;
}

// If the user clicks the logout button
if (isset($_POST['logout'])) {
    // Optionally log the logout action in your audit history
    // Assuming $name is defined somewhere in your code
    $viewloginl = "INSERT INTO tbl_audithistory (e_name, e_action, e_date) VALUES ('$name', 'Logged out', NOW())";
    // Uncomment and execute this if you have the config for $config
    // $result1 = $config->query($viewloginl);
    
    // Destroy the session and unset session variables
    session_destroy();
    unset($_SESSION['Aid']);
    
    // Redirect back to the login page
    header('Location: ../index.php'); // Redirect to login
    exit;
}
?>


