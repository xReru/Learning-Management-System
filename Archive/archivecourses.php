<?php
include "../connect.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses / Strand</title>
    <link rel="stylesheet" type="text/css" href="../Admin/styles.css">
    <link rel="icon" href="../images/logasac.png">
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        position: relative;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th {
        background-color: #b40404;
        color: white;
        padding: 12px;
        text-align: left;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    td {
        padding: 12px;
        text-align: left;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
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
    /* Modal container */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
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

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
        max-width: 500px;
        /* Set a max width for larger screens */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    /* Modal header */
    .modal-header {
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    /* Modal body */
    .modal-body {
        padding: 20px 10px;
        font-size: 16px;
        color: #555;
    }

    /* Modal footer */
    .modal-footer {
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Buttons inside modal */
    .modal-footer .btn {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        border: none;
    }

    /* Confirm button */
    .btn-confirm {
        background-color: #28a745;
        color: white;
    }

    .btn-confirm:hover {
        background-color: #218838;
    }

    /* Cancel button */
    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    /* Close button (X) in the modal */
    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<body>
    <form action="logouts.php" method="post">
        <?php include_once 'van.php'; ?>
    </form>

    <div class="main-content">
        <div class="header-content">
            <h1>Manage Courses / Strand</h1>
            <form method="GET" class="search-form">
                <input type="text" class="search-bar" name="search" placeholder="Search courses..."
                    value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <!-- Confirmation Modal -->
        <div id="removeConfirmationModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Confirm Restore</h2>
                    <span id="closeRemoveModalBtn">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to restore this course?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-close" id="cancelRemoveBtn">Cancel</button>
                    <button class="btn-restore" id="confirmRestoreBtn">Restore</button>
                </div>
            </div>
        </div>

        <div class="table-container">
            <?php
            include '../connect.php';

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve search input
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            // SQL query with search condition
            if ($search) {
                $sql = "SELECT * FROM archive_courses WHERE course_name LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM archive_courses";
            }

            $result = mysqli_query($conn, $sql);

            // Display list of courses
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Course Name</th><th>Course Description</th><th>Course Code</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id='" . htmlspecialchars($row["course_id"]) . "'>";
                    echo "<td>" . htmlspecialchars($row["course_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["course_description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["course_code"]) . "</td>";
                    echo "<td>";
                    echo "<button class='btn restore-btn' data-id='" . $row["course_id"] . "'>Restore</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No courses found.</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastRestore" class="toast" style="display:none;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const restoreButtons = document.querySelectorAll('.restore-btn');
            const modal = document.getElementById('removeConfirmationModal');
            const confirmButton = document.getElementById('confirmRestoreBtn');
            const cancelButton = document.getElementById('cancelRemoveBtn');
            let courseId, rowElement;

            // Open confirmation modal
            restoreButtons.forEach(button => {
                button.addEventListener('click', function () {
                    courseId = this.getAttribute('data-id');
                    rowElement = this.closest('tr');
                    modal.style.display = 'block'; // Show modal
                });
            });

            // Confirm restore action
            confirmButton.addEventListener('click', function () {
                fetch('restorecourses.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `course_id=${courseId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToastRestore('Course restored successfully');
                        rowElement.remove(); // Remove restored row
                    } else {
                        showToastRestore('Failed to restore course');
                    }
                    modal.style.display = 'none'; // Close modal
                })
                .catch(error => console.error('Error:', error));
            });

            // Close modal on cancel
            cancelButton.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Close modal on 'x' click
            document.querySelector('#closeRemoveModalBtn').addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });

        // Toast notification function
        function showToastRestore(message) {
            const toast = document.getElementById('toastRestore');
            toast.textContent = message;
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }
    </script>
</body>

</html>
