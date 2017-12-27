<?php 
	require_once("../db.php");

	if(isset($_POST["application_id"]) && $_POST["status"]){
		$application_id = $_POST["application_id"];
		$status = $_POST["status"];

		$application_id = mysqli_real_escape_string($connection, $application_id);
		$status = mysqli_real_escape_string($connection, $status);

		$query = "UPDATE history SET status='$status',admin_check_time=now() WHERE id='$application_id'";
		$update_status = mysqli_query($connection, $query);
		if($status=="approved"){
			$query = "SELECT * FROM history WHERE id='$application_id'";
			$get_application = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($get_application)) {
				$user_id = $row["user_id"];
				$cl_days_leave = $row["cl_days_leave"];
			}

			$query = "SELECT * FROM user WHERE id='$user_id'";
			$get_user = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($get_user)) {
				$cl_left = $row["cl_left"];
			}
			$days_left = $cl_left - $cl_days_leave;
			$query = "UPDATE user SET cl_left='$days_left' WHERE id='$user_id'";
			$update_cl = mysqli_query($connection, $query);

		}
		confirmQuery($update_status);
		//header("Location: pending_application.php");
	}

?>