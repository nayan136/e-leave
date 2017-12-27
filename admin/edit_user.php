<?php
		require_once "includes/sidebar.php";
		require_once("../db.php");
		$device_type = $_SESSION['device_type'];

		if(isset($_GET["user_id"])){

			$user_id = $_GET["user_id"];

			$user_id = mysqli_real_escape_string($connection, $user_id);

			$query = "SELECT * FROM user WHERE id='{$user_id}' LIMIT 1";
			$get_user = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($get_user)) {
				$username = $row["username"];
				$password = $row["user_password"];
				$full_name = $row["full_name"];
				$designation = $row["designation"];


			}
		}

		if(isset($_POST["update_user"])){
			$user_id = $_POST["user_id"];
			$update_username = $_POST["change_username"];
			$update_password = $_POST["change_password"];
			$update_name = $_POST["change_name"];
			$update_designation = $_POST["change_designation"];

			$user_id = mysqli_real_escape_string($connection, $user_id);
			$update_username = mysqli_real_escape_string($connection, $update_username);
			$update_password = mysqli_real_escape_string($connection, $update_password);
			$update_name = mysqli_real_escape_string($connection, $update_name);
			$update_designation = mysqli_real_escape_string($connection, $update_designation);


			$query = "UPDATE user SET username='$update_username', user_password='$update_password', full_name='$update_name',
					designation='$update_designation' ";

			$query .= "WHERE id='$user_id'";

			$update_user= mysqli_query($connection, $query);
			if(mysqli_affected_rows($connection) >0){

				header("Location: check_all_users.php");
			}else{
				echo "Error";
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
		<h2 class="center_text">Edit User</h2>
		<div class="container_margin">
		<form class="ui form segment" action="edit_user.php" method="post">
			<div class="field">
				<label>Username</label>
				<input type="text" name="change_username" value="<?php echo($username) ?>" >
			</div>

			<div class="field">
				<label>Password</label>
				<div class="ui icon input">
					<input type="text" name="change_password" <?php echo "value='".$password."'";  ?>>
					<!-- <i class="unhide ink icon"></i> -->
				</div>
			</div>
			<div class="field">
				<label>Full Name</label>
				<input type="text" name="change_name" <?php echo "value='".$full_name."'";  ?>>
			</div>
			<div class="field">
				<label>Designation</label>
				<input type="text" name="change_designation" <?php echo "value='".$designation."'";  ?>>
			</div>

			<div>
				<input type="hidden" name="user_id" value="<?php echo($user_id) ?>">
			</div>
			<input type="submit" value="Update" name="update_user" class="fluid positive ui button">
			<div class="ui error message"></div>
		</form>
</div>


		</div>

	    </div>
	  </div>

	</div>
<script type="text/javascript" src="../js/edit_user.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
