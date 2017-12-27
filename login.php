<?php
	session_start();
	require_once("db.php");
	require_once("Mobile_Detect.php");

	$detect = new Mobile_Detect;
	$mobile = $detect->getUserAgent();
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

	$_SESSION['device_type'] = $deviceType;

	 //echo "login.php";
	// if(isset($_POST["login_form"])){

	if (isset($_POST["username"]) && isset($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$username = mysqli_real_escape_string ($connection, $username);
		$password = mysqli_real_escape_string ($connection, $password);

		$query = "SELECT * FROM other";
		$get_year = mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($get_year)){
			$current_year = $row["curr_year"];
		}

		$query = "SELECT username, user_password, privilege, id, department, full_name,email
				    FROM user
				    WHERE username='$username' AND user_password='$password'
				    UNION
				    SELECT username, admin_password, privilege, id, department, full_name,email
				    FROM admin
				    WHERE username='$username' AND admin_password='$password'";
		// $query = "SELECT * FROM user WHERE username='{$username}' AND user_password='{$password}'";
		 $get_user = mysqli_query($connection, $query);
		// $count = mysqli_num_rows($get_user);
		// if($count == 0){
		// 	$query = "SELECT * FROM admin WHERE username='{$username}' AND admin_password='{$password}'";
		// 	$get_user = mysqli_query($connection, $query);
		// }
		while ($row = mysqli_fetch_assoc($get_user)) {
			$user_id = $row["id"];
			$user_name = $row["full_name"];
			$privilege = $row["privilege"];
			$department = $row["department"];
			$email = $row["email"];
		}
		$count = mysqli_num_rows($get_user);

		if($count == 1){

			if($privilege == "admin"){
				 $_SESSION['loggedinAdmin'] = true;
				 $_SESSION["user_id"] = $user_id;
				 $_SESSION["full_name"] = $user_name;
				 $_SESSION["department"] = $department;
				 $_SESSION["curr_year"] = $current_year;
				 $_SESSION["privilege"] = $privilege;
				 $_SESSION["email"] = $email;

				header('Location: admin/admin_history.php');
				die();
			}elseif($privilege == "superadmin"){
				$_SESSION["loggedAsSuperadmin"] = true;
				$_SESSION["full_name"] = $user_name;
				$_SESSION["user_id"] = $user_id;
				$_SESSION["curr_year"] = $current_year;
				$_SESSION["privilege"] = $privilege;
				$_SESSION["email"] = $email;

				header("Location: super_admin/admin_list.php");
			}elseif($privilege == "general"){

		    	$_SESSION["user_id"] = $user_id;
			  	$_SESSION["full_name"] = $user_name;
		    	$_SESSION['loggedinGeneral'] = true;
			  	$_SESSION["curr_year"] = $current_year;
				$_SESSION["department"] = $department;
				$_SESSION["privilege"] = $privilege;
				$_SESSION["email"] = $email;
				header('Location: history.php');
				die();
			}

		}else{
			 $_SESSION["login_failed"] = true;
			 header('Location: index.php');
		}
	}
	// }

 ?>
