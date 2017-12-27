
<?php

	require_once "sidebar.php";


	if(isset($_GET["department"])){
		$department = $_GET["department"];
		$query = "SELECT id,full_name,designation,cl_left FROM user WHERE department='{$department}'";
		$get_user_by_department = mysqli_query($connection, $query);

 ?>
 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>

		<h2 class="center_text"><?php echo $department; ?></h2>
	<table class="ui celled unstackble table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Designation</th>
				<th>CL Left</th>
			</tr>
		</thead>
		<tbody>
			<?php
				while ($row = mysqli_fetch_assoc($get_user_by_department)) {
					$id = $row["id"];
					$name = $row["full_name"];
					$designation = $row["designation"];
					$cl_left = $row["cl_left"];

			 ?>
			<tr>
				<td><a href="user_details.php?<?php echo "user_id=$id&name=$name" ?>"><?php echo $name; ?></a></td>
				<td><?php echo $designation; ?></td>
				<td><?php echo $cl_left; ?></td>
			</tr>

			<?php } ?>
		</tbody>
	</table>

 	<?php } ?>

 </div>
</div>
</div>
	  </div>

	</div>

<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
