<?php
include "connect.php";

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['sign'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Assume role is selected via the login form

    // Determine the correct table based on the selected role
    switch ($role) {
        case 'student':
            $table = 'tbl_student';
            $id_column = 'SID';
            break;
        case 'teacher':
            $table = 'tbl_teacher';
            $id_column = 'TID';
            break;
        case 'parent':
            $table = 'tbl_parent';
            $id_column = 'PID';
            break;
        default:
            die('Invalid role selected.');
    }

    // Query to fetch user based on the role
    $viewlogin = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($viewlogin);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbpassword = $row['password'];
        $failed_attempts = $row['failed_attempts'];
        $lockout_until = $row['lockout_until'];

        $current_time = new DateTime();
        $lockout_time = $lockout_until ? new DateTime($lockout_until) : null;

        if ($lockout_until && $lockout_time && $current_time < $lockout_time) {
            $remaining_time = $lockout_time->getTimestamp() - $current_time->getTimestamp();
            $_SESSION['lockout_until'] = $lockout_until;
            echo "<script>alert('You are locked out. Please try again later.');</script>";
        } else {
            if (password_verify($password, $dbpassword)) {
                // Reset failed attempts and lockout time
                $updateQuery = "UPDATE $table SET failed_attempts = 0, lockout_until = NULL WHERE email = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("s", $username);
                $updateStmt->execute();

                $_SESSION[$id_column] = $row[$id_column];
                $_SESSION['username'] = $username;
                $_SESSION['Role'] = $role;
                $_SESSION['loggedin'] = true;

                // Redirect to role-specific dashboard
                header("Location: ${role}_dashboard.php");
                exit();
            } else {
                $failed_attempts++;
                if ($failed_attempts >= 3) {
                    $lockout_time = $current_time->add(new DateInterval('PT1M'));
                    $lockout_until = $lockout_time->format('Y-m-d H:i:s');
                    $updateQuery = "UPDATE $table SET failed_attempts = ?, lockout_until = ? WHERE email = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("iss", $failed_attempts, $lockout_until, $username);
                    $updateStmt->execute();
                    echo "<script>alert('You are locked out. Please try again in 1 minute.');</script>";
                } else {
                    $updateQuery = "UPDATE $table SET failed_attempts = ? WHERE email = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("is", $failed_attempts, $username);
                    $updateStmt->execute();
                    echo "<script>alert('Incorrect password. Attempt $failed_attempts of 3.');</script>";
                }
            }
        }
    } else {
        echo "<script>alert('Username not registered.');</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" href="images/logasac.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
              body {
            width: 100%;
            height: 100vh;
            background-image: url("images/cover.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Existing styles */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            background-color: gray;
            width: 100px;

            border-radius: 25px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border: none;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: darkgray;
        }

        .forgot-password {
            color: #5d6d7e;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .exit-logo {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 30px;
            font-weight: bold;
            color: #000;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.7);
            padding: 5px 10px;
            border-radius: 50%;
            transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .exit-logo:hover {
            color: #ff0000;
            background: rgba(255, 255, 255, 0.9);
        }

        .exit-logo:active {
            transform: scale(0.95);
        }

        .countdown {
            margin-top: 10px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-lg-6 d-none d-lg-block illustration-container">
                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <img src="images/logasac.png" class="img-fluid" alt="Logo" style="max-width: 230px;">
                    <p class="illustration-text mt-4">ACADEMY OF SAINT ANDREW CALOOCAN (ASAC), INC.</p>
                    <p class="illustration-subtext">Learning Management System</p>
                </div>
            </div>

            <div class="col-lg-6 login-form-container d-flex align-items-center justify-content-center position-relative">
                <a href="index.php" class="exit-logo">&times;</a>
                <div class="w-75">
                    <h1 class="brand-name">ASAC LMS</h1>
                    <h3 class="welcome-text">Users Login</h3>
                    <form method="POST" action="login.php">
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" class="form-control custom-input" name="username" id="username" placeholder="Enter your username" required>
    </div>
    
    <div class="mb-3">
    <label for="password">Password</label>
    <input type="password" class="form-control custom-input" name="password" id="password" placeholder="Enter your password" required>
    <input type="checkbox" class="form-check-input" id="showPassword"> Show Password
</div>

    <!-- Role selection -->
    <div class="mb-3">
        <label for="role">Login as:</label>
        <select name="role" id="role" class="form-select custom-select">
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="parent">Parent</option>
        </select>
    </div>

    <div style="text-align:center; margin-top: 10px;">
        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="forgot-password">Forgot Password?</a>
        <button type="submit" class="btn" name="sign">Sign in</button>
        <div id="countdown" class="countdown"></div>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>No worries. We'll send you reset instructions.</p>
                    <form method="POST" action="forgot_password.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function startCountdown(duration) {
            var countdownElement = document.getElementById('countdown');
            var endTime = Date.now() + duration * 1000;

            function updateCountdown() {
                var remainingTime = Math.max(0, endTime - Date.now());
                var seconds = Math.floor((remainingTime / 1000) % 60);
                var minutes = Math.floor((remainingTime / (1000 * 60)) % 60);
                var hours = Math.floor((remainingTime / (1000 * 60 * 60)) % 24);

                if (remainingTime <= 0) {
                    countdownElement.textContent = '';
                    return;
                }

                countdownElement.textContent = 
                    (hours > 0 ? hours + 'h ' : '') +
                    (minutes > 0 ? minutes + 'm ' : '') +
                    seconds + 's';
                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        }
        const passwordInput = document.getElementById("password");
    const showPasswordCheckbox = document.getElementById("showPassword");

    showPasswordCheckbox.onchange = function() {
        passwordInput.type = showPasswordCheckbox.checked ? "text" : "password";
    };
    </script>
</body>

</html>

