<?php 
	
	if(!isset($_SESSION["user_id"]) || !isset($_SESSION["loggedAsSuperadmin"])){
		header("Location:../index.php");
		
	}

 ?>