<?php 

	require_once "includes/sidebar.php";
	require_once("../db.php");

	if(isset($_GET["delete_id"])){
		$holiday_id = $_GET["delete_id"];
		$query = "DELETE FROM holiday WHERE id=$holiday_id";
		$delete_by_id = mysqli_query($connection, $query);
	}

	if(isset($_POST["holiday_form"])){

		if(!empty($_POST["start_holiday"]) && !empty($_POST["holiday_name"])){
			$start_holiday = $_POST["start_holiday"];
			$end_holiday = $_POST["end_holiday"];
			$holiday_name = $_POST["holiday_name"];
			
			$start_holiday = mysqli_real_escape_string($connection, $start_holiday); 
			$end_holiday = mysqli_real_escape_string($connection, $end_holiday);
			$holiday_name = mysqli_real_escape_string($connection, $holiday_name);
			//check for duplicate
			$query = "SELECT * FROM holiday WHERE from_date='{$start_holiday}'";
			$get_holiday_list = mysqli_query($connection, $query);
			$count = mysqli_num_rows($get_holiday_list);

			if($count<1){
				$query = "INSERT INTO holiday";
				$query .="(holiday_name, from_date, to_date)";
				$query .="VALUES ('{$holiday_name}','{$start_holiday}','{$end_holiday}')";

				$update_holiday_list = mysqli_query($connection, $query);
			}

		}
	}


 ?>

<div class="twelve wide computer sixteen wide mobile column">
 <div class="container_margin">
<h2 class="center_text">Holiday List</h2>
<!-- ********************************************* -->

<table class="ui striped celled unstackable table">
		<thead>
			<tr>
				<th>Starting Date</th>
				<th>Ending Date</th>
				<th>Hoiday Name</th>
				<th>Delete</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				
				$query = "SELECT * FROM holiday ORDER BY from_date";
				$get_holiday_list = mysqli_query($connection, $query);
				while($row = mysqli_fetch_assoc($get_holiday_list)){
					$id = $row["id"];
					$starting_date = $row["from_date"];
					$ending_date = $row["to_date"];
					$holiday_name = $row["holiday_name"];
			
					if($ending_date == "0000-00-00"){
			            $ending_date = "-";
			          }



			?>

				<tr>
					<td><?php echo $starting_date ?></td>
					<td><?php echo $ending_date ?></td>
					<td><?php echo $holiday_name?></td>
					<td><a href="create_holiday.php?delete_id=<?php echo $id; ?>">Delete</a></td>
					<!-- <td><a href="application_details.php?application_id=<?php echo $application_id ?>">details</a></td> -->
				
				</tr>

			<?php } ?>
			
		</tbody>
	</table>

	<br>
<!-- 
	<div class="ui red divider"></div> -->

<!-- ********************************************* -->
<h3>Add to Holiday List</h3>
<div id="content_hide">
<form class="ui form" action="create_holiday.php" method="post">
  <div class="three fields">
	<div class="field">
		<label>Starting date</label>
		<div class="ui calendar" id="holidaystart">
		    <div class="ui input left icon">
		      <i class="calendar icon"></i>
		      <input type="text"  name="start_holiday" placeholder="Starting date">
		    </div>
		  </div>
	</div>

	<div class="field">
		<label>End date</label>
		<div class="ui calendar" id="holidayend">
		    <div class="ui input left icon">
		      <i class="calendar icon"></i>
		      <input type="text" name="end_holiday" placeholder="End date">
		    </div>
		  </div>
	</div>
    <div class="field">
      <label>Holiday Name</label>
      <input placeholder="Holiday Name" name="holiday_name" type="text">
    </div>
  </div>

  <input type="submit" value="Add" name="holiday_form" class="positive ui button">
</form>

</div>


		</div>

 	    </div>
	  </div>
 	</div>
	</div>
	<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
	<!-- <script type="text/javascript" src="../js/apply_leave_form.js"></script> -->

<script type="text/javascript" src="../js/dashboard.js"></script>
<script type="text/javascript" src="../js/create_holiday.js"></script>
</body>
</html>