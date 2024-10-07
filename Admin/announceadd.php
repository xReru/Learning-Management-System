<?php
include "connect.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

if (isset($_SESSION['Aid'])) {
    $userid = $_SESSION['Aid'];
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE Aid ='$userid'");
    while ($rowedit = mysqli_fetch_assoc($getrecord)) {
        $type = $rowedit['Role'];
        $name = $rowedit['fname'] . " " . $rowedit['lname'];
    }
}

if (isset($_POST['add'])) {
    $new_img_name = null; // Default to null or you can set a default image

    // Check if a file was uploaded
    if (!empty($_FILES['fileToUpload']['name'])) {
        $img_name = $_FILES['fileToUpload']['name'];
        $img_size = $_FILES['fileToUpload']['size'];
        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
        $error = $_FILES['fileToUpload']['error'];

        if ($error === 0) {
            if ($img_size > 12500000) {
                echo json_encode(['success' => false, 'error' => "Sorry, your file is too large."]);
                exit;
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../uploads/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    echo json_encode(['success' => false, 'error' => "You can't upload files of this type."]);
                    exit;
                }
            }
        } else {
            echo json_encode(['success' => false, 'error' => "Error uploading file. Please try again."]);
            exit;
        }
    }

    // Prepare announcement data
    $create_title = mysqli_real_escape_string($conn, $_POST['create_title']);
    $create_description = mysqli_real_escape_string($conn, $_POST['create_description']);
    $create_date = $_POST['create_date']; // Date already in the correct format

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_announcements (title, description, announcement_date" . ($new_img_name ? ", image" : "") . ") VALUES ('$create_title', '$create_description', '$create_date'" . ($new_img_name ? ", '$new_img_name'" : "") . ")";

    // Execute the insert query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => "No form submitted."]);
}
?>
