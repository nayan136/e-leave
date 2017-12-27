<?php

	require_once "sidebar.php";
	require_once "../db.php";

	$device_type = $_SESSION['device_type'];

	$admin_query = "SELECT * FROM admin WHERE privilege='admin'";
	$get_all_admin = mysqli_query($connection, $admin_query);


?>

<div class="one wide column">
</div>
	 <div class="eleven wide computer sixteen wide mobile column">
 <div class="container_margin">
	 <?php if($device_type === 'computer'){
		 echo "<br>";
	 } ?>

		<h2 class="center_text">Admin List</h2>

		<table class="ui celled unstackable structured table">
			<thead>
				<tr>
					<th>Departmet</th>
					<th>Name</th>
					<th>Employee</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($row = mysqli_fetch_assoc($get_all_admin)){
						$admin_id = $row["id"];
						$department = ucwords($row["department"]);
						$name = ucwords($row["full_name"]);
						$total_employee = $row["employee"];

				 ?>
				<tr>
					<td><a href="user_by_department.php?department=<?php echo $department; ?>"><?php echo $department; ?></a></td>
					<td><a href="admin_details.php?admin_id=<?php echo $admin_id; ?>&name=<?php echo $name ?>"><?php echo $name; ?></a></td>

					<td><?php echo $total_employee; ?></td>
					<td><a href="edit_admin.php?admin_id=<?php echo $admin_id ?>">Edit</a></td>
				</tr>

				<?php } ?>
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
