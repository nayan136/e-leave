<?php

require_once "sidebar.php";

 ?>

 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>
   <h2 class='center_text'>Report</h2>
   <table class="ui celled unstackable structured table">
     <tbody>
       <tr>
         <td>1</td>
         <td>List of Heads</td>
         <td></td>
         <td id="button1" class="center aligned">
           <button class=" positive ui button" onclick="head_list()">
             <i class="ui print icon"></i>
             Download
           </button>
         </td>

       </tr>
       <tr>
         <td>2</td>
         <td>Department Wise CL List</td>
         <td>
           <?php
             $sql="SELECT department FROM admin WHERE privilege='admin'";
             $sql = mysqli_query($connection, $sql);
              if(mysqli_num_rows($sql)){
              $select= '<select name="select" class="ui dropdown">';
              while($rs=mysqli_fetch_array($sql)){
                 $select.='<option value="'.$rs['department'].'">'.ucwords($rs['department']).'</option>';
              }
            }
            $select.='</select>';
            echo $select;
            ?>
         </td>
         <td id="button2" class="center aligned">
           <button class=" positive ui button" onclick="cl_list()">
             <i class="ui print icon"></i>
             Download
           </button>
         </td>
       </tr>

     </tbody>

   </table>

 </div>
 </div>

 </div>
 </div>

 </div>
<script type="text/javascript" src="../js/report_superadmin.js"></script>
 <script type="text/javascript" src="../js/sidebar.js"></script>
 </body>
 </html>
