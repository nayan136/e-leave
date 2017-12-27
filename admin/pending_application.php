<?php
		require_once "includes/sidebar.php";
		require_once("../db.php");

		$get_pending_application = "SELECT * FROM history WHERE status='pending'";
		$get_all = mysqli_query($connection, $get_pending_application);
		$total_pending = mysqli_num_rows($get_all);
		$total_pages = ceil($total_pending/10);

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

		$query = "SELECT * FROM history WHERE status='pending' LIMIT $page_1,10";
		$get_all_history = mysqli_query($connection, $query);

?>


	<div class="twelve wide computer sixteen wide mobile column">
	<div class="container_margin">

	<h2 class="center_text">Pending List</h2>

	<?php
		if( $total_pending> 0){
			echo "<h4>Total Pending : $total_pending</h4>";
	?>

	<table class="ui striped celled unstackable table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Sending time</th>
				<!-- <th>Approved time</th> -->
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
					<!-- <td><?php echo $approve_time?></td> -->
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
	</table>

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
	        			echo '<a id="pagination" class="item" href="pending_application.php?page='.$i.'">'.$i.'</a>';

	        		}else{
	        			echo '<a class="item" href="pending_application.php?page='.$i.'">'.$i.'</a>';
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

		<?php

			}else{
					echo "<h1>No More Pending Application</h1>";
				}
	 	?>

		 </div>
	    </div>
	  </div>

	</div>


<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
