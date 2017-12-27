<?php

	require_once "sidebar.php";
	require_once("../db.php");

	$device_type = $_SESSION['device_type'];
	$curr_year = $_SESSION["curr_year"];

	function check_year($date){
		$date_array = explode("-", $date);
		$year = $date_array[0];
		$is_current_year = false;
		if($year == date("Y")){
			$is_current_year = true;
		}
		return $is_current_year;
	}

	if(isset($_GET["application_id"]) && $_GET["status"]){
		$status = $_GET["status"];
		$application_id = $_GET["application_id"];
		$application_id = mysqli_real_escape_string($connection, $application_id);
		$status = mysqli_real_escape_string($connection, $status);


		if($status=="approved"){
			$query = "SELECT user_id,cl_days_leave FROM admin_history WHERE id='$application_id'";
			$get_application = mysqli_query($connection, $query);
      $admin_id = "";
			while ($row = mysqli_fetch_assoc($get_application)) {
				$admin_id = $row["user_id"];
				$cl_days_leave = $row["cl_days_leave"];
			}

			$is_current_year = check_year($from_date);
			if($is_current_year){
				$query = "SELECT cl_left AS cl FROM admin WHERE id='$admin_id'";
			}else{
				$query = "SELECT cl_previous AS cl FROM admin WHERE id='$user_id'";
			}

			$get_user = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($get_user)) {
				$cl_left = $row["cl_left"];
			}

			$days_left = $cl_left - $cl_days_leave;
      if($days_left >= 0){
        $query = "UPDATE admin_history SET status='$status',admin_check_time=now() WHERE id='$application_id'";
    		$update_status = mysqli_query($connection, $query);

				if($is_current_year){
					$query = "UPDATE admin SET cl_left='$days_left' WHERE id='$admin_id'";
				}else{
					$query = "UPDATE admin SET cl_previous='$days_left' WHERE id='$admin_id'";
				}

        $update_cl = mysqli_query($connection, $query);
      }else{
        header("Location: pending_application.php");
      }


		}elseif($status=="rejected"){
      $query = "UPDATE admin_history SET status='$status',admin_check_time=now() WHERE id='$application_id'";
      $update_status = mysqli_query($connection, $query);
    }


	}
	// $query = "SELECT history.from_date,history.status,user.department,COUNT(history.id) AS count
	// 			FROM history
	// 			LEFT JOIN user ON history.user_id = user.id
	// 			GROUP BY history.from_date
	// 			HAVING user.department='{$department}' AND history.status='pending' AND history.from_date>=curdate()";
	$count_by_group	= array();
	$query = "SELECT COUNT(admin_history.id) AS count
				FROM  admin_history INNER JOIN admin ON (admin.id = admin_history.user_id)
				WHERE status='pending' AND  from_date <= YEAR(curdate())
 				GROUP BY admin_history.from_date";
 	$get_application_by_date = mysqli_query($connection,$query);
 	while ($row = mysqli_fetch_assoc($get_application_by_date)) {
 		$count = $row["count"];
 		array_push($count_by_group, $count);
 	}

	// $query = "SELECT COUNT(*)AS count FROM history WHERE status='pending' AND from_date>= curdate() GROUP BY from_date";
	// $get_application_by_date = mysqli_query($connection,$query);



	// while ($row = mysqli_fetch_assoc($get_application_by_date)) {
	// 	$count = $row["count"];
	// 	//echo $count;
	// 	//$date = $row["from_date"];
	// 	array_push($count_by_group, $count);



	// }

	$query = "SELECT admin.full_name,admin.cl_previous,admin.cl_left,admin_history.from_date,admin_history.cl_days_leave,admin_history.to_date,admin_history.half_day,admin_history.id
				FROM  admin_history INNER JOIN admin ON (admin.id = admin_history.user_id)
				WHERE status='pending' AND from_date <= YEAR(curdate())
 				ORDER BY admin_history.from_date";

	//$query = "SELECT * FROM history ORDER BY from_date ";

	$get_application_by_date = mysqli_query($connection,$query);
	 $count = mysqli_num_rows($get_application_by_date);
	// echo $count;
	$date = "";

	if(mysqli_num_rows($get_application_by_date)>0){

 ?>

 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>
		<h2 class="center_text">Pending List</h2>
		<table class="ui striped celled unstackable structured table">
		  <thead>
		    <tr>
		      <th class="center aligned">Date</th>
		      <th class="center aligned">Applicant</th>
		      <th class="center aligned"></th>
		      <th class="center aligned"></th>

		    </tr>
		   </thead>
		   <tbody>

		   	<?php
		   	while ($row = mysqli_fetch_assoc($get_application_by_date)) {

 				$name = $row["full_name"];
				$cl_previous = $row["cl_previous"];
 				$cl_left = $row["cl_left"];
 				$half_day = $row["half_day"];
 				$end_date = $row["to_date"];
 				$cl_days_leave = $row["cl_days_leave"];
 				$application_id = $row["id"];
 				if($end_date == "0000-00-00"){
 					if(!empty($half_day)){
 						$leave_period = ucwords($half_day);
 					}else{
 						$leave_period = "FD";
 					}
 				}else{
 					$leave_period = $cl_days_leave." days";
 				}

				check_year($from_date)?:$cl_left = $cl_previous;

				if($date != $row["from_date"]){
					$date = $row["from_date"];
					// echo $date;
					// echo "<br>";

			?>

			  <tr>
		  	  	<?php $value = array_shift($count_by_group);?>

		  	  	<td class="center aligned" <?php echo "rowspan=$value"; ?>><?php echo $date; ?></td>
		  	  	<td class="center aligned"><?php echo $name."(".$cl_left.")"."(".$leave_period.")"; ?></td>
		  	  	<td class="center aligned"><a href="pending_application.php?status=approved&application_id=<?php echo $application_id ?>"><i class="green check icon"></i></a></td>
		  	  	<td class="center aligned"><a href="pending_application.php?status=rejected&application_id=<?php echo $application_id ?>"><i class="red remove icon"></a></td>
		  	  </tr>

			<?php

				}else{

					//echo $date;
				?>
				<tr>
		  	  		<td class="center aligned"><?php echo $name."(".$cl_left.")"."(".$leave_period.")"; ?></td>
		  	  		<td class="center aligned"><a href="pending_application.php?status=approved&application_id=<?php echo $application_id ?>"><i class="green check icon"></a></td>
		  	  		<td class="center aligned"><a href="pending_application.php?status=rejected&application_id=<?php echo $application_id ?>"><i class="red remove icon"></a></td>
		  	  	</tr>

				<?php }	} ?>



		   </tbody>
		</table>
	<?php }else{ ?>
		<br>
		<h2 class="center_text">No more pending application</h2>
	<?php } ?>
	</div>

</div>
	    </div>
	  </div>

	</div>

<script type="text/javascript" src="../js/sidebar.js"></script>
<!-- <script type="text/javascript" src="../js/pending_application.js"></script> -->
</body>
</html>
