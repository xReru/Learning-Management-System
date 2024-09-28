<?php
if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Database connection parameters
    include 'connect.php'; // This should include your connection setup

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($category === 'admin') {
        $sql = "SELECT Aid, username, fname, lname, email, phone FROM tbl_admin";
        $result = $conn->query($sql);

        echo "<table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['Aid'] . "'>
                <td class='admin-username'>" . htmlspecialchars($row["username"]) . "</td>
                <td class='admin-first-name'>" . htmlspecialchars($row["fname"]) . "</td>
                <td class='admin-last-name'>" . htmlspecialchars($row["lname"]) . "</td>
                <td class='admin-email'>" . htmlspecialchars($row["email"]) . "</td>
                <td>
                    <button type='button' class='update-btn-admin btn-actions' data-id='" . $row['Aid'] . "'>Update</button>
                    <button type='button' class='btn-actions' onclick=\"window.location.href='delete_teacher.php?id=" . $row['Aid'] . "'\">Archive</button>
                </td>
            </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }

        echo "</tbody></table>";
    }
    if ($category === 'students') {
        $sql = "SELECT SID, first_name, last_name, phone_number, email, address FROM tbl_student";
        $result = $conn->query($sql);

        echo "<table>
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['SID'] . "'>
                        <td class='student-first-name'>" . htmlspecialchars($row["first_name"]) . "</td>
                        <td class='student-last-name'>" . htmlspecialchars($row["last_name"]) . "</td>
                        <td class='student-phone-number'>" . htmlspecialchars($row["phone_number"]) . "</td>
                        <td class='student-email'>" . htmlspecialchars($row["email"]) . "</td>
                        <td class='student-address'>" . htmlspecialchars($row["address"]) . "</td>
                        <td>
                            <button type='button' class='update-btn-student btn-actions' data-id='" . $row['SID'] . "'>Update</button>
                            <button type='button' class='btn-actions' onclick=\"window.location.href='delete_teacher.php?id=" . $row['SID'] . "'\">Archive</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }

        echo "</tbody></table>";
    }
    if ($category === 'teachers') {
        $sql = "SELECT TID, first_name, last_name, phone_number, email, address FROM tbl_teacher";
        $result = $conn->query($sql);

        echo "<table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['TID'] . "'>
                        <td class='teacher-first-name'>" . htmlspecialchars($row["first_name"]) . "</td>
                        <td class='teacher-last-name'>" . htmlspecialchars($row["last_name"]) . "</td>
                        <td class='teacher-phone-number'>" . htmlspecialchars($row["phone_number"]) . "</td>
                        <td class='teacher-email'>" . htmlspecialchars($row["email"]) . "</td>
                        <td class='teacher-address'>" . htmlspecialchars($row["address"]) . "</td>
                        <td>
                            <button type='button' class='update-btn-teacher btn-actions' data-id='" . $row['TID'] . "'>Update</button>
                            <button type='button' class='btn-actions' onclick=\"window.location.href='delete_teacher.php?id=" . $row['TID'] . "'\">Archive</button>
                        </td>
                    </tr>";
            }
        }

        echo "</tbody>
            </table>";
    }
    if ($category === 'parents') {
        $sql = "SELECT PID, first_name, last_name, phone_number, email, address FROM tbl_parent";
        $result = $conn->query($sql);

        echo "<table>
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['PID'] . "'>
                        <td class='parent-first-name'>" . htmlspecialchars($row["first_name"]) . "</td>
                        <td class='parent-last-name'>" . htmlspecialchars($row["last_name"]) . "</td>
                        <td class='parent-phone-number'>" . htmlspecialchars($row["phone_number"]) . "</td>
                        <td class='parent-email'>" . htmlspecialchars($row["email"]) . "</td>
                        <td class='parent-address'>" . htmlspecialchars($row["address"]) . "</td>
                        <td>
                            <button type='button' class='update-btn-parent btn-actions' data-id='" . $row['PID'] . "'>Update</button>
                            <button type='button' class='btn-actions' onclick=\"window.location.href='delete_teacher.php?id=" . $row['PID'] . "'\">Archive</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        echo "</tbody></table>";
    }

    // Close connection
    $conn->close();
}
?>
<style>
    .toast {
        position: fixed;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #219138;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        opacity: 0.8;
        transition: opacity 0.3s ease;
        z-index: 9999;
        /* Make sure it appears above other elements */
    }
</style>
<!-- Teacher Modal -->
<div id="updateTeacherModal" class="modal updateTeacherModal">
    <div class="modal-content">
        <span class="close-teacher">&times;</span>
        <form id="updateTeacherForm" method="POST" action="update_teacher.php">
            <input type="hidden" name="TID" id="TID" value="">

            <label for="teacher_id">Teacher ID:</label>
            <input type="text" name="teacherID" id="teacherID" value="">

            <label for="teacher_first_name">First Name:</label>
            <input type="text" name="first_name" id="teacherFirstName" value="">

            <label for="teacher_last_name">Last Name:</label>
            <input type="text" name="last_name" id="teacherLastName" value="">

            <label for="teacher_address">Address:</label>
            <input type="text" name="teacher_address" id="teacherAddress" value="">

            <label for="teacher_email">Email:</label>
            <input type="email" name="email" id="teacherEmail" value="">

            <label for="teacher_phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="teacherPhoneNumber" value="">

            <button type="submit">Update Teacher</button>
        </form>
    </div>
</div>

<!-- Student Modal -->
<div id="updateStudentModal" class="modal updateStudentModal">
    <div class="modal-content">
        <span class="close-student">&times;</span>
        <form id="updateStudentForm" method="POST" action="update_student.php">
            <input type="hidden" name="SID" id="SID" value="">

            <label for="student_id">Student ID:</label>
            <input type="text" name="studentID" id="studentID" value="">

            <label for="student_first_name">First Name:</label>
            <input type="text" name="first_name" id="studentFirstName" value="">

            <label for="student_last_name">Last Name:</label>
            <input type="text" name="last_name" id="studentLastName" value="">

            <label for="student_address">Address:</label>
            <input type="text" name="student_address" id="studentAddress" value="">

            <label for="student_email">Email:</label>
            <input type="email" name="email" id="studentEmail" value="">

            <label for="student_phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="studentPhoneNumber" value="">

            <button type="submit">Update Student</button>
        </form>
    </div>
</div>

<!-- Parent Modal -->
<div id="updateParentModal" class="modal updateParentModal">
    <div class="modal-content">
        <span class="close-parent">&times;</span>
        <form id="updateParentForm" method="POST" action="update_parent.php">
            <input type="hidden" name="PID" id="PID" value="">

            <label for="parent_id">Parent ID:</label>
            <input type="text" name="parentID" id="parentID" value="">

            <label for="parent_first_name">First Name:</label>
            <input type="text" name="first_name" id="parentFirstName" value="">

            <label for="parent_last_name">Last Name:</label>
            <input type="text" name="last_name" id="parentLastName" value="">

            <label for="parent_address">Parent Address:</label>
            <input type="text" name="parent_address" id="parentAddress" value="">

            <label for="parent_email">Email:</label>
            <input type="email" name="email" id="parentEmail" value="">

            <label for="parent_phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="parentPhoneNumber" value="">

            <button type="submit">Update Parent</button>
        </form>
    </div>
</div>

<!-- Admin Modal -->
<div id="updateAdminModal" class="modal updateAdminModal">
    <div class="modal-content">
        <span class="close-admin">&times;</span>
        <form id="updateAdminForm" method="POST" action="update_admin.php">
            <input type="hidden" name="AID" id="AID" value="">

            <label for="admin_id">Admin ID:</label>
            <input type="text" name="adminID" id="adminID" value="">

            <label for="admin_first_name">First Name:</label>
            <input type="text" name="first_name" id="adminFirstName" value="">

            <label for="admin_last_name">Last Name:</label>
            <input type="text" name="last_name" id="adminLastName" value="">

            <label for="admin_username">Admin Username:</label>
            <input type="text" name="admin_username" id="adminUsername" value="">

            <label for="admin_email">Email:</label>
            <input type="email" name="email" id="adminEmail" value="">

            <label for="admin_phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="adminPhoneNumber" value="">

            <button type="submit">Update Admin</button>
        </form>
    </div>
</div>
<div id="toast" class="toast" style="display:none;"></div>
<script src="account_modals.js"></script>