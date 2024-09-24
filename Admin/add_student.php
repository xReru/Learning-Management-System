<?php
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$sql = "INSERT INTO tbl_student (first_name, last_name, phone_number, address, email, password, Role) VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);

if($stmt) 
{
    // Bind the input data, using $hashed_password instead of $password
    $stmt->bind_param("ssissss", $first_name, $last_name, $phone_number, $address, $email, $hashed_password, $Role);
    
    // Execute the statement
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
?>