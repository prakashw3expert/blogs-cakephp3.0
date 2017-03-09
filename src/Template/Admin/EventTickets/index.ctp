<?php
$tableHeaders = array();
$tableHeaders[] = array('Ticket ID' => array('style2' => 'width:5%'));
$tableHeaders[] = array('Ticket name' => array('style2' => 'width:70%'));
$tableHeaders[] = array('Quantity available' => array('style2' => 'width:70%'));
$tableHeaders[] = array('Price' => array('style' => 'style2:70%'));
$tableHeaders[] = array('Sales Date' => array('style' => 'style2:70%'));
$tableHeaders[] = array('Type' => array('style' => 'style2:70%'));

$tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));


$rows = array();
if (!empty($eventTickets)) {
    foreach ($eventTickets as $key => $ticket) {
        $ticket->sale_start_date = $this->Awesome->date($ticket->sale_start_date).' '.$this->Awesome->date($ticket->start_time,'h:i A');
        $ticket->sale_end_date = $this->Awesome->date($ticket->sale_end_date).' '.$this->Awesome->date($ticket->end_time,'h:i A');
    }
}
echo json_encode($eventTickets);

