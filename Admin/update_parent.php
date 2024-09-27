<?php
	include "connect.php";

	$PID = $_GET['id'];
	$sql="SELECT * FROM tbl_parent WHERE PID = '$PID'
	";
	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	$studID = $row ['PID'];
	$fname = $row ['first_name'];
	$lname = $row ['last_name'];
	$lname = $row ['phone_number'];
	$address = $row ['address'];
	$email = $row ['email'];

		echo $conn->error;

?>
<!-- Modal Structure -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <h4>Update Information</h4>
        <form id="updateForm" method="POST">
            <input type="hidden" name="ids" id="userId">
            <div>
                <label>First Name:</label>
                <input type="text" name="firstname" id="firstname">
            </div>
            <div>
                <label>Last Name:</label>
                <input type="text" name="lastname" id="lastname">
            </div>
            <div>
                <label>Phone:</label>
                <input type="text" name="phone" id="phone">
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label>Address:</label>
                <input type="text" name="address" id="address">
            </div>
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</div>

<?php
include "connect.php";

		if(isset($_POST['update']))
		{
		$ids = $_POST['ids'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$addresses = $_POST['addresses'];
		$email = $_POST['email'];

		$sql = "UPDATE tbl_parent SET first_name ='$firstname', last_name ='$lastname', address= '$addresses' , email='$email' 
		WHERE PID ='$ids'";

		$result = $conn->query($sql);

		if($result == True)
		{
		?>
		<?php
		header("refresh:0;url=manage_account.php");
		}
		else
		{
			echo $conn->error;
		}
	}
?>

