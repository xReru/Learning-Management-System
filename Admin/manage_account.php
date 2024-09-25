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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <link rel="icon" href="../images/logasac.png">
    <link rel="stylesheet" href="../css_admin/manage_account.css">

</head>
<body>

<form action="logout.php" method="post">
<?php include_once 'navs/nav.php'; ?>
    </form>
    <div class="whitebox">
        <p>Manage Accounts</p>
        <div class="button-container">
            <button type="button" id="adminadd" class="btn btn-danger">Admin</button>
            <button type="button" id="studentadd" class="btn btn-primary">Student</button>
            <button type="button" id="teacheradd" class="btn btn-secondary">Teacher</button>
            <button type="button" id="parentadd" class="btn btn-tertiary">Parent</button>
        </div>

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
            <?php include_once 'accounts.php'; ?>
        </div>

        <div id="admin-modal" class="admin-modal">
            <div class="admin-content">
                <span class="close-admin">&times;</span>
                <h2>Add Admin Information</h2>
                <form action="add_admin.php" method="POST">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                    
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                    
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="adminid">Admin ID:</label>
                    <input type="text" id="adminid" name="adminid" required>

                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <select id ="Roles" name="Roles" value="Admin" hidden>
                                        <option value="Admin">Admin</option>
                                    </select>
                    <button type="submit">Add Admin</button>
                </form>
            </div>
        </div>

        <div id="student-modal" class="student-modal">
            <div class="student-content">
                <span class="close-student">&times;</span>
                <h2>Add Student Information</h2>
                <form action="add_student.php" method="POST">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                    
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <label for="Role">Role:</label>
                    <input type="Role" id="Role" name="Role" value="student" required readonly>
                    
                    <button type="submit">Add Student</button>
                </form>
            </div>
        </div>

       
        <div id="teacher-modal" class="teacher-modal">
            <div class="teacher-content">
                <span class="close-teacher">&times;</span>
                <h2>Add Teacher Information</h2>
                <form action="add_teacher.php" method="POST">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                    
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <label for="Role">Role:</label>
                    <input type="Role" id="Role" name="Role" value="teacher" required readonly>
                    
                    <button type="submit">Add Teacher</button>
                </form>
            </div>
        </div>

   
        <div id="parent-modal" class="parent-modal">
            <div class="parent-content">
                <span class="close-parent">&times;</span>
                <h2>Add Parent Information</h2>
                <form action="add_parent.php" method="POST">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                    
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <label for="Role">Role:</label>
                    <input type="Role" id="Role" name="Role" value="parent" required readonly>
                    
                    <button type="submit">Add Parent</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        var adminModal = document.getElementById("admin-modal");
        var studentModal = document.getElementById("student-modal");
        var teacherModal = document.getElementById("teacher-modal");
        var parentModal = document.getElementById("parent-modal");

        var adminBtn = document.getElementById("adminadd");
        var studentBtn = document.getElementById("studentadd");
        var teacherBtn = document.getElementById("teacheradd");
        var parentBtn = document.getElementById("parentadd");

        var adminClose = document.querySelector(".close-admin");
        var studentClose = document.querySelector(".close-student");
        var teacherClose = document.querySelector(".close-teacher");
        var parentClose = document.querySelector(".close-parent");

        adminBtn.onclick = function() {
            adminModal.style.display = "block";
        }
        studentBtn.onclick = function() {
            studentModal.style.display = "block";
        }
        teacherBtn.onclick = function() {
            teacherModal.style.display = "block";
        }
        parentBtn.onclick = function() {
            parentModal.style.display = "block";
        }

        adminClose.onclick = function() {
            adminModal.style.display = "none";
        }
        studentClose.onclick = function() {
            studentModal.style.display = "none";
        }
        teacherClose.onclick = function() {
            teacherModal.style.display = "none";
        }
        parentClose.onclick = function() {
            parentModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == adminModal) {
                adminModal.style.display = "none";
            }
            if (event.target == studentModal) {
                studentModal.style.display = "none";
            }
            if (event.target == teacherModal) {
                teacherModal.style.display = "none";
            }
            if (event.target == parentModal) {
                parentModal.style.display = "none";
            }
        }
    </script>
</body>
</html>