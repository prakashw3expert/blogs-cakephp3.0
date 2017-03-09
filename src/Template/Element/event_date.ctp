<?php 
if($this->Awesome->date($event['start_date'], 'Y') != $this->Awesome->date($event['end_date'], 'Y')){
  $date =  $this->Awesome->date($event['start_date'], 'd M Y').' - '.$this->Awesome->date($event['end_date'], 'd M Y');
}
else if(strtotime($event['start_date']) == strtotime($event['end_date'])){
   $date =  $this->Awesome->date($event['start_date'], 'd M Y');
   
}
else{
    if($this->Awesome->date($event['start_date'], 'm') == $this->Awesome->date($event['end_date'], 'm')){
      $date =  $this->Awesome->date($event['start_date'], 'd').' - '.$this->Awesome->date($event['end_date'], 'd M Y');
    }
    else{
      $date =  $this->Awesome->date($event['start_date'], 'd M').' - '.$this->Awesome->date($event['end_date'], 'd M Y');
    }
   
}
echo $date;
?>

