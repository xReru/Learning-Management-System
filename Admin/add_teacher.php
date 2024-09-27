<?php
//connection
require_once "connect.php";

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Get and sanitize input data
    $teacher_id = isset($_POST['teacherID']) ? trim(htmlspecialchars($_POST['teacherID'])) : '';
    $first_name = isset($_POST['first_name']) ? trim(htmlspecialchars($_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? trim(htmlspecialchars($_POST['last_name'])) : '';
    $phone_number = isset($_POST['phone_number']) ? trim(htmlspecialchars($_POST['phone_number'])) : '';
    $address = isset($_POST['address']) ? trim(htmlspecialchars($_POST['address'])) : '';
    $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
    $password = isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '';
    $Role = isset($_POST['Role']) ? trim(htmlspecialchars($_POST['Role'])) : '';

    // Prepare the SQL statement
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO tbl_teacher (first_name, last_name, phone_number, address, email, password,Role) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    
   if($stmt) 
   {
        // Bind the input data
        $stmt->bind_param("ssissss", $first_name,$last_name,$phone_number,$address,$email,$hashed_password,$Role);
        
        // Execute the statement
        if ($stmt->execute()) 
        {
            echo '<script>alert("Sucessfully Added"); 
            window.location.href = "manage_account.php"</script>';
            exit();
        
        } 
        else 
        {
            echo "Error: " . $stmt->error;
        }
    }
    else 
    {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
}

