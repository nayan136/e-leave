<?php

  require_once("db.php");
  session_start();

  $user_id = $_SESSION["user_id"];


  function convertDateFormat($approve_time){
     $splitTimeStamp = explode(" ",$approve_time);
     $date = $splitTimeStamp[0];
     $time = $splitTimeStamp[1];
     $time_in_12_hour_format  = date("g:i a", strtotime($time));
     return $date." ( ".$time_in_12_hour_format." ) ";
  }

  if(isset($_POST["user"])){
    $privilege = $_POST["user"];
    $all_year = array();
    $table_name = "";
    ($privilege == "admin")? $table_name="admin_history": $table_name="history";
    $query = "SELECT YEAR(from_date) AS year FROM ".$table_name." WHERE user_id='{$user_id}' GROUP BY YEAR(from_date)";
    $get_all_application = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($get_all_application)){
      $date = $row["year"];
      array_push($all_year, $date);
    }
     // print_r($all_year);
    echo json_encode($all_year);
  }

  if(isset($_POST["application"]) && isset($_POST["year"])){
    $application_data = array();
    $year = $_POST["year"];
    ($_SESSION["privilege"] == "admin")? $table_name="admin_history": $table_name="history";
    $query = "SELECT * FROM ".$table_name." WHERE user_id='{$user_id}' AND YEAR(from_date)='{$year}'";
    $get_all_application = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($get_all_application)){
      $row["apply_time"] = convertDateFormat(  $row["apply_time"]);
      $check_time = $row["admin_check_time"];
      if($check_time == "0000-00-00 00:00:00"){
        $check_time = "Not Check";
      }else{
        $check_time = convertDateFormat($check_time);
      }
      $row["admin_check_time"] = $check_time;
      $row["status"] = ucwords($row["status"]);
      $application_data[] = $row;
    }
     // print_r($all_year);
    echo json_encode($application_data);
  }

 ?>
