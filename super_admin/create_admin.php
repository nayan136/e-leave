
<?php
	require_once "sidebar.php";
	require_once "../db.php";
	$device_type = $_SESSION['device_type'];
 ?>
 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>
	<h2 class="center_text">Create Admin</h2>
	<form class="ui form segment" action="create_admin.php" method="post">
			<div class="field">
				<label>Username</label>
				<input type="text" name="admin_username">

			</div>

			<div class="field">
				<label>Password</label>
				<input type="Password" name="admin_password">

			</div>
			<div class="field">
				<label>Full Name</label>
				<input type="text" name="admin_name">

			</div>
			<div class="field">
				<label>Total CL</label>
				<input type="text" name="cl_left">
			</div>
			<div class="field">
				<label>Department</label>
				<input type="text" name="department">

			</div>


		<!-- 	<div class="field">
				<label>CL Left</label>
				<input type="text" name="cl_left">
			</div> -->
			<input type="submit" value="Create Admin" name="create_admin" class="fluid positive ui button">
		</form>



		<?php

			if(isset($_POST["create_admin"])){
				$cl_left = (float) $_POST["cl_left"];
				if(is_float($cl_left) && $cl_left > 0){
					$is_positive = true;
				}else{
					$is_positive = false;
				}
				if(!empty($_POST["admin_username"]) && !empty($_POST["admin_password"]) && !empty($_POST["department"]) &&
						!empty($cl_left) && $is_positive ){

					$username = $_POST["admin_username"];
					$password = $_POST["admin_password"];
					$name = $_POST["admin_name"];
					$department = $_POST["department"];

					$username = mysqli_real_escape_string($connection, $username);
					$password = mysqli_real_escape_string($connection, $password);
					$name = mysqli_real_escape_string($connection, $name);
					$department = mysqli_real_escape_string($connection, $department);

					$check_query = "SELECT * FROM admin WHERE username='$username' OR department='$department'";
					$check_user = mysqli_query($connection, $check_query);
					$found_user = mysqli_num_rows($check_user);

					if($found_user<1){
						$insert_query = "INSERT INTO admin ";
						$insert_query .="(username, admin_password, full_name, department, employee, privilege, cl_left) ";
						$insert_query .="VALUES('{$username}', '{$password}', '{$name}', '{$department}', '', 'admin','{$cl_left}')";
						$insert_to_datebase = mysqli_query($connection, $insert_query);
					}else{
						echo '<div class="ui negative message">User already exist</div>';
					}
					// if(!mysqli_affected_rows($insert_to_datebase)){
					// 	echo '<div class="ui negative message">databse error</div>';
					// }

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
