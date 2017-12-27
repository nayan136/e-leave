<?php  
	//******************************************
		//not needed
	//*******************************************
	session_start();
	require_once("db.php");

	if(isset($_POST["apply_form"])){
		$user_id = $_SESSION["user_id"];
		$from_date = $_POST["from_date"];
		$to_date = $_POST["to_date"];
		$cl_days_leave = $_POST["cl_days_leave"];
		$reason = $_POST["reason"];


		$query = "INSERT INTO history";
		$query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason) ";
		$query .= "VALUES ('{$user_id}','192.168.0.102', 'mobile', '{$cl_days_leave}', '{$from_date}', '{$to_date}', now(), NULL, 'pending'
					, '{$reason}')";

		$insert_apply_form = mysqli_query($connection, $query);
		//confirmQuery($insert_apply_form);
		if (mysqli_affected_rows()>=0) {
			echo "Update";
		}else{
			echo "Failed";
		}
	}

?>