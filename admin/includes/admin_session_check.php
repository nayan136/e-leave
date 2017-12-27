<?php 
	
	if(!isset($_SESSION["user_id"]) || !isset($_SESSION["loggedinAdmin"])){
		//header("Location:../logout.php");
		header("Location:../index.php");
		
		//exit();

	}

 ?>