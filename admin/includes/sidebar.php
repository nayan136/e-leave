
<?php
	session_start();
	require_once("admin_session_check.php");
	require_once("../Mobile_Detect.php");

	$detect = new Mobile_Detect;
	$mobile = $detect->getUserAgent();
	$device_type = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
  ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="../semantic/semantic.min.css"/>
 	  <link rel="stylesheet" href="../css/style.css"/>
     <link rel="stylesheet" href="../css/dashboard.css"/>
		 <link rel="stylesheet" href="../css/select.css"/>
 	  <script type="text/javascript" src="../js/jquery.js"></script>
 	  <script type="text/javascript" src="../semantic/semantic.min.js"></script>
 	  <!-- <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script> -->

 	    <!-- Standard Meta -->
 	  <meta charset="utf-8" />
 	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
   </head>
   <body>

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
         if($device_type === 'computer') {
             echo '<div id="m_menu" class="ui color1 vertical inverted visible left sidebar menu">';
         }else{
             echo '<div id="m_menu1" class="ui color1 vertical inverted left sidebar menu">';
         }

       ?>
         <a class="item" href="admin_history.php">Admin Details</a>
         <a class="item" href="absent_list.php">Absent List</a>
         <!-- <a class="item" href="create_holiday.php">Holiday List</a> -->
         <a class="item" href="create_user.php">Create User</a>
         <a class="item" href="check_all_users.php">User List</a>
         <a class="item" href="pending_application_new.php">Pending List</a>
         <a class="ui item" href="../admin/report.php">Report</a>

				 <?php
				 if($device_type !== 'computer') {
						 echo '<a class="ui item" href="../logout.php">Logout</a>';
				 }
				  ?>
       </div>

       <div class="pusher">
				 <div class="ui grid">
