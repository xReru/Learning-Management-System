<?php
include 'connect.php';
if(isset($_POST['add']) && isset($_FILES['fileToUpload'])){
	
	echo "<pre>";
	print_r($_FILES['fileToUpload']);
	echo "</pre>";
	//$sql1 = "Insert into tbl_aannouncements (e_name,e_action,e_date) values ('$name','Adding Announcement',NOW())";
	//$result1 = $config->query($sql1);
	$img_name = $_FILES['fileToUpload']['name'];
	$img_size = $_FILES['fileToUpload']['size'];
	$tmp_name = $_FILES['fileToUpload']['tmp_name'];
	$error = $_FILES['fileToUpload']['error'];



if ($error === 0) {
	if ($img_size > 12500000) {
		$em = "Sorry, your file is too large.";
		header("Location: announceview?error=$em");
	}else {
		$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
		$img_ex_lc = strtolower($img_ex);

		$allowed_exs = array("jpg", "jpeg", "png"); 

		if (in_array($img_ex_lc, $allowed_exs)) {
			$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
			$img_upload_path = '../uploads/'.$new_img_name;
			move_uploaded_file($tmp_name, $img_upload_path);

			// Insert into Database
			$create_title = $_POST['create_title'];
            $create_description = $_POST['create_description'];
			$create_date = $_POST['create_date'];
			$sql = "Insert into tbl_announcements (title,description,announcement_date, image) values  
			('$create_title','$create_description', $create_date, '$new_img_name')";
			$insert = $conn->query($sql);
			header("Location: announceview.php");
		}else {
			$em = "You can't upload files of this type";
			header("Location: addannouncement.php?error=$em");
		}
	}

// Display status message
echo $statusMsg;
if($insert == True){
?>
<script>
alert("Successfully Added")

</script>

<?php
header("refresh:0;url= addannouncement.php");
}else{
	echo $config->error;
}
  
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
    <style>
        
        #calendar-container {
            width: 100%;
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            position: relative;
            margin-left:20%;
        }

        /* Header Section */
        #calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        #todayContainer {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        #openCreateModal {
    position: absolute;
 
    background-color: #cc0b0b;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-left: 590px;
    margin-bottom: -48px;
}
     /* Modal Styles */
     .modal {
            display: none;
            position: fixed;
            z-index: 1000;
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
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }


        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        /* Form Styles in Modals */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 15px 0 8px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        textarea {
            resize: vertical;
            height: 120px;
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

        button[type="submits"] {
            background-color: #cc0b0b;
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

    </style>
</head>
<body>
<form method="POST" action="navs/nav.php">
<?php include_once 'navs/nav.php'; ?>
</form>


<div class="modal" id="createModal">
    <div class="modal-content">
        <span class="close" data-modal="createModal">&times;</span>
        <h2>Add Announcement</h2>
        <form method="POST" action="addannouncement.php" enctype="multipart/form-data"> 
            <label for="create_title">Title:</label>
            <input type="text" id="create_title" name="create_title" required><br>

            <label for="create_description">Description:</label>
            <textarea id="create_description" name="create_description" required></textarea><br>

            <label for="create_date">Date:</label>
            <input type="date" id="create_date" name="create_date" required><br>

    
            <label for="fileToUpload">Upload Image:</label>
            <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*"><br>

            <button type="submits" name="add">Create Announcement</button>
        </form>
    </div>
</div>

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

            <button type="submits" name="update">Update Announcement</button>
        </form>
    </div>
</div>


<!-- Delete Announcement Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <span class="close" data-modal="deleteModal">&times;</span>
        <h2>Delete Announcement</h2>
        <form id="deleteForm" method="POST" action="">
            <input type="hidden" id="delete_id" name="id">
            <p>Are you sure you want to delete this announcement?</p>
            <button type="submits" name="delete">Delete Announcement</button>
        </form>
    </div>
</div>
<div id="calendar-container">
    <div id="calendar-header">
        <button id="openCreateModal">Add Announcement</button>
    </div>

    <div id="calendar"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script>
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

            // Show the choice modal
            document.getElementById('choiceModal').style.display = 'block';
        }
    });
    calendar.render();

    // Modal handling
    var modals = document.querySelectorAll('.modal');
    var openCreateModalBtn = document.getElementById('openCreateModal');
    
    openCreateModalBtn.onclick = function() {
        document.getElementById('createModal').style.display = 'block';
    }

    document.querySelectorAll('.close').forEach(function(span) {
        span.onclick = function() {
            var modalId = this.getAttribute('data-modal');
            document.getElementById(modalId).style.display = 'none';
        }
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
    }
});
</script>
</body>
</html>
