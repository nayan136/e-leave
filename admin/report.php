<?php

require_once "includes/sidebar.php";
require_once "../db.php";

$device_type = $_SESSION['device_type'];

 ?>
 <div class="one wide column">
 </div>
  	<div class="eleven wide computer sixteen wide mobile column">
 	<div class="container_margin">
 		<?php if($device_type === 'computer'){
 			echo "<br>";
 		} ?>

      <h2 class='center_text'>Report</h2>

   <table class="ui unstackable celled table">
     <tbody>
       <tr>
         <td>1</td>
         <td>Daily Report</td>
         <td>

 							<div class="ui calendar" id="rangestart">
 							    <div class="ui input left icon">
 							      <i class="calendar icon"></i>
 							      <input type="text"  name="from_date" <?php $date = date("Y/M/d"); echo "value='".$date."'"; ?>/>
 							    </div>

 						</div>

             <td id="button1" class="center aligned">
               <div>
                   <button class=" positive ui button" onclick="daily_report()">
                     <i class="ui print icon"></i>
                     Download
                   </button>
               </div>
             </td>

         </td>

       </tr>
       <tr>
         <td>2</td>
         <td>List of all users</td>
         <td></td>
         <td id="button2" class="center aligned">
           <button class=" positive ui button" onclick="user_list()">
             <i class="ui print icon"></i>
             Download
           </button>
         </td>
       </tr>

       <tr>
         <td>2</td>
         <td>History</td>
         <td></td>
         <td id="button3" class="center aligned">
           <button class=" positive ui button" onclick="history_list()">
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
 <script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
 <script type="text/javascript" src="../js/report.js"></script>
 <script type="text/javascript" src="../js/sidebar.js"></script>
 </body>
 </html>
