

	<?php
	   require_once "includes/sidebar.php";
      require_once("../db.php");

      $user_id=$_SESSION["user_id"];

		if(isset($_POST["update_password"])){

			if(!empty($_POST["new_password"]) && !empty($_POST["confirm_password"])){

				$new_password = $_POST["new_password"];
				$confirm_password = $_POST["confirm_password"];
				if($new_password == $confirm_password){
					$new_password = mysqli_real_escape_string($connection, $new_password);
					$query = "UPDATE admin SET admin_password='{$new_password}' WHERE id='{$user_id}'";
					$update_password = mysqli_query($connection, $query);
					if(mysqli_affected_rows($connection)>0){

						 header("Location:admin_history.php");
					}
				}
			}
		}
	?>
  <div class="twelve wide computer sixteen wide mobile column">
	<div class="container_margin">
  <div class="ui grid">
    <div class="five wide column">

    </div>

    <div class="six wide computer sixteen wide tablet sixteen wide mobile column">
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

    <div class="five wide column">

    </div>
  </div>
</div>
</div>

  </div>
</div>

</div>

<script type="text/javascript" src="../js/change_password.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
