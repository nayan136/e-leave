<?php

  require_once("../FPDF/fpdf.php");
  require_once("../db.php");


class PDF extends FPDF {

  // Page header
function Header()
{

    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Cotton University','C');
    // Line break
    $this->Ln(10);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function PageBody(){
  $this->SetFont('Arial','BU',14);
  $this->Cell(200,10,'Report on CL',0,0,'C');
  $this->Ln(10);
  $this->SetFont('Arial','B',12);
  $this->Cell(200,10,'Report generated by: Nayanjyoti Sharma');
  $this->Ln(5);
  $this->Cell(200,10,'Generated on: 06/11/2017');
  $this->Ln(5);
  $this->Cell(200,10,'Department: Physics');
  $this->Ln(10);
}

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


  // Load data
  function LoadData($conn)
  {
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

    $result=mysqli_query($conn,$query);
    $number_of_rows = mysqli_num_rows($result);

    $approve_by_date = array();

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

      $j=0;

      foreach($end_date_all as $date_end){
        if($date_end == "0000-00-00"){
          $approve_dates = $from_date_all[$j];
        }else{
          $date_between = $this->allDates($from_date_all[$j], $date_end);
          $approve_dates = implode(",", $date_between);

        }
        array_push($date_by_user,$approve_dates);
        $j++;
      }
      $approve_by_date = array();
      array_push($approve_by_date,$i,$name,$cl_left,implode(",", $date_by_user));


      array_push($temp_array,$approve_by_date);
    }

    return $temp_array;
  }
//**************************************************
  function ImprovedTable($header, $data)
  {

      // Column widths
      $w = array(15,60,20,100);

      // Header
      for($i=0;$i<count($header);$i++){
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
      }

      $this->Ln();
      // Data
      foreach($data as $row)
      {
          $no_of_dates = explode(",",$row[3]);
          $no_of_rows = ceil();
          $cell_height = $no_of_rows*6;
          $this->Cell($w[0],$cell_height,$row[0],1,0,'C');
          $this->Cell($w[1],$cell_height,$row[1],1,0);
          $this->Cell($w[2],$cell_height,$row[2],1,0,'C');
          $this->Cell($w[3],$cell_height,$row[3],1,0);
          // if($no_of_rows>1){
          //   for($k=0;$k<=$no_of_rows;$k++){
          //     $temp = array();
          //     for($a=$k*5; $a<($k+1)*5; $a++){
          //       if(!empty($no_of_dates[$a])){
          //         array_push($temp,$no_of_dates[$a]);
          //         // echo $a;
          //       }
          //
          //     }
          //     // echo "<br>";
          //     $temp = implode(",", $temp);
          //     // echo $temp;
          //     if($k == 0){
          //       $this->Cell($w[3],6,$temp,1,0);
          //       $this->Ln();
          //     }else{
          //       $this-> SetX(100);
          //       $this->Cell($w[3],6,$temp,1,0);
          //       $this->Ln();
          //     }
          //
          //   }
          // }else{
          //   $this->Cell($w[3],6,$row[3],1,0);
          // }

          //$this->Cell($w[4],6,$row[4],1,0,'C');

          $this->Ln();
      }
      // // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }
}

  $pdf = new PDF();
  $pdf->AliasNbPages();
  // Column headings
  $header = array("Sl No.","Name","CL Left","CL Date");
  // Data loading
  $data = $pdf->LoadData($connection);

  $pdf->AddPage();
  $pdf->PageBody();

  //create table
  $pdf->SetFont('Arial','',12);
  $pdf->ImprovedTable($header,$data);

  $pdf->Output();

 ?>