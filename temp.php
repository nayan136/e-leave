<?php
require_once("db.php");

function allDates($begin, $end){
    $date = array();

      //$begin = date('Y-m-d', strtotime($begin .' -1 day'));
      $end = date('Y-m-d', strtotime($end .' +1 day'));

      $begin = new DateTime($begin);
      $end = new DateTime($end);

      $interval = new DateInterval('P1D');
      $dateRange = new DatePeriod($begin,$interval,$end);

      //$range = array();
      foreach ($dateRange as $date1) {
        $date[] = $date1->format("M d");
      }

      // print_r($date);
      // echo "<br>";

  return $date;

}

  // function dateFormat($date){
  //   //$date[0] = str_replace('/', '-', $date);
  //   $date[0] = date("M d", strtotime($date));
  //   return $date;
  // }
$temp_array = array();
$data = array();
$department = "physics";
$i = 0;

$query = "SELECT t.status,user.cl_left,user.department,user.full_name,GROUP_CONCAT(t.from_date,t.half_day)AS begin,GROUP_CONCAT(t.to_date)as end FROM
          (SELECT status,user_id,from_date,to_date,half_day FROM
          history WHERE status='approved')
          AS t
          INNER JOIN user ON (user.id = t.user_id)
          GROUP BY user.id
          HAVING user.department='physics'";

$result=mysqli_query($connection,$query);
$number_of_rows = mysqli_num_rows($result);



while($row = mysqli_fetch_assoc($result)){
  $i++;
  $name = ucwords($row["full_name"]);
  $cl_left = $row["cl_left"];
  $from_date = $row["begin"];
  $to_date = $row["end"];

  // for from date***************************************
  $date_by_user = array();
  $from_date_all = array();
  $date_shift = explode(",",$from_date);
  foreach($date_shift as $dates){
    $date1="";
    $date = str_split($dates,10);
    // $from_date = $date[0];
    $date[0] = str_replace('/', '-', $date[0]);
    $date[0] = date("M d", strtotime($date[0]));
    if(empty($date[1])){
        $date1 = $date[0];
    }else{
      $shift = $date[1];

      $date1 = $date[0]."(".ucfirst($shift[0]).")";
    }
    array_push($from_date_all,$date1);

  }
  // print_r($from_date_all);
  // echo "<br>";
//*****************************************************
  //end date

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

  // print_r($end_date_all);
  // echo "<br>";

  //dates between two dates
  $j=0;

  foreach($end_date_all as $date_end){
    if($date_end == "0000-00-00"){
      $approve_dates = $from_date_all[$j];
    }else{

      $date_between = allDates($from_date_all[$j], $date_end);
      // print_r($date_between);
      // echo "<br>";
      $approve_dates = implode(",", $date_between);
      // echo $approve_dates;
    }
    // echo $approve_dates;
    // echo "<br>";
    array_push($date_by_user,$approve_dates);
    $j++;
  }
  $approve_by_date = array();
  array_push($approve_by_date,$i,$name,$cl_left,implode(",", $date_by_user));
  print_r($approve_by_date);
  echo "<br>";

  array_push($temp_array,$approve_by_date);

// echo "<br>";
}
   print_r($temp_array);
 ?>
