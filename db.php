<?php

	$connection = mysqli_connect("localhost", "root", "", "cotton");
	if(!$connection){
		echo "Error";
	}


	function confirmQuery($result){

	  if(!$result){
	    die ("error". mysqli_error($connection));
	  }

	}
 ?>
