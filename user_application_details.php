
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	  <link rel="stylesheet" href="semantic/semantic.min.css"/>
 	   <link rel="stylesheet" href="css/style.css"/>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="semantic/semantic.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script> -->

    <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
 </head>
 <body>

 	<?php
	session_start();
	require_once "db.php";
	require_once("session_check.php");
 ?>

 <div class="ui grid">
   <div class="sixteen wide column row">
     <div class="ui teal inverted top attached menu">
       <div class="menu">
         <div class="text_header_small">
           Cotton University
         </div>
       </div>
       <div class="right menu">
         <a id="text_padding_small" class="item text_padding" href="logout.php">
             Logout
         </a>
         <a class="ui item" href="#"></a>

       </div>
     </div>
   </div>
 </div>

 	  <!-- <div class="ui top attached inverted segment">
			  <div class="ui inverted secondary menu">
			      <div class="right menu">
			    <a class="ui item" href="logout.php">
			      Logout
			    </a>
			    <a class="ui item" href="#"></a>
			  </div>
			  </div>
			</div> -->
		<br>

 <div class="ui container">

 <div class="ui grid">

	<div class="sixteen wide column">

	<h2 class="center_text">Application Details</h2>

 <div class="container_margin">
	<?php

		if (isset($_GET["application_id"])) {
			$application_id = $_GET["application_id"];

		$application_id = mysqli_real_escape_string($connection, $application_id);

		$query = "SELECT * FROM history WHERE id='$application_id' LIMIT 1";
		$get_application = mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($get_application)){

			$user_id = $row["user_id"];
			$ip = $row["ip"];
			$device = $row["device"];
			$cl_days_leave = $row["cl_days_leave"];
			$from_date = $row["from_date"];
			$to_date = $row["to_date"];
			$apply_time = $row["apply_time"];
			$admin_check_time = $row["admin_check_time"];
			$status = $row["status"];
			$reason = $row["reason"];
			$half_day = $row["half_day"];


          // if($admin_check_time == "0000-00-00 00:00:00"){
          //   $admin_check_time = "Not Check";
          // }

          if($to_date == "0000-00-00"){
          	$to_date = "-";
          }

          if(is_null($half_day))
          	$half_day = "-";
		}

		$user_id = mysqli_real_escape_string($connection, $user_id);

		$query = "SELECT * FROM user WHERE id = '{$user_id}' LIMIT 1";
		$get_user = mysqli_query($connection, $query);
		while($find_user = mysqli_fetch_assoc($get_user)){
			$full_name = $find_user["full_name"];
		}
	}

	 ?>

	 <table class="ui celled unstackable table">
	 	<thead>
	 		<tr>
				<th>Property</th>
				<th>Details</th>

			</tr>
	 	</thead>
		<tbody>

	 		 <tr>
		 		<td>CL Days</td>
		 		<td><?php echo $cl_days_leave; ?></td>
	 		</tr>
		 	<tr>
		 		<td>Starting Date</td>
		 		<td><?php echo $from_date ?></td>
		 	</tr>
		 	<tr>
		 		<td>End Date</td>
		 		<td><?php echo $to_date ?></td>
		 	</tr>
		 	<tr>
		 		<td>Shift</td>
		 		<td><?php echo $half_day ?></td>
		 	</tr>
		 	<tr>
		 		<td>Apply Time</td>
		 		<td><?php
		 			$splitTimeStamp = explode(" ",$apply_time);
		            $date = $splitTimeStamp[0];
		            $time = $splitTimeStamp[1];
		            $time_in_12_hour_format  = date("g:i a", strtotime($time));
		            echo $date."(".$time_in_12_hour_format.")";


		 		 ?></td>
		 	</tr>
		 	<tr>
		 		<td>Admin Check Time</td>
		 		<td><?php
	 			  if($admin_check_time == "0000-00-00 00:00:00"){
		            $admin_check_time = "Not Check";
		            echo $admin_check_time;
		          }else{
		 			$splitTimeStamp = explode(" ",$admin_check_time);
		            $date = $splitTimeStamp[0];
		            $time = $splitTimeStamp[1];
		            $time_in_12_hour_format  = date("g:i a", strtotime($time));
		            echo $date."(".$time_in_12_hour_format.")";
		       	}

		 		 ?>

		 	</tr>
		 	<tr>
		 		<td>Status</td>
		 		<td><?php echo ucwords($status) ?></td>
		 	</tr>
		 	<tr>
		 		<td>Reason</td>
		 		<td><?php echo $reason ?></td>
		 	</tr>
		</tbody>
	 </table>

</div>
</div>
</div>

	    </div>
	  </div>

	</div>



	<script type="text/javascript" src="../js/dashboard.js"></script>
</body>
</html>
