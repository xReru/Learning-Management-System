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
        $name = $rowedit['lname'] . " " . $rowedit['lname'];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../images/logasac.png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .table-container {
            max-height: 400px;
            /* Set a height to make the data scrollable */
            overflow-y: auto;
            /* Enable vertical scrolling */
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #b40404;
            color: white;
            padding: 12px;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        td {
            padding: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Ensure it sits above everything else */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black with opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            /* Center modal */
            padding: 30px;
            /* Increased padding for better layout */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Subtle shadow for depth */
            width: 80%;
            /* Could be more or less, depending on screen size */
            max-width: 600px;
            /* Limit max width for larger screens */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Input and Label Styles */
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Padding for inputs */
            margin-top: 5px;
            /* Space above inputs */
            border: 1px solid #ddd;
            /* Border color */
            border-radius: 4px;
            /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for inputs */
        }

        /* Button Styles */
        button {
            padding: 10px 15px;
            /* Consistent padding */
            margin-top: 15px;
            /* Space above buttons */
            background-color: #b40404;
            /* Consistent color for buttons */
            color: white;
            /* Text color */
            border: none;
            border-radius: 5px;
            /* Rounded corners */
            cursor: pointer;
            /* Pointer on hover */
            transition: background-color 0.3s ease;
            /* Transition for button hover */
        }

        button:hover {
            background-color: #a30303;
            /* Darker shade on hover */
        }

        .toast {
            position: fixed;
            top: 5%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #219138;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            opacity: 1;
            transition: opacity 0.3s ease;
            z-index: 9999;
            /* Make sure it appears above other elements */
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <form action="logout.php" method="post">
        <?php include_once 'navs/nav.php'; ?>
    </form>

    <div class="main-content">
        <div class="header-content">
            <h1>Manage Classes / Sections</h1>
            <form method="GET" class="search-form">
                <div class="search-container">
                    <input type="text" class="search-bar" name="search" placeholder="Search section..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit" class="btn-search">Search</button>
                </div>
            </form>
        </div>

        <button class="btn" id="openModalBtn">Add New Section</button>
        <!-- Modal Structure -->
        <div id="sectionModal" class="modal">
            <div class="modal-content">
                <span id="closeModalBtn" class="close">&times;</span>
                <h2>Add Section</h2>
                <label for="section_name">Section Name:</label>
                <input type="text" id="section_name" required>

                <label for="section_code">Section Code:</label>
                <input type="text" id="section_code" required>

                <label for="section_grade">Grade Level:</label>
                <select id="section_grade" required>
                    <option value="">Select Grade Level</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>

                <button id="saveSectionBtn">Save Section</button>
                <button type="button" id="cancelBtn">Cancel</button>
            </div>
        </div>

        <div id="editSectionModal" class="modal">
            <div class="modal-content">
                <span id="closeEditModalBtn" class="close">&times;</span>
                <h2>Edit Section</h2>
                <input type="hidden" id="edit_section_id">

                <label for="edit_section_name">Section Name:</label>
                <input type="text" id="edit_section_name" required>

                <label for="edit_section_code">Section Code:</label>
                <input type="text" id="edit_section_code" required>

                <label for="edit_section_grade">Grade Level:</label>
                <select id="edit_section_grade" required>
                    <option value="">Select Grade Level</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>

                <button id="saveEditSectionBtn">Save Changes</button>
                <button type="button" id="cancelEditBtn">Cancel</button>
            </div>
        </div>
        <div class="table-container">
            <!-- Sections Table -->
            <div id="sectionsTable"></div>
        </div>
    </div>
    <script src="section_script.js"></script>
</body>

</html>