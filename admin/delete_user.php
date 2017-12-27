<?php
	require_once("../db.php");
	session_start();
	if(isset($_SESSION["loggedinAdmin"])){
		if(isset($_GET["delete_id"])){
			$delete_id = $_GET["delete_id"];
			$query = "DELETE FROM user WHERE id='{$delete_id}'";
			//$query = "DELETE FROM user, history USING user INNER JOIN history ON user.id = history.user_id  WHERE user.id='{$delete_id}';";
			$delete_user = mysqli_query($connection, $query);
			if(mysqli_affected_rows($connection) >0){
				header("Location: check_all_users.php");
			}
		}
	}

 ?>