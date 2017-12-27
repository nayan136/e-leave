<?php
		require_once "includes/sidebar.php";
		require_once("../db.php");

		$department = $_SESSION["department"];
		$device_type = $_SESSION['device_type'];

		$query = "SELECT * FROM user WHERE department='{$department}'";
		$count_all_users = mysqli_query($connection, $query);
		$total_users = mysqli_num_rows($count_all_users);
		$total_pages = ceil($total_users/10);

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

		if(isset($_GET["name"])){
			$user_name = $_GET["name"];
			$user_name_query = "AND full_name LIKE '%".$user_name."%'";
		}else{
			$user_name_query = "";
		}
		$query = "SELECT * FROM user WHERE department='{$department}' $user_name_query LIMIT $page_1,10";
		$get_all_users = mysqli_query($connection, $query);

?>

<div class="one wide column">
</div>
	 <div class="eleven wide computer sixteen wide mobile column">
 <div class="container_margin">
	 <?php if($device_type === 'computer'){
		 echo "<br>";
	 } ?>
	<h2 class="center_text">User List<?php echo "(".ucwords($department).")"; ?></h2>
	<div class="ui action input">
	  <input class="search_name_text" placeholder="Search by name..." type="text">
	  <button id="search_name" class="ui icon button">
	    <i class="search icon"></i>
	  </button>
	</div>
	<?php
		echo "<h4>Total Users : $total_users</h4>";
	 ?>
	<table class="ui striped celled unstackable table">
		<thead>
			<tr>
				<th>Name</th>
				<!-- <th>Username</th>
				<th>Department</th> -->
				<th>Designation</th>
				<th>CL Left</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				while($row = mysqli_fetch_assoc($get_all_users)){
					$id = $row["id"];
					$full_name = $row["full_name"];
					$username = $row["username"];
					$department = $row["department"];
					$designation = $row["designation"];
					$cl_left = $row["cl_left"];

			?>

				<tr>
					<td><a href="user_details.php?<?php echo "user_id=$id&name=$full_name"; ?>"><?php echo ucwords($full_name) ?></a></td>
				<!-- 	<td><?php //echo $username ?></td>
					<td><?php //echo $department?></td> -->
					<td><?php echo $designation?></td>
					<td><?php echo $cl_left?></td>
					<td><a href="edit_user.php?user_id=<?php echo $id ?>">Edit</a></td>
					<td><a href="delete_user.php?delete_id=<?php echo $id ?>">Delete</a></td>
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
	        			echo '<a id="pagination" class="item" href="check_all_users.php?page='.$i.'">'.$i.'</a>';

	        		}else{
	        			echo '<a class="item" href="check_all_users.php?page='.$i.'">'.$i.'</a>';
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
</div>

	    </div>
	  </div>

	</div>
	<script type="text/javascript" src="../js/check_all_users.js"></script>
	<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
