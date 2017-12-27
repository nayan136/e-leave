<?php

	require_once "sidebar.php";
	require_once "../db.php";
	$device_type = $_SESSION['device_type'];

	if(isset($_GET["admin_id"])){
		$admin_id = $_GET["admin_id"];
		//$admin_id = $_GET["admin_id"];
		$query_user = "SELECT username, admin_password, full_name FROM admin WHERE id='{$admin_id}'";
		$get_user_details = mysqli_query($connection, $query_user);
		while ($row = mysqli_fetch_assoc($get_user_details)) {
			$username = $row["username"];
			$password = $row["admin_password"];
			$name = $row["full_name"];
		}
	}

	if(isset($_POST["edit_admin"])){

		$username = $_POST["edit_username"];
		$password = $_POST["edit_password"];
		$name = $_POST["edit_name"];

		if(!empty($username) && !empty($password) && !empty($name)){

		$username = mysqli_real_escape_string($connection, $username);
		$password = mysqli_real_escape_string($connection, $password);
		$name = mysqli_real_escape_string($connection, $name);

		$query = "UPDATE admin SET username='{$username}', admin_password='{$password}', full_name='{$name}' WHERE id='{$admin_id}'";
		$update_admin = mysqli_query($connection, $query);

		header("Location:admin_list.php");
		die();

		}


	}



?>
<div class="one wide column">
</div>
	 <div class="eleven wide computer sixteen wide mobile column">
 <div class="container_margin">
	 <?php if($device_type === 'computer'){
		 echo "<br>";
	 } ?>
	<h2 class="center_text">Edit Admin</h2>
	<form class="ui form segment" action="edit_admin.php?admin_id=<?php echo $admin_id ?>" method="post">
			<div class="field">
				<label>Username</label>
				<input type="text" name="edit_username" <?php echo "value='".$username."'";  ?>>

			</div>

			<div class="field">
				<label>Password</label>
				<input type="text" name="edit_password" <?php echo "value='".$password."'";  ?>>

			</div>
			<div class="field">
				<label>Full Name</label>
				<input type="text" name="edit_name" <?php echo "value='".$name."'";  ?>>

			</div>


		<!-- 	<div class="field">
				<label>CL Left</label>
				<input type="text" name="cl_left">
			</div> -->
			<input type="submit" value="Update Admin" name="edit_admin" class="fluid positive ui button">
			<div class="ui error message"></div>
		</form>
	</div>
</div>

</div>
	  </div>

	</div>
<script type="text/javascript" src="../js/edit_admin.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
