<?php

  require_once("../FPDF/fpdf.php");
  require_once("../db.php");
  session_start();

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
  $name = $_SESSION["full_name"];
  $name = 'Report generated by: '.ucwords($name);
  $cur_date = 'Generated on: '.date("d/m/Y");
  $department = 'Department: '. $_SESSION["department"];
  $date = $_POST["date"];
  // $date = str_replace("/","-",$date);
   $date = date_format(new DateTime($date),"d/m/Y");
  $report_date = 'Report on Absent List: '.$date;

  $this->SetFont('Arial','BU',14);
  $this->Cell(200,10,'Report on CL',0,0,'C');
  $this->Ln(10);
  $this->SetFont('Arial','B',12);
$this->Cell(200,10,$name);
  $this->Ln(5);
    $this->Cell(200,10,$cur_date);
  $this->Ln(5);
  $this->Cell(200,10,$department);
  $this->Ln(5);
  $this->Cell(200,10,$report_date,0,0,'C');
  $this->Ln(10);
}

  // Load data
function LoadData($conn)
{
    $department = $_SESSION["department"];
    $date = $_POST["date"];
    $data = array();

    $i = 0;

    $query = "SELECT user.full_name, history.half_day FROM  history INNER JOIN user ON (user.id = history.user_id)
          WHERE status='approved' AND department ='{$department}' AND (('{$date}' >= from_date AND '{$date}' <= to_date) OR (from_date='{$date}'))";
    $result=mysqli_query($conn,$query);
    $number_of_rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
      $i++;
      $name = ucwords($row["full_name"]);
      $half_day = $row["half_day"];

      $temp_array = array();
      array_push($temp_array, $i,$name,$half_day);

      array_push($data,$temp_array);
      unset($temp_array);
    }

    return $data;

}

  function ImprovedTable($header,$data)
  {

      // Column widths
      $w = array(15,80,80);
      //$col_name = array("full_name", "designation", "cl_left");
      // Header
      $this->SetFont('Arial','B',12);
      $this->Cell(15,14,$header[0],1,0,'C');
      $this->Cell(160,7,$header[1],1,0,'C');
      $this->Ln();
      $this-> SetX(25);
      $this->Cell(80,7,$header[2],1,0,'C');
      $this->Cell(80,7,$header[3],1,0,'C');

      $this->Ln();
      // Data
      $this->SetFont('Arial','',12);
      foreach($data as $row)
      {
          $this->Cell($w[0],6,$row[0],1,0,'C');
          if(!empty($row[2])){

            if($row[2] == "morning"){
              $this->Cell($w[1],6,$row[1],1,0,'C');
              $this->Cell($w[1],6,"",1,0,'C');
            }else{
              $this->Cell($w[1],6,"",1,0,'C');
              $this->Cell($w[1],6,$row[1],1,0,'C');
            }
          }else{

            $this->Cell($w[1]+$w[2],6,$row[1],1,0,'C');
          }

          $this->Ln();
      }
      // // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }
}

  $pdf = new PDF();
  $pdf->AliasNbPages();
  // Column headings
  $header = array("Sl No.","Shift","Morning","Evening");
  // Data loading
  $data = $pdf->LoadData($connection);

  $pdf->AddPage();
  $pdf->PageBody();

  //create table
  $pdf->SetFont('Arial','',12);
  $pdf->ImprovedTable($header,$data);

  $pdf->Output();

 ?>
