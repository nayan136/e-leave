<?php
	require_once "sidebar.php";
	require_once "../db.php";

	$device_type = $_SESSION['device_type'];
 ?>

 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>

	<h2 class="center_text">Application Details</h2>

 <div class="container_margin">
	<?php

		if (isset($_GET["application_id"])) {
			$application_id = $_GET["application_id"];

		$application_id = mysqli_real_escape_string($connection, $application_id);
    if(isset($_GET["admin"]) && $_GET["admin"]){
      $query = "SELECT * FROM admin_history WHERE id='$application_id' LIMIT 1";
    }else{
      $query = "SELECT * FROM history WHERE id='$application_id' LIMIT 1";
    }

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


          if($admin_check_time == "0000-00-00 00:00:00"){
            $admin_check_time = "Not Check";
          }

          if($to_date == "0000-00-00"){
          	$to_date = "-";
          }

          if(is_null($half_day))
          	$half_day = "-";
		}

		$user_id = mysqli_real_escape_string($connection, $user_id);
      if(isset($_GET["admin"]) && $_GET["admin"]){
        $query = "SELECT * FROM admin WHERE id = '{$user_id}' LIMIT 1";
      }else{
        $query = "SELECT * FROM user WHERE id = '{$user_id}' LIMIT 1";
      }

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
		 		<td>Name</td>
		 		<td><?php echo ucwords($full_name); ?></td>
	 		</tr>
			 <tr>
		 		<td>ip</td>
		 		<td><?php echo $ip; ?></td>
	 		</tr>
	 		 <tr>
		 		<td>Device</td>
		 		<td><?php echo $device; ?></td>
	 		</tr>
	 		 <tr>
		 		<td>CL Days</td>
		 		<td><strong><?php echo $cl_days_leave; ?></strong></td>
	 		</tr>
		 	<tr>
		 		<td>Starting Date</td>
		 		<td><strong><?php echo $from_date ?></strong></td>
		 	</tr>
		 	<tr>
		 		<td>End Date</td>
		 		<td><strong><?php echo $to_date ?></strong></td>
		 	</tr>
		 	<tr>
		 		<td>Shift</td>
		 		<td><strong><?php echo ucwords($half_day) ?></strong></td>
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
		 		<td><?php echo $admin_check_time ?></td>
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

	<script type="text/javascript" src="../js/application_details.js"></script>
	<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
