<?php
  require_once("../db.php");

  function allDates($begin, $end){
      $date = array();

        //$begin = date('Y-m-d', strtotime($begin .' -1 day'));
        $end = date('Y-m-d', strtotime($end .' +1 day'));

        $begin = new DateTime($begin);
        $end = new DateTime($end);

        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($begin,$interval,$end);

        foreach ($dateRange as $date1) {
          $date[] = $date1->format("M d");
        }
    return $date;

  }
$department = "gad";
$conn = $connection;
$temp_array = array();
$i = 0;
  $query = "SELECT * FROM user WHERE department='{$department}' ";
  $get_all_user_by_dept = mysqli_query($conn,$query);
  while($row = mysqli_fetch_assoc($get_all_user_by_dept)){
    $i++;
    $id = $row["id"];
    $name = $row["full_name"];
    $cl_left= $row["cl_left"];
    $query1 = "SELECT SUM(cl_days_leave)AS cl_used,status,GROUP_CONCAT(from_date,half_day)AS begin,GROUP_CONCAT(to_date)as end
              FROM history WHERE user_id='$id' AND status='approved' ";
    $result = mysqli_query($conn,$query1);

    while($row1 = mysqli_fetch_assoc($result)){
      $from_date = $row1["begin"];
      $to_date = $row1["end"];
      if(is_null($row1["cl_used"])){
        $cl_used = 0;
      }else{
        $cl_used = $row1["cl_used"];
      }
      // echo $from_date;
      // echo "<br>";

    }

    $date_by_user = array();
    $from_date_all = array();
    $date_shift = explode(",",$from_date);
    // print_r($date_shift);
    // echo "<br>";
    foreach($date_shift as $dates){
      $date1="";
      $date = str_split($dates,10);

      // $from_date = $date[0];
      $date[0] = str_replace('/', '-', $date[0]);
      if($date[0] != ""){
        $date[0] = date("M d", strtotime($date[0]));
      }
      // echo $date[0];
      // echo "<br>";

      if(empty($date[1])){
          $date1 = $date[0];
      }else{
        $shift = $date[1];

        $date1 = $date[0]."(".ucfirst($shift[0]).")";
      }
      array_push($from_date_all,$date1);

    }

    $end_date_shift = explode(",",$to_date);
    $end_date_all = array();

    foreach($end_date_shift as $dates1){
      $end_date1="";
      // echo $dates1;
      // if($dates1 != "0000-00-00"){
      //     $dates1 = date("M d", strtotime($dates1));
      // }
      array_push($end_date_all,$dates1);
      //*****************************************************
    }

    $j=0;
    // print_r($end_date_all);
    // echo "<br>";

    foreach($end_date_all as $date_end){
      // echo $date_end."-".$i;
      // echo "<br>";
      if($date_end == "0000-00-00"){
        $approve_dates = $from_date_all[$j];

      }else{
        if($date_end != ""){
          $date_between = allDates($from_date_all[$j], $date_end);

          $approve_dates = implode(",", $date_between);
        }else{
          $approve_dates = "";
        }


      }
      // print_r ($approve_dates);
      // echo "<br>";
      array_push($date_by_user,$approve_dates);
      $j++;
    }

    $approve_by_date = array();
    array_push($approve_by_date,$i,$name,$cl_used,implode(",", $date_by_user),$cl_left);

    array_push($temp_array,$approve_by_date);

  }

  return $temp_array;



 ?>
