<?php
	session_start();
	require_once("superadmin_session_check.php");
	require_once "../db.php";

	$device_type = $_SESSION['device_type'];
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" href="../semantic/semantic.min.css"/>
	 <link rel="stylesheet" type="text/css" href="../css/style.css">
	 <link rel="stylesheet" href="../css/dashboard.css"/>
   	 <script type="text/javascript" src="../js/jquery.js"></script>
   	 <script type="text/javascript" src="../semantic/semantic.min.js"></script>

	 <!-- Standard Meta -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
</head>
<body>
	<?php
			$query = "SELECT curr_year FROM other";
			$get_query = mysqli_query($connection,$query);
			while($row = mysqli_fetch_assoc($get_query)){
				$current_year = $row["curr_year"];
			}
			if($current_year != date("Y")){
				header("Location: reset_year.html");
				die();
			}

	 ?>
	 <div class="tablet or mobile hidden">
     <div class="ui grid">
       <div class="sixteen wide column row">
         <div class="ui teal inverted top attached menu">
           <div class="menu">
             <div class="text_header">
               Cotton University
             </div>
           </div>
           <div class="right menu">
             <a id="text_padding" class="item text_padding" href="../logout.php">
                 Logout
             </a>
             <a class="ui item" href="#"></a>

           </div>
         </div>
       </div>
     </div>
   </div>


     <!-- ********************** -->
     <div class="tablet or mobile only">
       <div class="ui grid">
         <div class=" sixteen wide column row">
           <div class="ui teal inverted top attached menu">
             <div class="menu">
               <div class="text_padding">
                 Cotton University
               </div>
             </div>
             <div class="right menu">
             <a class="item">
               <i id='hide_sidebar' class="sidebar big icon"></i>
             </a>
           </div>
           </div>
         </div>
       </div>
     </div>

     <div class="ui bottom attached segment">
       <?php
			 if($_SESSION['device_type'] === 'computer') {
 					echo '<div id="m_menu" class="ui color1 vertical inverted visible left sidebar menu">';
 			}else{
 					echo '<div id="m_menu1" class="ui color1 vertical inverted left sidebar menu">';
 			}

       ?>
					<a class="item" href="absent_list.php">Absent List</a>
					<a class="item" href="pending_application.php">Pending Application</a>
					<a class="item" href="admin_list.php">Admin List</a>
					<a class="item" href="create_admin.php">Create Admin</a>
					<a class="item" href="check_application.php">Check Application</a>
					<a class="item" href="report.php">Report</a>

				 <?php
				 if($_SESSION['device_type'] !== 'computer') {
						 echo '<a class="ui item" href="../logout.php">Logout</a>';
				 }
				  ?>
       </div>
       <div class="pusher">
				 <div class="ui grid">
