
<?php
		require_once "includes/sidebar.php";
		require_once("../db.php");

		$department = $_SESSION["department"];
		$device_type = $_SESSION['device_type'];
?>

<div class="one wide column">
</div>
	 <div class="eleven wide computer sixteen wide mobile column">
 <div class="container_margin">
	 <?php if($device_type === 'computer'){
		 echo "<br>";
	 } ?>
	<h2 class="center_text">Create User</h2>
	<form class="ui form segment" action="create_user.php" method="post">
			<div class="field">
				<label>Username</label>
				<div class="ui corner labeled input">
					<input type="text" name="create_username">
					 <div class="ui corner label">
				   	 	<i class="asterisk icon"></i>
				 	</div>
				</div>

			</div>

			<div class="field">
				<label>Password</label>
				<div class="ui corner labeled input">
					<input type="Password" name="create_password">
					 <div class="ui corner label">
				   	 	<i class="asterisk icon"></i>
				 	</div>
				</div>

			</div>
			<div class="field">
				<label>Full Name</label>
				<div class="ui corner labeled input">
					<input type="text" name="full_name">
					 <div class="ui corner label">
				   	 	<i class="asterisk icon"></i>
				 	</div>
				</div>

			</div>
				<div class="field">
				<label>Casual Leave</label>
				<div class="ui corner labeled input">
					<input type="number" name="cl_days">
					 <div class="ui corner label">
				   	 	<i class="asterisk icon"></i>
				 	</div>
				</div>

			</div>
			<div class="field">
				<label>Designation</label>
				<input type="text" name="designation">
			</div>

		<!-- 	<div class="field">
				<label>CL Left</label>
				<input type="text" name="cl_left">
			</div> -->
			<input type="submit" value="Create User" name="create_user" class="fluid positive ui button">
		</form>
</div>
<?php

	if(isset($_POST["create_user"])){
		if(!empty($_POST["create_username"])  && !empty($_POST["create_password"]) && !empty($_POST["full_name"]) && !empty($_POST["cl_days"])){
		$user_name = $_POST["create_username"];
		$password = $_POST["create_password"];
		$full_name = $_POST["full_name"];
		$cl_days = $_POST["cl_days"];
		$designation = $_POST["designation"];

		// $cl_left = $_POST["cl_left"];

		$user_name = mysqli_real_escape_string($connection, $user_name);
		$password = mysqli_real_escape_string($connection, $password);
		$full_name = mysqli_real_escape_string($connection, $full_name);
		$designation = mysqli_real_escape_string($connection, $designation);
		$cl_days = mysqli_real_escape_string($connection, $cl_days);
		$department = mysqli_real_escape_string($connection, $department);


		$query = "SELECT * FROM user WHERE username = '{$user_name}'";
		$check_user_exist = mysqli_query($connection, $query);
		$count = mysqli_num_rows($check_user_exist);
		if($count == 0){

			if(isset($user_name) && isset($password) && isset($full_name)){
				$query = "INSERT INTO user";
				$query .= "(username, user_password, full_name, designation, cl_left, privilege, department) ";
				$query .= "VALUES('{$user_name}', '{$password}', '{$full_name}', '{$designation}','{$cl_days}', 'general','{$department}')";

				$insert_user = mysqli_query($connection, $query);
			}

		if(mysqli_affected_rows($connection)){
			// get number of user by deprtment
			$total_user_by_depaertment = "SELECT COUNT(*) AS count FROM user WHERE department= '{$department}'";
			$get_total = mysqli_query($connection, $total_user_by_depaertment);
			while ($row = mysqli_fetch_assoc($get_total)) {
				$total_user = $row["count"];
			}
			// update employee in admin
			$update_admin_query = "UPDATE admin SET employee='{$total_user}' WHERE department='{$department}'";
			$update_admin = mysqli_query($connection, $update_admin_query);
		}
		}else{
			echo "User already exist";
		}
	}else{
		echo '<div class="ui negative message">Form is not completely filled</div>';
	}
}
 ?>

 	    </div>
	    </div>
	  </div>

	</div>

<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
