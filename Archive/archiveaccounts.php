<?php
include "../connect.php";

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Define table and id fields based on the category
    $tables = [
        'admin' => ['table' => 'tbl_archive_admin', 'id' => 'Aid', 'fields' => 'Aid, username, fname, lname, email, phone'],
        'student' => ['table' => 'tbl_archive_student', 'id' => 'SID', 'fields' => 'SID, first_name, last_name, phone_number, email, address'],
        'teacher' => ['table' => 'tbl_archive_teacher', 'id' => 'TID', 'fields' => 'TID, first_name, last_name, phone_number, email, address'],
        'parent' => ['table' => 'tbl_archive_parent', 'id' => 'PID', 'fields' => 'PID, first_name, last_name, phone_number, email, address']
    ];

    if (array_key_exists($category, $tables)) {
        $table = $tables[$category]['table'];
        $idField = $tables[$category]['id'];
        $fields = $tables[$category]['fields'];

        $sql = "SELECT $fields FROM $table";
        $result = $conn->query($sql);

        echo "<table>
                <thead>
                    <tr>";

        // Define table headers based on category
        if ($category === 'admin') {
            echo "<th>Username</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Action</th>";
        } else {
            echo "<th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone Number</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Action</th>";
        }

        echo "</tr>
              </thead>
              <tbody>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . htmlspecialchars($row[$idField]) . "'>";

                // Display fields based on category
                if ($category === 'admin') {
                    echo "<td>" . htmlspecialchars($row["username"]) . "</td>
                          <td>" . htmlspecialchars($row["fname"]) . "</td>
                          <td>" . htmlspecialchars($row["lname"]) . "</td>
                          <td>" . htmlspecialchars($row["email"]) . "</td>";
                } else {
                    echo "<td>" . htmlspecialchars($row["first_name"]) . "</td>
                          <td>" . htmlspecialchars($row["last_name"]) . "</td>
                          <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                          <td>" . htmlspecialchars($row["email"]) . "</td>
                          <td>" . htmlspecialchars($row["address"]) . "</td>";
                }

                // Action button (Restore)
                echo "<td>
                          <button type='button' class='btn-actions restore-btn' data-id='" . $row[$idField] . "' data-role='$category'>Restore</button>
                      </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }

        echo "</tbody></table>";
    }

    // Close connection
    $conn->close();
} ?>
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-header">Confirm Action</div>
        <div class="modal-body">Are you sure you want to restore this item?</div>
        <div class="modal-footer">
            <button id="confirmRestore" class="btn btn-confirm">Yes, Restore</button>
            <button id="cancelRestore" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>
<div class="toast" id="toastRestore" style="display:none;"></div>
<style>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const restoreButtons = document.querySelectorAll('.restore-btn');
        const modal = document.getElementById('confirmationModal');
        const confirmButton = document.getElementById('confirmRestore');
        const cancelButton = document.getElementById('cancelRestore');
        let userId, userRole, rowElement;

        // restore button click - open modal
        restoreButtons.forEach(button => {
            button.addEventListener('click', function () {
                userId = this.getAttribute('data-id');
                userRole = this.getAttribute('data-role');
                rowElement = this.closest('tr');
                modal.style.display = 'block'; // Show confirmation modal
            });
        });

        // Confirm restore action
        confirmButton.addEventListener('click', function () {
            fetch('restore_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `user_id=${userId}&role=${userRole}`
            })
                .then(response => {
                    // Check if response is ok (status in the range 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        showToastRestore(userRole + ' restored successfully');
                        rowElement.remove(); // Remove the archived row from the table
                    } else {
                        showToastRestore('Failed to restore user');
                    }
                    modal.style.display = 'none'; // Close modal
                })
                .catch(error => console.error('Error:', error));

        });


        // Cancel button click - close modal
        cancelButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close modal on 'x' click
        document.querySelector('.close-modal').addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal on clicking outside
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    });

    // Function to show toast message
    function showToastRestore(message) {
        const toast = document.getElementById('toastRestore');
        toast.textContent = message;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }
</script>