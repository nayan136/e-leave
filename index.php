<!DOCTYPE html>
<html>
<head>
  <title></title>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.css"/> -->
  <link rel="stylesheet" href="semantic/semantic.min.css"/>
  <link rel="stylesheet" href="css/style.css"/>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="semantic/semantic.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script> -->

    <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

  </head>
<body>

  <?php
    session_start();
    if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
        header("Location: admin/cl_details.php");
        die();
    }elseif (isset($_SESSION['loggedinGeneral']) && $_SESSION['loggedinGeneral'] == true) {
        header('Location: history.php');
        die();
    }elseif(isset($_SESSION['loggedAsSuperadmin']) && $_SESSION['loggedAsSuperadmin'] == true){
      header("Location: super_admin/admin_list.php");
      die();
    } else {

   ?>
  <div class="ui grid">
    <div class="six wide column">

    </div>

    <div class="four wide computer sixteen wide tablet sixteen wide mobile column">
      <div>
      <img id="border_padding" class="ui image" src="http://cottonuniversity.ac.in/img/logo.png">
    </div>
     <form id="border_padding" class="ui form" action="login.php" method="post">
        <!-- <h1>Log In</h1> -->
        <div class="field">
          <div class="ui left icon input">
              <i class="user icon"></i>
              <input name="username" placeholder="Username" type="text">
          </div>
        </div>

        <div class="field">
          <div class="ui left icon input">
              <i class="lock icon"></i>
              <input name="password" placeholder="Password" type="password">
          </div>
        </div>
        <input type="submit" value="Log In" class="fluid positive ui button" name="login_form" />
      <!--  <div class="ui submit button">Submit</div> -->
        <div class="ui error message"></div>
          <?php
          // $login="";
          //   if(!empty($_GET["login"])){
          //     $login = $_GET["login"];
          //     }

            if(isset($_SESSION["login_failed"])){
              if($_SESSION["login_failed"]){
                unset($_SESSION["login_failed"]);
            ?>

            <div class="ui negative message">username or password is mismatched</div>

            <?php
              }

            }
          }
          ?>

     </form>
    </div>

    <div class="six wide column">

    </div>
  </div>
   <script type="text/javascript" src="js/form_validation.js"></script>
</body>
</html>
