<?php

function currentDate($originalDate){
  $newDate = date("d/m/Y", strtotime($originalDate));
  return $newDate;
}

echo currentDate();

 ?>
