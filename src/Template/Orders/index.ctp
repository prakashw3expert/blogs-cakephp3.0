<?php



$this->extend('/Common/index');
$this->Html->addCrumb('Tickets', null);

$tableHeaders = array();
$tableHeaders[] = array('Ticket ID' => array('style2' => 'width:10%'));
// $tableHeaders[] = array('Ticket name' => array('style2' => 'width:10%'));
$tableHeaders[] = array('Event name' => array('style2' => 'width:20%'));
$tableHeaders[] = array('Organiser' => array('style2' => 'width:20%'));
$tableHeaders[] = array('Venue' => array('style2' => 'width:20%'));
$tableHeaders[] = array('No. Of tickets' => array('style2' => 'width:10%'));
$tableHeaders[] = array('Price' => array('style2' => 'style:10%'));
$tableHeaders[] = array('Event Date' => array('style2' => 'style:10%'));
$tableHeaders[] = array('Booking Date' => array('style2' => 'style:10%'));
$tableHeaders[] = '';

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if ($orders->count() > 0) {
    foreach ($orders->toArray() as $key => $ticket) {
        //$listOne = $listOne->toArray();
        
        $row = array();
        $row[] = $ticket->id;
        //$row[] = $ticket->event_ticket->name;
        $row[] = $this->Html->link($ticket->event->title,['controller' => 'events','action' => 'view','slug' => $ticket->event->slug],['target' =>"_blank"]);
        $row[] = $ticket->event->organizer;
        $row[] = $ticket->event->venue;
        $row[] = $ticket->quantity;
        $row[] = ($ticket->amount) ? $ticket->amount : 'Free';
        $row[] = $this->element('event_date', ['event' => $ticket->event]);
        $row[] = $ticket->created;

        $links = $this->Html->link(__('View'), array('action' => 'view', $ticket->id));
        
        // $links .= $this->Html->link(__('Download'), array('action' => 'edit', $ticket->id), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));


        $row[] = array($links, array('class' => 'text-center'));

        $rows[] = $row;
    }
} else {
    $row[] = array(__('You haven\'t purchased tickets yet!!!' , $modelClass), array('class' => 'text-center noresult', 'colspan' => 9));
    $rows[] = $row;
}


if (!empty($rows)) {
    $this->append('table_row', $this->Html->tableCells($rows));
}






