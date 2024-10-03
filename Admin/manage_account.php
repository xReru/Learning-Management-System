<?php
include "connect.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit;
}

$userid = $_SESSION['AID'] ?? null;
if ($userid) {
    $getrecord = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE AID ='$userid'");
    $rowedit = mysqli_fetch_assoc($getrecord);
    $type = $rowedit['Role'];
    $name = $rowedit['lname'] . " " . $rowedit['lname'];
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
    <?php include_once 'navs/nav.php'; ?>
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

        <!-- Add Admin Modal -->
        <div id="admin-modal" class="admin-modal">
            <div class="admin-content">
                <span class="close-add-admin">&times;</span>
                <h2>Add Admin Information</h2>
                <form id="addAdminForm">
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
                    <select id="Roles" name="Roles" value="Admin" hidden>
                        <option value="Admin">Admin</option>
                    </select>
                    <button type="submit">Add Admin</button>
                </form>
            </div>
        </div>

        <!-- Add Student Modal -->
        <div id="student-modal" class="student-modal">
            <div class="student-content">
                <span class="close-add-student">&times;</span>
                <h2>Add Student Information</h2>
                <form id="addStudentForm">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required>
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
                    <input type="Role" id="Role" name="Role" value="student" required hidden>
                    <button type="submit">Add Student</button>
                </form>
            </div>
        </div>

        <!-- Add Teacher Modal -->
        <div id="teacher-modal" class="teacher-modal">
            <div class="teacher-content">
                <span class="close-add-teacher">&times;</span>
                <h2>Add Teacher Information</h2>
                <form id="addTeacherForm">
                    <label for="teacherID">Teacher ID:</label>
                    <input type="text" id="teacherID" name="teacherID" required>
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
                    <input type="Role" id="Role" name="Role" value="teacher" required hidden>
                    <button type="submit">Add Teacher</button>
                </form>
            </div>
        </div>

        <!-- Add Parent Modal -->
        <div id="parent-modal" class="parent-modal">
            <div class="parent-content">
                <span class="close-add-parent">&times;</span>
                <h2>Add Parent Information</h2>
                <form id="addParentForm">
                    <label for="parentID">Parent ID:</label>
                    <input type="text" id="parentID" name="parentID" required>
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
                    <input type="Role" id="Role" name="Role" value="parent" required hidden>
                    <button type="submit">Add Parent</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="manage_account_modal.js"></script>
    <script type="text/javascript" src="account_modals.js"></script>
    <script>
        // Setup button listeners for updating and archiving users
        function setupButtonListeners() {
            const roles = ['admin', 'student', 'parent', 'teacher'];

            roles.forEach(role => {
                const updateBtns = document.querySelectorAll(`.update-btn-${role}`);
                updateBtns.forEach(button => {
                    button.addEventListener('click', function () {
                        const userId = button.getAttribute('data-id');
                        fetch(`fetch_user.php?category=${role}&id=${userId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Populate fields based on role
                                if (role === 'admin') {
                                    document.getElementById('AID').value = data.Aid;
                                    document.getElementById('adminID').value = data.Admin_ID;
                                    document.getElementById('adminFirstName').value = data.fname;
                                    document.getElementById('adminLastName').value = data.lname;
                                    document.getElementById('adminUsername').value = data.username;
                                    document.getElementById('adminEmail').value = data.email;
                                    document.getElementById('adminPhoneNumber').value = data.phone;
                                    updateAdminModal.style.display = "block";
                                } else if (role === 'student') {
                                    document.getElementById('SID').value = data.SID;
                                    document.getElementById('studentID').value = data.studentID;
                                    document.getElementById('studentFirstName').value = data.first_name;
                                    document.getElementById('studentLastName').value = data.last_name;
                                    document.getElementById('studentPhoneNumber').value = data.phone_number;
                                    document.getElementById('studentEmail').value = data.email;
                                    document.getElementById('studentAddress').value = data.address;
                                    updateStudentModal.style.display = "block";
                                } else if (role === 'parent') {
                                    document.getElementById('PID').value = data.PID;
                                    document.getElementById('parentID').value = data.parentID;
                                    document.getElementById('parentFirstName').value = data.first_name;
                                    document.getElementById('parentLastName').value = data.last_name;
                                    document.getElementById('parentPhoneNumber').value = data.phone_number;
                                    document.getElementById('parentEmail').value = data.email;
                                    document.getElementById('parentAddress').value = data.address;
                                    updateParentModal.style.display = "block";
                                } else if (role === 'teacher') {
                                    document.getElementById('TID').value = data.TID;
                                    document.getElementById('teacherID').value = data.teacherID;
                                    document.getElementById('teacherFirstName').value = data.first_name;
                                    document.getElementById('teacherLastName').value = data.last_name;
                                    document.getElementById('teacherPhoneNumber').value = data.phone_number;
                                    document.getElementById('teacherEmail').value = data.email;
                                    document.getElementById('teacherAddress').value = data.address;
                                    updateTeacherModal.style.display = "block";
                                }
                            });
                    });
                });
            });

            // Archive buttons
            const archiveButtons = document.querySelectorAll('.archive-btn');
            archiveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    userId = this.getAttribute('data-id');
                    userRole = this.getAttribute('data-role');
                    rowElement = this.closest('tr');
                    modal.style.display = 'block'; // Show confirmation modal
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupButtonListeners(); // Initial call to set up listeners

            const roles = ['admin', 'student', 'parent', 'teacher'];

            roles.forEach(role => {
                let roleIDKey = `${role.charAt(0).toUpperCase()}ID`;
                document.getElementById(`add${role.charAt(0).toUpperCase() + role.slice(1)}Form`).addEventListener("submit", function (event) {
                    event.preventDefault(); // Prevent normal form submission

                    const formData = new FormData(this);

                    fetch(`add_${role}.php`, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                let newRow;

                                if (role === 'admin') {
                                    newRow = `
                            <tr data-id='${data.Aid}'>
                                <td class='admin-username'>${data.username}</td>
                                <td class='admin-first-name'>${data.first_name}</td>
                                <td class='admin-last-name'>${data.last_name}</td>
                                <td class='admin-email'>${data.email}</td>
                                <td>
                                    <button type='button' class='update-btn-admin btn-actions' data-id='${data.Aid}'>Update</button>
                                    <button type='button' class='archive-btn btn-actions' data-id='${data.Aid}' data-role='admin'>Archive</button>
                                </td>
                            </tr>`;
                                } else if (role === 'student') {
                                    newRow = `
                            <tr data-id='${data.SID}'>
                                <td class='${role}-first-name'>${data.first_name}</td>
                                <td class='${role}-last-name'>${data.last_name}</td>
                                <td class='${role}-phone-number'>${data.phone_number}</td>
                                <td class='${role}-email'>${data.email}</td>
                                <td class='${role}-address'>${data.address}</td>
                                <td>
                                    <button type='button' class='update-btn-${role} btn-actions' data-id='${data[roleIDKey]}'>Update</button>
                                    <button type='button' class='archive-btn btn-actions' data-id='${data[roleIDKey]}' data-role='student'>Archive</button>
                                </td>
                            </tr>`;
                                } else if (role === 'teacher') {
                                    newRow = `
                            <tr data-id='${data.TID}'>
                                <td class='${role}-first-name'>${data.first_name}</td>
                                <td class='${role}-last-name'>${data.last_name}</td>
                                <td class='${role}-phone-number'>${data.phone_number}</td>
                                <td class='${role}-email'>${data.email}</td>
                                <td class='${role}-address'>${data.address}</td>
                                <td>
                                    <button type='button' class='update-btn-${role} btn-actions' data-id='${data[roleIDKey]}'>Update</button>
                                    <button type='button' class='archive-btn btn-actions' data-id='${data[roleIDKey]}' data-role='teacher'>Archive</button>
                                </td>
                            </tr>`;
                                } else if (role === 'parent') {
                                    newRow = `
                            <tr data-id='${data.PID}'>
                                <td class='${role}-first-name'>${data.first_name}</td>
                                <td class='${role}-last-name'>${data.last_name}</td>
                                <td class='${role}-phone-number'>${data.phone_number}</td>
                                <td class='${role}-email'>${data.email}</td>
                                <td class='${role}-address'>${data.address}</td>
                                <td>
                                    <button type='button' class='update-btn-${role} btn-actions' data-id='${data[roleIDKey]}'>Update</button>
                                    <button type='button' class='archive-btn btn-actions' data-id='${data[roleIDKey]}' data-role='parent'>Archive</button>
                                </td>
                            </tr>`;
                                }

                                const tableBody = document.querySelector(`#${role}Table tbody`);
                                tableBody.insertAdjacentHTML('beforeend', newRow);

                                setupButtonListeners(); // Reattach event listeners

                                showToast(`${role.charAt(0).toUpperCase() + role.slice(1)} added successfully`);

                                // Close the modal after successful submission
                                document.getElementById(`${role}-modal`).style.display = "none";
                            } else {
                                alert(`Failed to add ${role}`);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                });
            });
        });

        // Confirm archive action
        confirmButton.addEventListener('click', function () {
            fetch('archive_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `user_id=${userId}&role=${userRole}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(userRole.charAt(0).toUpperCase() + userRole.slice(1) + ' archived successfully');
                        rowElement.remove(); // Remove the archived row from the table
                    } else {
                        showToast('Failed to archive ' + userRole);
                    }
                    modal.style.display = 'none'; // Close modal
                })
                .catch(error => console.error('Error:', error));
        });

        // Cancel button click - close modal
        cancelButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    </script>
</body>

</html>