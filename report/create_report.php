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
  $this->Ln(10);
}

  // Load data
function LoadData($conn)
{
    $data = array();

    $query = "SELECT full_name,designation,cl_left FROM user";
    $result=mysqli_query($conn,$query);
    $number_of_rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
      // $name = $row["full_name"];
      // $designation = $row["designation"];
      // $cl_left = $row["cl_left"];
      array_push($data, $row);
    }

    return $data;

}

  function ImprovedTable($header, $data)
  {

      // Column widths
      $w = array(80,40, 20);
      $col_name = array("full_name", "designation", "cl_left");
      // Header
      for($i=0;$i<count($header);$i++){
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
      }

      $this->Ln();
      // Data
      foreach($data as $row)
      {
          $this->Cell($w[0],6,$row[$col_name[0]],1,0,'LR');
          $this->Cell($w[1],6,$row[$col_name[1]],1,0,'LR');
          $this->Cell($w[2],6,$row[$col_name[2]],1,0,'C');
          $this->Ln();
      }
      // // Closing line
      $this->Cell(array_sum($w),0,'','T');
  }
}

  $pdf = new PDF();
  $pdf->AliasNbPages();
  // Column headings
  $header = array("Name","Designation","CL Left");
  // Data loading
  $data = $pdf->LoadData($connection);

  $pdf->AddPage();
  $pdf->PageBody();

  //create table
  $pdf->SetFont('Arial','',12);
  $pdf->ImprovedTable($header,$data);

  $pdf->Output();

 ?>
