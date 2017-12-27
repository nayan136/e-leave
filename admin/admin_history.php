


    <?php
      require_once("../db.php");
      require_once "includes/sidebar.php";

      $user_name = $_SESSION["full_name"];

     // echo "<h1>$user_name</h1>";
      $user_id=$_SESSION["user_id"];
      	$device_type = $_SESSION['device_type'];
    ?>
   <!--  <h1>Casual Leave Left</h1> -->
    <?php

      $user_id = mysqli_real_escape_string($connection, $user_id);

      $query = "SELECT * FROM admin WHERE id='$user_id' LIMIT 1";
      $get_user = mysqli_query($connection, $query);

      $row = mysqli_fetch_assoc($get_user);
        $cl_left = $row["cl_left"];
        //$designation =$row["designation"];
        $department = $row["department"];
     // echo "<h3>$cl_left</h3>";
    ?>

    <div class="one wide column">
    </div>
     	<div class="eleven wide computer sixteen wide mobile column">
    	<div class="container_margin">
    		<?php if($device_type === 'computer'){
    			echo "<br>";
    		} ?>
   <!--  <a href="apply_leave_form.php">Apply</a>  -->

        <!-- **************************************************************** -->
<br>
<div class="ui centered card">
  <div class="image">
    <!-- <img src="https://semantic-ui.com/images/avatar/large/elliot.jpg"> -->
  </div>
  <div class="content">
    <a class="header"><?php echo $user_name; ?></a>
    <div class="meta">
      <span class="date"><?php echo $department; ?></span>
    </div>
    <div class="description">
      Casual Leave Left   : <a href="" class="ui red circular label"><?php echo $cl_left; ?></a>
    </div>
    <div>
      <a href="change_password.php">Change Password</a>
      <div>
        <a href="add_details.php">Add Details</a>
      </div>
    </div>
  </div>
  <div class="extra content">
    <?php

      if($cl_left > 0){
     ?>
    <a href="apply_cl.php">
      <div class="fluid positive ui button">Apply For Leave</div>
    </a>

    <?php }else{ ?>

    <button class="ui fluid disabled button">
      Apply For Leave
    </button>

    <?php } ?>

  </div>
</div>


      <h1 class="header center_text">Application History</h1>
        <!-- <a href="report/user_history_report.php"><i class="ui print icon"></i></a></h1> -->
      <!-- Dropdown Table -->
      <div class="dropdown_year make_inline">
          <!-- <button class="ui button right">Download Application List</button> -->
      </div>
      <div class="make_inline right">
        <button class="ui positive button right application_history" >Download Application History</button>
      </div>
      <!-- Applicatin Table -->
      <div class="application_table"></div>

</div>

  </div>


</div>
  <script type="text/javascript" src="../js/admin_history.js"></script>
  <script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
