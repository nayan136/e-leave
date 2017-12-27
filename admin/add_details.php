<?php
   require_once "includes/sidebar.php";
    require_once("../db.php");

    $user_id=$_SESSION["user_id"];

		if(isset($_POST["update_info"])){
      echo "string";
			if(empty($_POST["email"]) && empty($_POST["phone_number"])){

      }else{

        unset($valid_email);
        unset($phone_number);
        unset($update_form);
        unset($update_form1);

        (!empty($_POST["email"]))? $email = mysqli_real_escape_string($connection,$_POST["email"]):$email=null;
        (!empty($_POST["phone_number"]))?$phone_number = mysqli_real_escape_string($connection,$_POST["phone_number"]):$phone_number=null;
        // echo $email;
        // echo $phone_number;

        // (is_null($email))?($valid_email = filter_var($email, FILTER_VALIDATE_EMAIL)?true:false):'';
        // (is_null($phone_number))?($valid_phone = (is_numeric($phone_number) && strlen($phone_number))?true:false):'';
        (is_null($email))?:($valid_email = filter_var($email, FILTER_VALIDATE_EMAIL)?true:false);
        (is_null($phone_number))?:($valid_phone = (is_numeric($phone_number) && strlen($phone_number) == 10));
        // echo (isset($valid_email))? $valid_email : "not email";
        // echo (isset($valid_phone))? $valid_phone :  "not phone";
        $update_form = (isset($valid_email))? $valid_email:true;
        $update_form1 = (isset($valid_phone))? $valid_phone:true;

        // var_dump($update_form);
        // var_dump($update_form1);
        // die();

        if($update_form && $update_form1){
          if ($_SESSION['loggedinAdmin']) {
              $query = "UPDATE admin SET email='{$email}', phone_number='{$phone_number}' WHERE id='{$user_id}'";
          }
          $update_password = mysqli_query($connection, $query);
          if(mysqli_affected_rows($connection)>0){

                header("Location:admin_history.php");

          }
        }

			}
		}

    // default value if exist
    if($_SESSION['loggedinAdmin']) {
        $query = "SELECT email, phone_number FROM admin WHERE id='{$user_id}'";
    }

    $get_data = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($get_data)){
      $email = $row["email"];
      $phone_number = $row["phone_number"];
    }

	?>
    <div class="four wide column">

    </div>

    <div class="five wide computer sixteen wide tablet sixteen wide mobile column">
    	<div class="layout_center">

    	<h2 class="center_text">Add Details</h2>
    	<h4 class="center_text">Enter Email and Phone Number</h4>

	     <form id="border_padding" class="ui form" action="add_details.php" method="post">
	        <!-- <h1>Log In</h1> -->
	        <div class="field">
	        	<label>Email</label>
	          	<input name="email" placeholder="example@mail.com" <?php echo is_null($email)?:'value="'.$email.'"'; ?>type="email">
	        </div>

	        <div class="field">
	        	<label>Phone Number</label>
	         	<input name="phone_number" placeholder="Phone Number"<?php echo is_null($phone_number)?:'value="'.$phone_number.'"'; ?> type="text">
	        </div>
	        <input type="submit" value="Update Information" class="fluid positive ui button" name="update_info" />
	      <!--  <div class="ui submit button">Submit</div> -->
	        <div class="ui error message"></div>

            <?php if(isset($valid_phone) && !$valid_phone){ ?>
            <div class="ui negative message">
              <p>Phone Number is wrong</p>
            </div>
            <?php } ?>


	     </form>
    	</div>
    </div>

    <div class="seven wide column">

    </div>
  </div>

</div>
</div>

</div>

<script type="text/javascript" src="../js/change_password.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>

</body>
</html>
