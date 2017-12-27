<!DOCTYPE html>
<html>
<head>
  <title></title>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.css"/> -->
  <link rel="stylesheet" href="semantic/semantic.min.css"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="css/select.css"/>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="semantic/semantic.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script> -->

    <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

</head>
<body>

  <div class="ui grid">
    <div class="sixteen wide column row">
      <div class="ui teal inverted top attached menu">
        <div class="menu">
          <div class="text_header_small">
            Cotton University
          </div>
        </div>
        <div class="right menu">
          <a id="text_padding_small" class="item text_padding" href="logout.php">
              Logout
          </a>
          <a class="ui item" href="#"></a>

        </div>
      </div>
    </div>
  </div>

  <!-- <div class="ui secondary segment">
  <div class="ui  secondary menu">
      <div class="right menu">
        <a class="ui item" href="logout.php">
          Logout
        </a>
    </div>
  </div>
</div> -->

  <div class="ui container">

    <?php

      session_start();
      require_once("db.php");
      require_once("session_check.php");

      $user_name = $_SESSION["full_name"];

     // echo "<h1>$user_name</h1>";
      $user_id=$_SESSION["user_id"];
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
    <div>
      <a href="change_password.php">Change Password</a>
    </div>
    <div>
      <a href="add_details.php">Add Details</a>
    </div>
  </div>
  <div class="extra content">
    <?php

      if($cl_left > 0){
     ?>
    <a href="apply_leave_form.php">
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

  <script type="text/javascript" src="js/history.js"></script>
</body>
</html>
