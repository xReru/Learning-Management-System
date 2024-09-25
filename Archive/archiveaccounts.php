<?php
include "../connect.php";





            if (isset($_POST['category'])) {
                $category = $_POST['category'];

                // Database connection parameters
                include '../connect.php'; // This should include your connection setup

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if ($category === 'admin') {
                    $sql = "SELECT Aid, username, fname, lname, email, phone FROM tbl_archive_admin";
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
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["username"]) . "</td>
                                    <td>" . htmlspecialchars($row["fname"]) . "</td>
                                    <td>" . htmlspecialchars($row["lname"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>
                                        <button type='button' class='btn-actions' onclick=\"window.location.href='restoreadmin.php?id=" . $row["Aid"] . "'\">Restore</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    echo "</tbody></table>";
                }
                if ($category === 'students') {
                    $sql = "SELECT SID, first_name, last_name, phone_number, email, address FROM tbl_archive_student";
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
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["address"]) . "</td>
                                    <td>
                                        <button type='button' class='btn-actions' onclick=\"window.location.href='restorestudent.php?id=" . $row["SID"] . "'\">Restore</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    echo "</tbody></table>";
                } 
                if ($category === 'teachers') 
                {
                    $sql = "SELECT TID, first_name, last_name, phone_number, email, address FROM tbl_archive_teacher";
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

                    if ($result->num_rows > 0) 
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["address"]) . "</td>
                                    <td>
                                        <button type='button' class='btn-actions' onclick=\"window.location.href='restoreteacher.php?id=" . $row["TID"] . "'\">Restore</button>
                                    </td>
                                </tr>";
                        }
                    } 
                    else
                    {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    echo "</tbody></table>";
                }
                if ($category === 'parents') 
                {
                    $sql = "SELECT PID, first_name, last_name, phone_number, email, address FROM tbl_archive_parent";
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

                    if ($result->num_rows > 0) 
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                    <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["address"]) . "</td>
                                    <td>
                                        <button type='button' class='btn-actions' onclick=\"window.location.href='restoreparents.php?id=" . $row["PID"] . "'\">Restore</button>
                                    </td>
                                </tr>";
                        }
                    } 
                    else
                    {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    echo "</tbody></table>";
                }
                // Close connection
                $conn->close();
            }