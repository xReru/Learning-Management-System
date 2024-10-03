<?php
include "connect.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("refresh:0; ../login.php");
    exit;
} else if (isset($_SESSION['Aid'])) {
    $userid = $_SESSION['Aid'];
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE Aid ='$userid'");
    $rowedit = mysqli_fetch_assoc($getrecord);
    $type = $rowedit['Role'];
    $name = $rowedit['fname'] . " " . $rowedit['lname'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css_admin/dash.css">
    <style>
        .sidebar {
            width: 230px;
            height: 100vh;
            background-color: #313131;
            color: #ffffff;
            padding: 20px 20px;
            box-shadow: 0px 5px 10px rgb(0, 0, 0);
            position: fixed;
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            /* Prevent horizontal scrolling */
            top: 70px;
        }


        .sidebar::-webkit-scrollbar {
            width: 0px;
            /* Hide scrollbar */
            background: transparent;
            /* Optional: just to be sure */
        }

        /* Hide scrollbar for Firefox */
        .sidebar {
            scrollbar-width: none;
            /* Hide scrollbar */
        }

        /* Sidebar Navigation List */
        .nav-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }


        /* Main Content Area */
        .main-content {
            margin-left: 230px;
            /* Offset by sidebar width */
            padding: 20px;
        }

        /* Logo Container */
        .logo-container {
            text-align: left;
            margin-bottom: 30px;
        }

        /* Logo Styling */
        .logo1 {
            width: 60px;
            height: 60px;
            margin-top: 0;
            padding-bottom: 10px;
        }

        /* Text Styling */
        .text {
            font-size: 13px;
            padding-left: 10px;
            padding-bottom: 10px;
        }

        /* Sidebar when collapsed */
        .sidebar.collapsed {
            width: 70px;
        }

        /* Sidebar Navigation List */
        .nav-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        /* Sidebar Navigation Item */
        .nav-item {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateX(-50%);
            animation: fadeInSlide 0.4s forwards;
            animation-delay: calc(0.1s * var(--li-index));
        }

        /* Sidebar Link */
        .nav-link {
            text-decoration: none;
            color: #f0f0f0;
            display: flex;
            align-items: center;
            font-size: 15px;
            padding: 10px 10px;
            background-color: rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s, color 0.3s, padding 0.3s;
        }

        /* Sidebar Link when collapsed */
        .sidebar.collapsed .nav-link {
            padding: 12px;
            justify-content: center;
        }

        /* Sidebar Link 1 */
        .nav-link1 {
            display: flex;
        }

        /* Icon Style */
        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 15px;
            transition: transform 0.3s;
        }

        /* Icon Style when collapsed */
        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        /* Hide text when sidebar is collapsed */
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* Hover Effects */
        .nav-link:hover {
            background-color: #575b71;
            color: #ffffff;
            cursor: pointer;
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }

        /* Keyframe Animations */
        @keyframes fadeInSlide {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Media Query for Small Screens */
        @media screen and (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        .logoutModal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 9999999;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            display: flex;
            /* Use flexbox */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
        }

        .logoutModal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            /* Maximum width of the modal */
            border-radius: 5px;
            /* Rounded corners */
        }

        .button-container-logout {
            display: flex;
            justify-content: center;
            /* Center the buttons horizontally */
            margin-top: 20px;
            /* Optional: Add some space above the buttons */
        }

        /* Close Button */
        .closeLogout {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .closeLogout:hover,
        .closeLogout:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-logout {
            padding: 10px 20px;
            /* Button padding */
            margin: 0 10px;
            /* Space between buttons */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-confirm-logout {
            background-color: #4CAF50;
            /* Green */
            color: white;
        }

        .btn-cancel-logout {
            background-color: #f44336;
            /* Red */
            color: white;
        }
    </style>

<body>
    <header class="header">
        <p style="color: #fff;"><?php echo htmlspecialchars($type); ?> | <?php echo htmlspecialchars($name); ?></p>
        <div class="logout">
            <button type="button" class="logout-button" id="logoutBtn">Logout</button>
        </div>
    </header>
    <aside class="sidebar">
        <ul class="nav-list">

            <a class="nav-link1">
                <img src="../photos/logo.png" alt="Logo" class="logo1">
                <h1 class="text">ACADEMY OF SAINT ANDREW CALOOCAN (ASAC), INC. </h1>
            </a>



            <li class="nav-item" style="--li-index: 1;">
                <a href="dashboard.php" class="nav-link">
                    <img src="../photos/dashboard.png" alt="Dashboard Icon" class="nav-icon">
                    Dashboard
                </a>
            </li>
            <li class="nav-item" style="--li-index: 2;">
                <a href="manage_account.php" class="nav-link">
                    <img src="../photos/account.png" alt="Accounts Icon" class="nav-icon">
                    Accounts
                </a>
            </li>
            <li class="nav-item" style="--li-index: 3;">
                <a href="manage_courses.php" class="nav-link">
                    <img src="../photos/courses.png" alt="Courses Icon" class="nav-icon">
                    Courses
                </a>
            </li>
            <li class="nav-item" style="--li-index: 4;">
                <a href="manage_classes.php" class="nav-link">
                    <img src="../photos/class.png" alt="Classes Icon" class="nav-icon">
                    Classes
                </a>
            </li>
            <li class="nav-item" style="--li-index: 5;">
                <a href="manage_subject.php" class="nav-link">
                    <img src="../photos/book.png" alt="Group Chat Icon" class="nav-icon">
                    Subjects
                </a>
            </li>
            <li class="nav-item" style="--li-index: 6;">
                <a href="events.php" class="nav-link">
                    <img src="../photos/event.png" alt="Events Icon" class="nav-icon">
                    Events
                </a>
            </li>
            <li class="nav-item" style="--li-index: 7;">
                <a href="addannouncement.php" class="nav-link">
                    <img src="../photos/announcement.png" alt="Announcements Icon" class="nav-icon">
                    Announcements
                </a>
            </li>
            <li class="nav-item" style="--li-index: 8;">
                <a href="../Archive/archive.php" class="nav-link">
                    <img src="../photos/archive.png" alt="Announcements Icon" class="nav-icon">
                    Archive
                </a>
            </li>

            <br>
        </ul>
    </aside>
    <!-- Confirmation Modal -->
    <div id="logoutModal" class="logoutModal" aria-hidden="true">
        <div class="logoutModal-content">
            <span class="closeLogout" id="closeLogModal">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to log out?</p>
            <form id="logoutForm" action="logout.php" method="post">
                <div class="button-container-logout">
                    <button type="submit" name='logout' class="btn-logout btn-confirm-logout">Yes, Logout</button>
                    <button type="button" class="btn-logout btn-cancel-logout" id="cancelBtnLogout">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        var logoutModal = document.getElementById("logoutModal");

        // Get the button that opens the modal
        var logoutBtn = document.getElementById("logoutBtn");

        // Get the <span> element that closes the modal
        var logoutSpan = document.getElementById("closeLogModal");

        // Get the cancel button
        var cancelBtnLogout = document.getElementById("cancelBtnLogout");

        // Ensure the modal is initially hidden
        logoutModal.style.display = "none"; // Ensure modal starts hidden

        // When the user clicks the logout button, open the modal
        logoutBtn.onclick = function () {
            logoutModal.style.display = "flex"; // Use 'flex' to show the modal
            logoutModal.setAttribute("aria-hidden", "false");
        }

        logoutSpan.onclick = function () {
            logoutModal.style.display = "none"; // Hide the modal
            logoutModal.setAttribute("aria-hidden", "true");
        }

        cancelBtnLogout.onclick = function () {
            logoutModal.style.display = "none"; // Hide the modal
            logoutModal.setAttribute("aria-hidden", "true");
        }

        window.onclick = function (event) {
            if (event.target === logoutModal) {
                logoutModal.style.display = "none"; // Hide the modal
                logoutModal.setAttribute("aria-hidden", "true");
            }
        }

    </script>



</body>

</html>