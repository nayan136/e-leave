
<?php

  require_once("../FPDF/fpdf.php");
  require_once("../db.php");
  session_start();

class PDF extends FPDF {

  function formatDate($originalDate){
    $newDate = date("d/m/Y", strtotime($originalDate));
    return $newDate;
  }

  function formatDateTo12hour($apply_time){
    $splitTimeStamp = explode(" ",$apply_time);
    $date = $splitTimeStamp[0];
    $time = $splitTimeStamp[1];
    $time_in_12_hour_format  = date("g:i a", strtotime($time));
    return $this->formatDate($date)." (".$time_in_12_hour_format.")";
  }

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

function PageBody(){

  $this->SetFont('Arial','BU',14);
  $this->Cell(200,10,'CL Application',0,0,'C');
  $this->Ln(10);
}

  // Load data
function LoadData($conn)
{
    $department = $_SESSION["department"];
    $user_id = $_SESSION["user_id"];
    $user_name = ucwords($_SESSION["full_name"]);
    // $application_id = 110;
    // $application_id = $_POST["application_id"];
    $application_id = $_GET["application_id"];
    // echo $application_id;

    $data = array();

    (isset($_SESSION['loggedinGeneral']))? $table_user="user": $table_user="admin";
    $query = "SELECT cl_left FROM ".$table_user." WHERE id='{$user_id}'";
    $result=mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($result)){
      $cl_left = $row["cl_left"];
    }

    (isset($_SESSION['loggedinGeneral']))? $table_name="history": $table_name="admin_history";

    $query = "SELECT * FROM ".$table_name." WHERE id='{$application_id}'";
    $result=mysqli_query($conn,$query);
    $number_of_rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_assoc($result)){
      $apply_time = $row["apply_time"];
      $from_date = $row["from_date"];
      $to_date = $row["to_date"];
      $half_day = $row["half_day"];
      $reason = $row["reason"];

      // echo $apply_time ." ".$from_date." ".$to_date." ".$half_day." ".$reason;
      $is_admin = (isset($_SESSION['loggedinGeneral']))? 0: 1;
      // $application_id = $is_admin."".$user_id."".$application_id."_".date_timestamp_get(new DateTime ($apply_time));
      $application_id = $is_admin."".$user_id."_".$application_id;
      $shift = "";

      if($to_date == "0000-00-00"){
        (is_null($half_day))?null: $shift = ucwords($half_day);
      }

      $cl = $this->formatDate($from_date)." ".$shift;
      $cl .= ($to_date == "0000-00-00")?null:" - ".$this->formatDate($to_date);

      }

      $apply_time = $this->formatDateTo12hour($apply_time);

      array_push($data, $department, $application_id, $user_name, $cl,$cl_left, $apply_time);
      $_SESSION['application_details'] = array($department, $application_id, $user_name, $cl,$cl_left, $apply_time);
      return $data;
    }

  function ImprovedTable($data)
  {
      $data_left = array("Department", "Application Id", "Applicant Name", "CL", "CL Left", "Apply Time");
      // Column widths
      $w = array(80,80);

      $this->Ln();
      // Data
      $this->SetFont('Arial','',12);
      $i = 0;
      foreach($data as $row)
      {
          $this->Cell($w[0],6,$data_left[$i],1,0);
          $this->Cell($w[0],6,$row,1,0);
          $i++;
          $this->Ln();
      }
      // // Closing line
      $this->Cell(array_sum($w),0,'','T');
    }
}

  $pdf = new PDF();
  $pdf->AliasNbPages();
  // Data loading
  $data = $pdf->LoadData($connection);

  $pdf->AddPage();
  $pdf->PageBody();

  //create table
  $pdf->SetFont('Arial','',12);
  $pdf->ImprovedTable($data);

  $pdf->Output('D', 'cl.pdf');

 ?>
