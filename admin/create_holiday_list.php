<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="../semantic/semantic.min.css"/>
  <link href='../fullcalender/fullcalendar.min.css' rel='stylesheet' />
  <link href='../fullcalender/fullcalendar.print.min.css' rel='stylesheet' media='print' />

   <script type="text/javascript" src="../semantic/semantic.min.js"></script>
  <script src='../js/moment.min.js'></script>
  <script src='../js/jquery.js'></script>
  <script src='../js/fullcalendar.min.js'></script>

     <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
</head>

</body>

  <div id="otherstuff" class="ui grid">
     <div class="sixteen wide column row menu tablet or lower hidden">
<!--    <div class="ui top attached inverted menu">
      <div class="item">
        <h1>Dashboard</h1>
      </div>
      
    </div> -->

      <div class="ui top attached inverted segment">
        <div class="ui inverted secondary menu">
            <div class="right menu">
          <a class="ui item" href="../logout.php">
            Logout
          </a>
          <a class="ui item" href="#"></a>
        </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>

    <div id="sidebar" class="ui sidebar inverted vertical menu">

    <a class="item" href="cl_details.php">Applications Detials</a>
    <a class="item" href="create_user.php">Create User</a>
    <a class="item" href="check_all_users.php">Users List</a>
    <a class="item" href="pending_application.php">Pending List</a>
       <a class="ui item" href="../logout.php">Logout</a>
  </div>

  <div class="pusher">
    
    <div class="ui inverted vertical left fixed menu tablet or lower hidden">
  <br>
  <br>
  <br>
    <a class="item" href="cl_details.php">Applications Detials</a>
    <a class="item" href="create_user.php">Create User</a>
    <a class="item" href="check_all_users.php">Users List</a>
      <a class="item" href="pending_application.php">Pending List</a>
    </div>

<!-- <div class="ui sidebar visible fixed inverted main menu screen tablet mobile only"> -->
  
    
    <div class="">
      <div class="ui grid">
        <div class="three wide column tablet or lower hidden">
          
        </div>

        <div class="tablet or mobile only sixteen wide column row">
          <div class="ui top attached inverted menu">
            <div class="item">
              <h1 id="nav_header"><a href="cl_details.php">Dashboard</a></h1>
            </div>
            
            <div class="right menu">
            <div class="item">
              <a class="launch icon item sidebar-toggle">
                <i class="big sidebar icon"></i>
              </a>
            </div>
          </div>
          </div>

                    
        </div>

  <!-- ************************************************************ -->


      <div class="ui container">
        <div class="ui grid">
          <div class="ui sixteen column">
            <div id="calendar"></div>
          </div>
        </div>
      </div>

  
      </div>

      </div>
  
  </div>

  <script type="text/javascript" src="../js/create_holiday_list.js"></script>
</body>
</html>