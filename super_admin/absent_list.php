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

 	<div class="twelve wide computer sixteen wide mobile column">
	<div class="container_margin">

		<h2 class="center_text">Absent List</h2>

		<table class="ui celled unstackable structured table">
		<thead>
			<tr>
				<th rowspan="2">Date</th>
				<th colspan="2" class="center aligned">Absent</th>
			</tr>
			<tr>
				<th>Morning</th>
				<th>Evening</th>
			</tr>
		</thead>
		<tbody>

				<?php

				function placeUserInTable($shift, $name){

					if(!empty($shift)){
						if($shift == "morning"){
							$value = '<td>'.$name.'</td><td></td>';

						}else{
							$value = '<td></td><td>'.$name.'</td>';

						}
					}else{
						$value = '<td colspan="2" class="center aligned">'.$name.'</td>';

					}
					return $value;
				}

				function isWeekend($date) {
			    	return (date('N', strtotime($date)) == 7);
				}

				$today_date = date('Y-m-d'); //today date
				$date= date( 'Y-m-d', strtotime( $today_date . ' -3 day' ) );
				$weekOfdays = array();
				for($i =1; $i <= 8; $i++){
				    $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
				    $weekOfdays[] = date('Y-m-d (l)', strtotime($date));
				     //echo "<th>$weekOfdays[$i]</th>";
				}

				// print_r($weekOfdays);
				// $query = "SELECT COUNT(*) FROM history WHERE status='approved' GROUP BY from_date";
				// $total_application_by_date = mysqli_query($connection,$query);

				// create ui
				for($i=0; $i<count($weekOfdays); $i++){
					$date = explode("(",$weekOfdays[$i]);
					$date = $date[0];
					if(isWeekend($date)){
						continue;
					}
					$users=array();

					// $query = "SELECT user_id FROM history WHERE status='approved' AND (('$date' >= from_date
					// AND '$date' <= to_date) OR (from_date='$date'))";
					$query = "SELECT admin.full_name, admin_history.half_day FROM  admin_history INNER JOIN admin ON (admin.id = admin_history.user_id)
								WHERE status='approved' AND (('{$date}' >= from_date AND '{$date}' <= to_date) OR (from_date='{$date}'))";

					$total_application_by_date = mysqli_query($connection,$query);
					$count = mysqli_num_rows($total_application_by_date);

					while ($row = mysqli_fetch_assoc($total_application_by_date)) {
						$name = ucwords($row["full_name"]);
						$half_day = $row["half_day"];

						// $count = $row["COUNT(*)"];
						// $user_id = $row["user_id"];
						// $name_query = "SELECT full_name FROM user WHERE id='$user_id'";
						// $get_name = mysqli_query($connection, $name_query);
						// while($row = mysqli_fetch_assoc($get_name)){
						// 	$name = $row["full_name"];

							array_push($users, $name);
						// }


					}
					if(strtotime($date) == strtotime($today_date)){
						$match = true;
					}else{
						$match = false;
					}

					if($count>0){
						for($j=0;$j<$count;$j++){
							$user_name = array_pop($users);

							if($match){
								echo '<tr class="active">';
							}else{
								echo "<tr>";
							}

							if($j==0){
								echo "<td rowspan=$count>$weekOfdays[$i]</td>";
								echo placeUserInTable($half_day,$user_name);
							}else{
								echo placeUserInTable($half_day,$user_name);
							}

							echo "</tr>";

					  	}
					}else{
						if(strtotime($date) == strtotime($today_date)){
							echo '<tr class="active">';
						}else{
							echo "<tr>";
						}

						echo "<td>$weekOfdays[$i]</td>";
						echo '<td colspan="2"></td>';

						echo "</tr>";
					}
				}

				 ?>

		</tbody>
		</table>

	</div>
	</div>


 	    </div>
	  </div>

	</div>

<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
