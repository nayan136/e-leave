<?php
  require_once "../db.php";

  if(isset($_POST["reset_year"])){

    if($_POST["reset_year"]){

      $current_year = date('Y');

      // transfer cl_left to cl_previous
      $query = "UPDATE user SET cl_previous=cl_left";
      $update = mysqli_query($connection,$query);
      $query = "UPDATE admin SET cl_previous=cl_left";
      $update = mysqli_query($connection,$query);
      // $query = "UPDATE other SET curr_year='{$current_year}'";
      // $update_year = mysqli_query($connection,$query);

      $query = "UPDATE user SET cl_left=12";
      $update = mysqli_query($connection,$query);
      $row_update = mysqli_affected_rows($connection);
      $query = "UPDATE admin SET cl_left=12";
      $update = mysqli_query($connection,$query);
      $row_update1 = mysqli_affected_rows($connection);

      // if($row_update>0 && $row_update1>0){
        $query = "UPDATE other SET curr_year='{$current_year}'";
        $update_year = mysqli_query($connection,$query);
        // echo $row_update."".$row_update1;
      // }

    }
  }else{
    // echo "string";
  }

?>
