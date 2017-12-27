<?php

  require_once "sidebar.php";
  require_once "../db.php";

 ?>

   <div class="one wide column">
   </div>
   <div class="eleven wide computer sixteen wide mobile column">
     <div class="container_margin">
       <br>
       <h2 class="center_text">Search Application</h2>
       <div class="ui action input">
         <input class="search_application" placeholder="Search by Application id..." type="text">
         <button class="button_search" class="ui icon button">
           <i class="search icon"></i>
         </button>
       </div>

       <div class="application_table"></div>
    </div>
  </div>
  <div class="four wide column">
  </div>

</div>
<script type="text/javascript" src="../js/check_application.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>
</html>
