<!DOCTYPE html>
<html>
<head>
  <title></title>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.css"/> -->
  <link rel="stylesheet" href="semantic/semantic.min.css"/>
  <link rel="stylesheet" href="css/style.css"/>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="semantic/semantic.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script> -->

    <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

  </head>
<body>

	<?php
	  session_start();
      require_once("db.php");
      require_once("session_check.php");
      $user_id=$_SESSION["user_id"];

		if(isset($_POST["update_password"])){

			if(!empty($_POST["new_password"]) && !empty($_POST["confirm_password"])){

				$new_password = $_POST["new_password"];
				$new_password = mysqli_real_escape_string($connection, $new_password);
				$query = "UPDATE user SET user_password='{$new_password}' WHERE id='{$user_id}'";
				$update_password = mysqli_query($connection, $query);
				if(mysqli_affected_rows($connection)>0){

					 header("Location:history.php");
				}
			}
		}
	?>

  <!-- navbar -->
  <div class="ui grid">
    <div class="sixteen wide column row">
      <div class="ui teal inverted top attached menu">
        <div class="menu">
          <div class="text_header_small">
            <a class='header_anchor' href="history.php">Cotton University</a>
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

  <div class="ui grid">
    <div class="six wide column">

    </div>

    <div class="four wide computer sixteen wide tablet sixteen wide mobile column">
    	<div class="layout_center">

    	<h2 class="center_text">Reset Password</h2>
    	<h4 class="center_text">Enter a new password for your account</h4>

	     <form id="border_padding" class="ui form" action="change_password.php" method="post">
	        <!-- <h1>Log In</h1> -->
	        <div class="field">
	        	<label>New Password</label>
	          	<input name="new_password" placeholder="New Password" type="password">
	        </div>

	        <div class="field">
	        	<label>Confirm Password</label>
	         	<input name="confirm_password" placeholder="Confirm Password" type="password">
	        </div>
	        <input type="submit" value="Reset Password" class="fluid positive ui button" name="update_password" />
	      <!--  <div class="ui submit button">Submit</div> -->
	        <div class="ui error message"></div>

	     </form>
    	</div>
    </div>

    <div class="six wide column">

    </div>
  </div>
  	<script type="text/javascript" src="js/change_password.js"></script>

</body>
</html>
