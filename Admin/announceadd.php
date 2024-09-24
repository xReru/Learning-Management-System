<?php
include "connect.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("refresh:0; ../index.php");
    exit;
} else if (isset($_SESSION['Aid'])) {
    $userid = $_SESSION['Aid'];
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE Aid ='$userid'");
    while ($rowedit = mysqli_fetch_assoc($getrecord)) {
        $type = $rowedit['Role'];
        $name = $rowedit['fname'] . " " . $rowedit['lname'];
    }
}

if (isset($_POST['add']) && isset($_FILES['fileToUpload'])) {
    echo "<pre>";
    print_r($_FILES['fileToUpload']);
    echo "</pre>";

    $img_name = $_FILES['fileToUpload']['name'];
    $img_size = $_FILES['fileToUpload']['size'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $error = $_FILES['fileToUpload']['error'];

    if ($error === 0) {
        if ($img_size > 12500000) {
            $em = "Sorry, your file is too large.";
            header("Location: announceview.php?error=$em");
            exit;
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png"); 

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $create_title = mysqli_real_escape_string($conn, $_POST['create_title']);
                $create_description = mysqli_real_escape_string($conn, $_POST['create_description']);
                $create_date = $_POST['create_date']; // Date already in the correct format

                $sql = "INSERT INTO tbl_announcements (title, description, announcement_date, image) VALUES ('$create_title', '$create_description', '$create_date', '$new_img_name')";
                $insert = $conn->query($sql);

                if ($insert) {
                    echo "<script>alert('Successfully Added');</script>";
                    header("Location: addannouncement.php");
                    exit;
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                $em = "You can't upload files of this type";
                header("Location: addannouncement.php?error=$em");
                exit;
            }
        }
    }
}
?>
