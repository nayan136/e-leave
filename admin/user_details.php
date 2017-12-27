<?php
  require_once ("includes/sidebar.php");
  require_once("../db.php");
  $device_type = $_SESSION['device_type'];
  ?>

  <div class="one wide column">
  </div>
   	<div class="eleven wide computer sixteen wide mobile column">
  	<div class="container_margin">
  		<?php if($device_type === 'computer'){
  			echo "<br>";
  		} ?>

    <?php
      if(isset($_GET["user_id"]) && isset($_GET["name"])){
      $user_name =$_GET["name"];
      $user_id = $_GET["user_id"];

    ?>

   <!--  <h1>Casual Leave Left</h1> -->
    <?php

      $user_id = mysqli_real_escape_string($connection, $user_id);

      $query = "SELECT * FROM user WHERE id='$user_id' LIMIT 1";
      $get_user = mysqli_query($connection, $query);

      $row = mysqli_fetch_assoc($get_user);
        $cl_left = $row["cl_left"];
        $designation =$row["designation"];
        $department = $row["department"];
     // echo "<h3>$cl_left</h3>";
    ?>
   <!--  <a href="apply_leave_form.php">Apply</a>  -->

        <!-- **************************************************************** -->
<br>
<div class="ui centered card">
  <div class="image">
    <!-- <img src="https://semantic-ui.com/images/avatar/large/elliot.jpg"> -->
  </div>
  <div class="content">
    <a class="header"><?php echo ucwords($user_name); ?></a>
    <div class="meta">
      <span class="date"><?php echo $designation.", ".$department; ?></span>
    </div>
    <div class="description">
      Casual Leave Left   : <a href="history.php#history" class="ui red circular label"><?php echo $cl_left; ?></a>
    </div>

  </div>

</div>

    <!-- ****************************************************************** -->


    <?php

        $user_id = mysqli_real_escape_string($connection, $user_id);

        if(date('m') == 1){
          $query = "SELECT * FROM history WHERE user_id='$user_id' AND YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))  ORDER BY apply_time DESC";
        }else{
          $query = "SELECT * FROM history WHERE user_id='$user_id' AND YEAR(from_date)=YEAR(CURDATE())  ORDER BY apply_time DESC";
        }


        $get_all_history = mysqli_query($connection, $query);

        $count = mysqli_num_rows($get_all_history);
        if($count > 0){

     ?>

       <h1><a id="history"><i class="ui calendar icon"></i>History</a></h1>
      <!-- ******************************************************** -->

  <table class="ui striped called unstackable table">
    <thead>
      <tr>
        <th>Approve time</th>
        <th>Sending time</th>
        <th>Status</th>
        <th>Details</th>
      </tr>
    </thead>
    <tbody>
      <?php

        while($row = mysqli_fetch_assoc($get_all_history)){

          $application_id = $row["id"];
          $sending_time = $row["apply_time"];
          $approve_time = $row["admin_check_time"];
          $status = $row["status"];



      ?>

        <tr>
          <td><?php
              $splitTimeStamp = explode(" ",$approve_time);
              $date = $splitTimeStamp[0];
              $time = $splitTimeStamp[1];
              $time_in_12_hour_format  = date("g:i a", strtotime($time));
              if($approve_time == "0000-00-00 00:00:00"){
                  $approve_time = "Not Check";
              }else{
                  $approve_time = $date."(".$time_in_12_hour_format.")";
              }

             if($status == "pending"){
                echo '<div class="ui red ribbon label">'.$approve_time.'</div>';
              }else{
                  echo $approve_time;
              }
          ?></td>

          <td><?php

            $splitTimeStamp = explode(" ",$sending_time);
            $date = $splitTimeStamp[0];
            $time = $splitTimeStamp[1];
            $time_in_12_hour_format  = date("g:i a", strtotime($time));
            echo $date."(".$time_in_12_hour_format.")";
            ?>

          </td>

          <td><?php echo ucwords($status)?></td>
          <td><a href="application_details.php?application_id=<?php echo $application_id; ?>">details</a></td>

        </tr>

      <?php } } ?>

    </tbody>
  </table>

  <br>
  <?php } ?>
  <!-- ********************************************************* -->
</div>
</div>
</div>

</div>

<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
