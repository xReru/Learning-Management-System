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
    $first_name = isset($_POST['first_name']) ? trim(htmlspecialchars($_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? trim(htmlspecialchars($_POST['last_name'])) : '';
    $phone_number = isset($_POST['phone_number']) ? trim(htmlspecialchars($_POST['phone_number'])) : '';
    $username = isset($_POST['username']) ? trim(htmlspecialchars($_POST['username'])) : '';
    $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
    $password = isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '';
    $Roles = isset($_POST['Roles']) ? trim(htmlspecialchars($_POST['Roles'])) : '';

    // Encrypt the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $sql = "INSERT INTO tbl_admin (fname, lname, phone, email, username, password, Role) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    
   if($stmt) 
   {

$stmt->bind_param("ssissss", $first_name, $last_name, $phone_number, $email, $username, $hashed_password, $Roles);
        
       
        if ($stmt->execute()) 
        {
            echo '<script>alert("Successfully Added"); 
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
?>
