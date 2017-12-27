<?php

	session_start();
	unset($_SESSION["user_id"]);
	unset($_SESSION["full_name"]);

	unset($_SESSION["loggedinGeneral"]);
	unset($_SESSION["loggedinAdmin"]);
	unset($_SESSION["loggedAsSuperadmin"]);

	unset($_SESSION["from_date"]);
	unset($_SESSION["to_date"]);
	unset($_SESSION["cl_days_leave"]);
	unset($_SESSION["reason"]);
	unset($_SESSION["login_failed"]);
	unset($_SESSION["department"]);
	unset($_SESSION["curr_year"]);
	unset($_SESSION["privilege"]);
	unset($_SESSION['application_details']);
	unset($_SESSION["email"]);
	header("Location: index.php");
	die();
 ?>
