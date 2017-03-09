<?php 
if(strtotime($event['start_time']) == strtotime($event['end_time'])){
  $date = $this->Awesome->date($event['start_time'], 'h:i A');
}
else{
 $date = $this->Awesome->date($event['start_time'], 'h:i A').' - '.$this->Awesome->date($event['end_time'], 'h:i A');
}
echo $date;
?>

