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



$result = $conn->query("SELECT * FROM tbl_announcements");
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['announcement_date'] 
    ];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement Calendar</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" href="../images/logasac.png">
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        #main-content {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            width: 100%;
            height: 100vh; /* Full screen height */
            margin-top: 5%;
            background-color: #fff;
        }
        #sidenav {
            width: 250px;  Fixed width for the sidenav */
            background-color: #333;
            color: white;
            display: block;
            transition: all 0.3s ease;
        }
        #calendar-container {
            flex-grow: 1; /* Allow calendar to take remaining space */
            padding: 25px;
            background-color: #fff;
            height: auto;
        }

        /* Header Section */
        #calendar-header {
            display: flex;
            justify-content: space-between;
            
        }
        #calendar{
            margin-top: 20px;
            background-color: #f9f9f9; 
            border: 1px;
            border-radius: 8px; 
            padding: 20px;
        }
        
        /* Hamburger menu styles */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 4px;
        }

        #openCreateModal {
            background-color: #cc0b0b;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            position: relative;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 400px;
            max-width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .close {
            color: #000;
            font-size: 24px;
            position: absolute;
            right: 15px;
            top: 10px;
            cursor: pointer;
        }

        .close:hover {
            color: #999;
        }

        /* Form Styles in Modals */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea,
        input[type="date"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin-top: 12px;
            transition: background-color 0.3s ease;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #cc0b0b;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #a80a0a;
        }

        /* Action Buttons in Choice Modal */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .action-buttons button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #284dff;
        }

        .delete-btn {
            background-color: #cc0b0b;
        }

        /* Media Queries for Responsive Design */
        @media screen and (max-width: 100%) { /* 1024px */
            #calendar-container {
                max-width: 90%; /* Reduce the max-width on smaller screens */
                margin-top: 10%;
            }

            #openCreateModal {
                margin-left: 10%;
            }

            .modal-content {
                width: 95%;
            }
        }

        @media screen and (max-width: 50%) {
            #main-content {
                flex-direction: column; /* Stack the sidenav and calendar vertically */
            }

            #sidenav {
                width: 100%; /* Full width sidenav */
            }

            #calendar-container {
                margin-top: 20%;
                width: 100%;
            }

            #openCreateModal {
                margin-left: 5%;
                padding: 10px 15px;
            }

            .modal-content {
                width: 90%;
            }
        }

        @media screen and (max-width: 30%) {
            .hamburger {
                display: flex;
            }

            #sidenav {
                width: 0;
                overflow: hidden;
            }

            #sidenav.show {
                width: 250px;
            }

            #calendar-header {
                margin-top: 0; /* Reset margin-top */
            }

            #calendar-container {
                margin-top: 0; /* Reset margin-top */
                height: 100vh; /* Full viewport height */
                padding: 0; /* Remove padding to utilize full height */
            }

            #calendar {
                margin-top: 0; /* Reset margin-top */
                height: calc(100vh - 50px); /* Adjust height to avoid overflow with header */
                padding: 20px; /* Keep some padding */
                overflow: auto; /* Allow scrolling if needed */
            }

            #openCreateModal {
                margin: 0 auto;
                display: block;
                padding: 8px 12px;
            }

            .modal-content {
                width: 90%;
            }

            button[type="submit"] {
                width: 100%;
            }
        }

    </style>
</head>
<body>
<div class="hamburger" onclick="toggleSidenav()">
        <div></div>
        <div></div>
        <div></div>
</div>
<div id="main-content">
        <nav id="sidenav">
            <?php include_once 'navs/nav.php'; ?>
        </nav>
        <div id="calendar-container">
            <div id="calendar-header">
                <button id="openCreateModal">Add Announcement</button>
            </div>
            <div id="calendar"></div>
        </div>
</div>

<div class="modal" id="createModal">
    <div class="modal-content">
        <span class="close" data-modal="createModal">&times;</span>
        <h2>Add Announcement</h2>
        <form method="POST" action="announceadd.php" enctype="multipart/form-data"> 
            <label for="create_title">Title:</label>
            <input type="text" id="create_title" name="create_title" required><br>

            <label for="create_description">Description:</label>
            <textarea id="create_description" name="create_description" required></textarea><br>

            <label for="create_date">Date:</label>
            <input type="date" id="create_date" name="create_date" required><br>

            <label for="fileToUpload">Upload Image:</label>
            <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*"><br>

            <button type="submit" name="add">Create Announcement</button>
        </form>
    </div>
</div>

<div class="modal" id="choiceModal">
    <div class="modal-content">
        <span class="close" data-modal="choiceModal">&times;</span>
        <h2>Choose Action</h2>
        <p>Do you want to update or delete this announcement?</p>
        <div class="action-buttons">
            <button id="updateChoiceBtn" class="edit-btn">Update</button>
            <button id="deleteChoiceBtn" class="delete-btn">Delete</button>
        </div>
    </div>
</div>

<div class="modal" id="updateModal">
    <div class="modal-content">
        <span class="close" data-modal="updateModal">&times;</span>
        <h2>Update Announcement</h2>
        <form id="updateForm" method="POST" action="updateannounce.php" enctype="multipart/form-data">
            <input type="hidden" id="update_id" name="id">
            <label for="update_title">Title:</label>
            <input type="text" id="update_title" name="update_title" required><br>

            <label for="update_description">Description:</label>
            <textarea id="update_description" name="update_description" required></textarea><br>

            <label for="update_date">Date:</label>
            <input type="date" id="update_date" name="update_date" required><br>

            <label for="fileToUpload">Upload New Image (optional):</label>
            <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*"><br>

            <button type="submit" name="update">Update Announcement</button>
        </form>
    </div>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-content">
        <span class="close" data-modal="deleteModal">&times;</span>
        <h2>Delete Announcement</h2>
        <form method="POST" action="deleteannouncement.php">
            <input type="hidden" id="delete_id" name="id">
            <p>Are you sure you want to archive this announcement?</p>
            <button type="submit" name="delete" class="btn btn-remove">Archive</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script>
function toggleSidenav() {
    var sidenav = document.getElementById('sidenav');
    sidenav.classList.toggle('show');
}
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode($events); ?>,
        eventClick: function(info) {
            var id = info.event.id;
            var title = info.event.title;
            var date = info.event.startStr;

            document.getElementById('update_id').value = id;
            document.getElementById('update_title').value = title;
            document.getElementById('update_date').value = date;
            document.getElementById('delete_id').value = id;

            document.getElementById('choiceModal').style.display = 'block';
        }
    });
    calendar.render();

    document.getElementById('openCreateModal').onclick = function() {
        document.getElementById('createModal').style.display = 'block';
    };

    document.querySelectorAll('.close').forEach(function(span) {
        span.onclick = function() {
            var modalId = this.getAttribute('data-modal');
            document.getElementById(modalId).style.display = 'none';
        };
    });

    document.getElementById('updateChoiceBtn').onclick = function() {
        document.getElementById('choiceModal').style.display = 'none';
        document.getElementById('updateModal').style.display = 'block';
    };

    document.getElementById('deleteChoiceBtn').onclick = function() {
        document.getElementById('choiceModal').style.display = 'none';
        document.getElementById('deleteModal').style.display = 'block';
    };

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    };
});
</script>
</body>
</html>