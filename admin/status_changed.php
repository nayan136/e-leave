	<?php
		require_once "includes/sidebar.php";
		require_once("../db.php");

		$device_type = $_SESSION['device_type'];

		if(isset($_GET["status"])){

			$status = $_GET["status"];

			$status = mysqli_real_escape_string($connection, $status);

			$get_application_by_status = "SELECT * FROM history WHERE status='$status'";
			$total_status_count = mysqli_query($connection, $get_application_by_status);
			$count = mysqli_num_rows($total_status_count);
			$total_pages = ceil($count/10);
			if(isset($_GET["page"])){
				$page = $_GET["page"];
				if($page =="" || $page =="1"){
					$page_1 = 0;
				}else{
					$page_1 = ($page*10)-10;
				}
			}else{
				$page_1 =0;
			}

			if($status == "pending"){
				$query = "SELECT * FROM history WHERE status='$status' LIMIT $page_1,10";
			}else{
				$query = "SELECT * FROM history WHERE status='$status' ORDER BY apply_time DESC LIMIT $page_1,10";
			}

			$get_all_history = mysqli_query($connection, $query);


	 ?>

	 <div class="one wide column">
	 </div>
	  	<div class="eleven wide computer sixteen wide mobile column">
	 	<div class="container_margin">
	 		<?php if($device_type === 'computer'){
	 			echo "<br>";
	 		} ?>
	<h2 class="center_text">Applications Detials</h2>
	<select id="selector" class="ui dropdown">
	  <option value="all">All</option>
	  <option value="approved"<?php if($status=="approved") echo "selected='selected'"; ?>>Approved</a></option>
	  <option value="rejected" <?php if($status=="rejected") echo "selected='selected'"; ?>>Rejected</a></option>
	   <option value="pending" <?php if($status=="pending") echo "selected='selected'"; ?>>Pending</a></option>
	</select>

	<?php
		if($count >0){
			$status_camelcase = ucwords($status);
			echo "<h4>Total $status_camelcase : $count</h4>";
	?>

	<table class="ui striped celled unstackable table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Sending time</th>
				<th>Approved time</th>
				<th>Details</th>
			</tr>
		</thead>
		<tbody>
			<?php


				while($row = mysqli_fetch_assoc($get_all_history)){
					$application_id = $row["id"];
					$user_id = $row["user_id"];
					$query = "SELECT * FROM user WHERE id = '{$user_id}' LIMIT 1";
					$get_user = mysqli_query($connection, $query);
					while($find_user = mysqli_fetch_assoc($get_user)){
						$user_name = $find_user["full_name"];
					}
					$sending_time = $row["apply_time"];
					$approve_time = $row["admin_check_time"];

					if($approve_time == "0000-00-00 00:00:00"){
			            $approve_time = "Not Check";
			          }

			?>

				<tr>
					<td><a href="application_details_by_user.php?user_name=<?php echo $user_name; ?>&user_id=<?php echo $user_id; ?>"><?php echo
		 			$user_name ?></a></td>
					<td><?php
						$splitTimeStamp = explode(" ",$sending_time);
			            $date = $splitTimeStamp[0];
			            $time = $splitTimeStamp[1];
			            $time_in_12_hour_format  = date("g:i a", strtotime($time));
			            echo $date."(".$time_in_12_hour_format.")";
					 ?></td>
					<td><?php
						$splitTimeStamp = explode(" ",$approve_time);
			            $date = $splitTimeStamp[0];
			            $time = $splitTimeStamp[1];
			            $time_in_12_hour_format  = date("g:i a", strtotime($time));
			            echo $date."(".$time_in_12_hour_format.")";
					 ?></td>
					<!-- <td><a <?php //echo $link; ?>>detials</a></td> -->
					<td><a href="application_details.php?application_id=<?php echo $application_id ?>">details</a></td>
					<!-- <td><?php //echo '<a href="application_details.php?application_id='.$application_id.'>details</a>'; ?></td> -->
					<!-- <th><form action="otherpage.html">
					  <input type="hidden" name="application_id" value=$application_id />
					  <input type="submit" value="details">
					</form></th> -->
				</tr>

			<?php } ?>

		</tbody>

		<?php
			if($total_pages >1){

		 ?>

		<tfoot>
	    <tr><th colspan="4">
	      <div class="ui right floated pagination menu">
	       <!--  <a class="icon item">
	          <i class="left chevron icon"></i>
	        </a> -->
	        <?php
	        	for($i=1; $i<=$total_pages; $i++){

	        		if(!isset($_GET["page"])){
	        			$page = 1;
	        		}

	        		if($i == $page){
	        			echo '<a id="pagination" class="item" href="status_changed.php?page='.$i.'">'.$i.'</a>';

	        		}else{
	        			echo '<a class="item" href="status_changed.php?page='.$i.'">'.$i.'</a>';
	        		}

	        	}

	        ?>

	       <!--  <a class="icon item">
	          <i class="right chevron icon"></i>
	        </a> -->
	      </div>
	    </th>
	  </tr></tfoot>
	  <?php } ?>
	</table>
	   <?php }} ?>

    		</div>
	    </div>
	  </div>

	</div>

<script type="text/javascript" src="../js/cl_details.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
