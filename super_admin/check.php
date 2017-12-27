<?php

  require_once "../db.php";

  if(isset($_POST["application"])){
    $application = $_POST["application"];

    if(strpos($application, "_")){
      $appl_array = explode("_",$application);
      $arra = str_split($appl_array[0]);
      $is_admin='';
      (array_shift($arra) == 0)?$is_admin = false: $is_admin = true;

      $user_id = implode("",$arra);
      $application_id = $appl_array[1];

      ($is_admin)?$table_user = "admin": $table_user = "user";
      $query = "SELECT full_name,department FROM ".$table_user." WHERE id='{$user_id}'";
      $get_user = mysqli_query($connection, $query);
      while($row = mysqli_fetch_assoc($get_user)){
        $full_name = $row["full_name"];
        $department = $row["department"];
      }

      ($is_admin)?$table_application = "admin_history": $table_application = "history";
      $query = "SELECT * FROM ".$table_application." WHERE id='{$application_id}' AND user_id='{$user_id}'";
      $get_aplication = mysqli_query($connection, $query);
      $row = mysqli_fetch_assoc($get_aplication);
      $row["full_name"] = $full_name;
      $row["department"] = $department;
      echo json_encode($row);
    }else{
      echo "error";
    }
  }

  // print_r($row);


 ?>
