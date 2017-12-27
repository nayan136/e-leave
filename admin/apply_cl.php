
<?php
  require_once "includes/sidebar.php";
  require_once("../db.php");
  require_once("../Mobile_Detect.php");

  $user_id = $_SESSION["user_id"];
  $device_type = $_SESSION['device_type'];

  function application_report($date,$user_id,$connection){
    $query = "SELECT id FROM admin_history WHERE user_id='{$user_id}' AND from_date='{$date}'";
    $get_application_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($get_application_id)) {
      $application_id = $row["id"];
    }
    header("Location: ../report/user_application_details.php?application_id=".$application_id);
  }

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
          $date[] = $date1->format("Y-m-d");
        }

        // print_r($date);
        // echo "<br>";

    return $date;

  }
?>

<div class="one wide column">
</div>
   <div class="eleven wide computer sixteen wide mobile column">
 <div class="container_margin">
   <?php if($device_type === 'computer'){
      echo "<br>";
    } 
   ?>

  <?php

    function isWeekend($date) {
        return (date('N', strtotime($date)) == 7);
    }

    function currentDate(){
       return date("Y-d-m");
    }


    function getIP(){
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
          $ip = $_SERVER['REMOTE_ADDR'];
      }

      return $ip;
    }

    function isMobile(){
      $detect = new Mobile_Detect;
      $mobile = $detect->getUserAgent();
      $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
      $device_details = $deviceType ."[".$mobile."]";
      return $device_details;
    }

    if(isset($_POST["apply_form_halfday"])){
      if(!empty($_POST["half_day_date"]) && !empty($_POST["reason"])){
        // if($_POST["station_leave"]){
        //   if(!empty($_POST["address"]) && !empty($_POST["reason"])){

        //   }
        // }
        $from_date_for_half_day = $_POST["half_day_date"];
        $half_day = $_POST["half_day"];
        $reason = $_POST["reason"];
        $ip = getIP();
        $device_details = isMobile();


        $user_id = mysqli_real_escape_string($connection, $user_id);
        $ip = mysqli_real_escape_string ($connection, $ip);
        $device_details = mysqli_real_escape_string ($connection, $device_details);
        $from_date_for_half_day = mysqli_real_escape_string ($connection, $from_date_for_half_day);
        $reason = mysqli_real_escape_string($connection, $reason);
        $half_day = mysqli_real_escape_string ($connection, $half_day);

        $check_duplicate = "SELECT id FROM admin_history
                            WHERE user_id='{$user_id}' AND
                            (IF(to_date='0000-00-00', from_date='{$from_date_for_half_day}','{$from_date_for_half_day}'>=from_date
                               AND '{$from_date_for_half_day}'<= to_date)) ";
        $check_duplicate_search = mysqli_query($connection, $check_duplicate);
        $duplicate_found = mysqli_num_rows($check_duplicate_search);
        
        if($duplicate_found >0){
          $check_duplicate_shift = "SELECT * FROM admin_history WHERE user_id='{$user_id}' AND
                                  (IF(to_date='0000-00-00', from_date='{$from_date_for_half_day}'
                                    ,'{$from_date_for_half_day}'>=from_date AND '{$from_date_for_half_day}'<= to_date))
                                  AND
                                   half_day='{$half_day}'";
          $check_duplicate_search = mysqli_query($connection, $check_duplicate_shift);
          $duplicate_found = mysqli_num_rows($check_duplicate_search);
        }
        // echo $duplicate_found;
        // die();

        if($duplicate_found == 0){
          if(isset($_POST["station_leave"]) && $_POST["station_leave"]){
            if(empty($_POST["address"]) && empty($_POST["phone"])){
              $query = "";
            }else{
              $query = "INSERT INTO admin_history";
              $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason, half_day, address, phone) ";
              $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', 0.5, '{$from_date_for_half_day}', '', now(), '',
                    'pending', '{$reason}','{$half_day}','{$_POST["address"]}','{$_POST["phone"]}')"; 
            }
          }else{
            $query = "INSERT INTO admin_history";
            $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason, half_day) ";
            $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', 0.5, '{$from_date_for_half_day}', '', now(), '',
                  'pending', '{$reason}','{$half_day}')";  
            
          }
          if(!empty($query)){
            $insert_apply_form = mysqli_query($connection, $query);
          }         
        
        }
          //confirmQuery($insert_apply_form);
          if (mysqli_affected_rows($connection)>0) {

            application_report($from_date_for_half_day, $user_id, $connection);
            // header("Location: admin_history.php");
          }else{
            echo "Failed";
          }
      }else{
        echo '<div class="ui negative message">Form is not completely filled</div>';

      }
    }

    if(isset($_POST["apply_form_fullday"])){
      if(!empty($_POST["full_day_date"]) && !empty($_POST["reason"])){
        $from_date_for_full_day = $_POST["full_day_date"];

        $reason = $_POST["reason"];
        $ip = getIP();
        $device_details = isMobile();

        $user_id = mysqli_real_escape_string($connection, $user_id);
        $ip = mysqli_real_escape_string ($connection, $ip);
        $device_details = mysqli_real_escape_string ($connection, $device_details);
        $from_date_for_full_day = mysqli_real_escape_string ($connection, $from_date_for_full_day);
        $reason = mysqli_real_escape_string($connection, $reason);

        $check_duplicate = "SELECT id FROM history
                            WHERE user_id='{$user_id}' AND
                            (IF(to_date='0000-00-00', from_date='{$from_date_for_full_day}','{$from_date_for_full_day}'>=from_date
                               AND '{$from_date_for_full_day}'<= to_date)) ";
        $check_duplicate_search = mysqli_query($connection, $check_duplicate);
        $duplicate_found = mysqli_num_rows($check_duplicate_search);

        if($duplicate_found == 0){
          if(isset($_POST["station_leave"]) && $_POST["station_leave"]){
            if(empty($_POST["address"]) && empty($_POST["phone"])){
              $query = "";
            }else{
              $query = "INSERT INTO admin_history";
              $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason, address, phone) ";
              $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', 1, '{$from_date_for_full_day}', '', now(), '',
                    'pending', '{$reason}','{$_POST["address"]}','{$_POST["phone"]}')";
            }
          }else{
            $query = "INSERT INTO admin_history";
            $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason) ";
            $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', 1, '{$from_date_for_full_day}', '', now(), '',
                  'pending', '{$reason}')";
          }
          // echo $query;
          // die();
          if(!empty($query)){
            $insert_apply_form = mysqli_query($connection, $query);
          }  
        }
          //confirmQuery($insert_apply_form);
          if (mysqli_affected_rows($connection)>0) {
            application_report($from_date_for_full_day, $user_id, $connection);
            // header("Location: admin_history.php");
          }else{
            echo "Failed";
          }

      }else{

        echo '<div class="ui negative message">Form is not completely filled</div>';
      }
    }

    if(isset($_POST["apply_form"])){

      $from_date = $_POST["from_date"];
      $to_date = $_POST["to_date"];

      $reason = $_POST["reason"];

      $begin = $from_date;
      $end = $to_date;
      // $begin = new DateTime($from_date);
      // $end = new DateTime($to_date);
      // $interval = $begin->diff($end);
      // $date_diff = $interval->format("%d")+1;
      //echo $interval->format('%R%a days');
      // $date_interval = DateInterval::createFromDateString('1 day');
      // $period = new DatePeriod($begin, $date_interval, $end);

      // foreach($period as $date){
  // 				if(isWeekend($date->format('Y-m-d'))){
  // 					$date_diff --;
  // 				}
      // }


      $device_details = isMobile();

      //store temp
      // if(isset($_SESSION["from_date"]) || isset($_SESSION["to_date"]) || isset($_SESSION["cl_days_leave"]) || isset($_SESSION["reason"])){
      // 	unset($_SESSION["from_date"]);
      // 	unset($_SESSION["to_date"]);
      // 	unset($_SESSION["cl_days_leave"]);
      // 	unset($_SESSION["reason"]);
      // }
      // $_SESSION["from_date"] = $from_date;
      // $_SESSION["to_date"] = $to_date;
      // $_SESSION["cl_days_leave"] = $cl_days_leave;
      // $_SESSION["reason"] = $reason;


      if(!empty($from_date) && !empty($to_date) && !empty($reason)){

        if($end > $begin){

        $period = allDates($begin,$end);
        $date_diff = count($period);
        if($date_diff <= 4){
          
          $query = "SELECT cl_left FROM admin WHERE id='{$user_id}'";
          $search_days_left = mysqli_fetch_assoc(mysqli_query($connection, $query));
          $days_left = $search_days_left["cl_left"];
  
          if($days_left > $date_diff){
            $ip = getIP();
  
            $user_id = mysqli_real_escape_string($connection, $user_id);
            $ip = mysqli_real_escape_string ($connection, $ip);
            $device_details = mysqli_real_escape_string ($connection, $device_details);
            $date_diff = mysqli_real_escape_string ($connection, $date_diff);
            $from_date = mysqli_real_escape_string ($connection, $from_date);
            $to_date = mysqli_real_escape_string ($connection, $to_date);
            $reason = mysqli_real_escape_string($connection, $reason);
  
            // $date_interval = DateInterval::createFromDateString('1 day');
            // $period = new DatePeriod($begin, $date_interval, $end);
            $no_duplicate = true;
            foreach($period as $date){
              // echo $date;
              // echo "<br>";
  
              $check_duplicate = "SELECT id FROM admin_history WHERE user_id='{$user_id}'AND from_date='{$date}'";
              $check_duplicate_search = mysqli_query($connection, $check_duplicate);
              $duplicate_found = mysqli_num_rows($check_duplicate_search);
              if($duplicate_found > 0){
                $no_duplicate = false;
                // echo $no_duplicate;
                // die();
  
              }else{
                // echo $no_duplicate;
                // die();
              }
            }
  
  
            if($no_duplicate){
              if(isset($_POST["station_leave"]) && $_POST["station_leave"]){
                if(empty($_POST["address"]) && empty($_POST["phone"])){
                  $query = "";
                }else{
                  $query = "INSERT INTO admin_history";
                  $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason, address, phone) ";
                  $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', '{$date_diff}', '{$from_date}', '{$to_date}', now(), '',
                        'pending', '{$reason}','{$_POST["address"]}','{$_POST["phone"]}')";
                }
              }else{
                $query = "INSERT INTO admin_history";
                $query .= "(user_id, ip, device, cl_days_leave, from_date, to_date, apply_time, admin_check_time,status, reason) ";
                $query .= "VALUES ('{$user_id}','{$ip}', '{$device_details}', '{$date_diff}', '{$from_date}', '{$to_date}', now(), '',
                      'pending', '{$reason}')";
              }
              if(!empty($query)){
                $insert_apply_form = mysqli_query($connection, $query);
              }  
            }
            //confirmQuery($insert_apply_form);
            if (mysqli_affected_rows($connection)>=0) {
              application_report($from_date, $user_id, $connection);
              // header("Location: admin_history.php");
            }else{
              echo "Failed";
            }
          }else{
          ?>
  
          <div class="ui negative message">You are applying more than CL left</div>       

        <?php
        }
       }else{
        ?>
        <div class="ui negative message">Total CL can't be more than 5 days</div>       

        <?php
       }
      }
        else{
      ?>

       <div class="ui negative message">Starting date is wrong</div>

      <?php

      }
    }else{

      ?>
    <!-- 	<div class="ui negative message">
      <i class="close icon"></i>
      <div class="header">
        We're sorry we can't apply that discount
      </div>
      <p>That offer has expired
    </p></div> -->

      <div class="ui negative message">Form is not completely filled</div>

    <?php
    //echo $_SESSION["from_date"]."***".$from_date;

  }} ?>
  <br>


<div class="sixteen wide column">
  <h2 class="center_text">Application Form</h2>
    <div id="context1">
      <div class="ui top attached tabular menu">
        <a class="item active" data-tab="first">Half Day</a>
        <a class="item" data-tab="second">Full Day</a>
        <a class="item" data-tab="third">Multiple Days</a>
      </div>
    </div>
    <div class="ui bottom attached tab active" data-tab="first">
          <form class="ui form segment" action="apply_cl.php" method="post">

          <div class="field">
            <label>Date</label>
            <div class="ui calendar" id="rangestart">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text"  name="half_day_date" <?php echo "value='".currentDate()."'"; ?>>
                </div>
              </div>
          </div>
            <div class="inline fields">
                <label>Request Shift of Leave </label>
                <div class="field">
                  <div class="ui radio checkbox">
                    <input name="half_day" type="radio" checked="checked" value="morning">
                    <label>Morning</label>
                  </div>
                </div>
                <div class="field">
                  <div class="ui radio checkbox">
                    <input name="half_day" type="radio" value="evening">
                    <label>Evening</label>
                  </div>
                </div>
              </div>

          <div class="field">
            <label>Purpose</label>
            <textarea name="reason"><?php //if(isset($_SESSION["reason"])) echo $_SESSION["reason"]; ?></textarea>
          </div>
          <div class="ui checkbox margin_bottom address">
            <input type="checkbox" name="station_leave">
            <label>Station Leave</label>
          </div>

          <!-- Contact Details -->
          <div class="contact margin_bottom">
            <div class="field">
              <label>SL Address</label>         
              <input type="text" name="address">             
            </div>
            <div class="field">
              <label>Phone Number</label>         
              <input type="text" name="phone">             
            </div>
          </div>
          
          <input type="submit" value="Submit" name="apply_form_halfday" class="fluid positive ui button">
     
        </form>
    </div>
    <div class="ui bottom attached tab " data-tab="second">
        <form class="ui form segment" action="apply_cl.php" method="post">

          <div class="field">
            <label>Date</label>
            <div class="ui calendar" id="rangestart1">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text"  name="full_day_date" <?php echo "value='".currentDate()."'"; ?>>
                </div>
              </div>
          </div>

          <div class="field">
            <label>Purpose</label>
            <textarea name="reason"><?php //if(isset($_SESSION["reason"])) echo $_SESSION["reason"]; ?></textarea>
          </div>
          <div class="ui checkbox margin_bottom address">
            <input type="checkbox" name="station_leave">
            <label>Station Leave</label>
          </div>

          <!-- Contact Details -->
          <div class="contact margin_bottom">
            <div class="field">
              <label>SL Address</label>         
              <input type="text" name="address">             
            </div>
            <div class="field">
              <label>Phone Number</label>         
              <input type="text" name="phone">             
            </div>
          </div>

          <input type="submit" value="Submit" name="apply_form_fullday" class="fluid positive ui button">

        </form>
    </div>
    <div class="ui bottom attached tab " data-tab="third">
          <form class="ui form segment" action="apply_cl.php" method="post">
          <br>
          <div class="ui two column stackable grid">
            <div class="coumn">
              <div class="field">
                <label>Starting date</label>
                <div class="ui calendar" id="rangestart2">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text"  name="from_date" <?php echo "value='".currentDate()."'"; ?>>
                  </div>
                </div>
              </div>
            </div>
            <div class="coumn">
              <div class="field">
                <label>End date</label>
                <div class="ui calendar" id="rangeend">
                  <div class="ui input left icon">
                    <i class="calendar icon"></i>
                    <input type="text" name="to_date">
                  </div>
                </div>
              </div>
            </div>
          </div>           
          <br>
          <div class="field">
            <label>Purpose</label>
            <textarea name="reason"><?php //if(isset($_SESSION["reason"])) echo $_SESSION["reason"]; ?></textarea>
          </div>
          <div class="ui checkbox margin_bottom address">
            <input type="checkbox" name="station_leave">
            <label>Station Leave</label>
        </div>

          <!-- Contact Details -->
          <div class="contact margin_bottom">
            <div class="field">
              <label>SL Address</label>         
              <input type="text" name="address">             
            </div>
            <div class="field">
              <label>Phone Number</label>         
              <input type="text" name="phone">             
            </div>
          </div>

          <input type="submit" value="Submit" name="apply_form" class="fluid positive ui button">
        </form>
    </div>



  </div>
</div>
</div>
</div>
</div>
</div>



<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<script type="text/javascript" src="../js/apply_leave_form.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
