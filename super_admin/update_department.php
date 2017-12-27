<?php

require_once "../db.php";

if(isset($_POST["department"]) && isset($_POST["user_id"]) ){
  $department = $_POST["department"];
  $user_id = $_POST["user_id"];

  $query = "UPDATE user SET department = '{$department}' WHERE id = '{$user_id}'";
  $update_query = mysqli_query($connection, $query);

  // echo (mysqli_affected_rows($connection)>0)? "success": "failure";
  echo mysqli_affected_rows($connection);

  die();
}

 ?>
