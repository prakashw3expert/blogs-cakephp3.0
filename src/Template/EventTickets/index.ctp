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
        $row = array();
        $row[] = $ticket->id;
        $row[] = $ticket->name;
        $row[] = $ticket->quantity;
        $row[] = $ticket->price;
        $row[] = $ticket->sale_start_date . ' - ' . $ticket->sale_start_date;
        $row[] = $ticket->type;
        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), '#', array('class' => 'btn btn-xs green editTicket', 'escape' => false));
        
        $links .= $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $ticket['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);


        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
}
$this->append('table_row', $this->Html->tableCells($rows));





$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

$tableHeaders = array();
$tableHeaders[] = array('Ticket ID' => array('style2' => 'width:5%'));
$tableHeaders[] = array('Ticket name' => array('style2' => 'width:70%'));
$tableHeaders[] = array('Quantity available' => array('style2' => 'width:70%'));
$tableHeaders[] = array('Price' => array('style' => 'style2:70%'));
$tableHeaders[] = array('Sales Date' => array('style' => 'style2:70%'));
$tableHeaders[] = array('Type' => array('style' => 'style2:70%'));

$tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if ($eventTickets->count() > 0) {
    foreach ($eventTickets->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();
        $row = array();
        $row[] = $ticket->id;
        $row[] = $ticket->name;
        $row[] = $ticket->quantity;
        $row[] = $ticket->price;
        $row[] = $ticket->sale_start_date . ' - ' . $ticket->sale_start_date;
        $row[] = $ticket->type;
        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), '#', array('class' => 'btn btn-xs green editTicket', 'escape' => false));
        
        $links .= $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $ticket['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);


        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
} else {
    $row[] = array(__('You haven\'t purchased tickets yet!!!'), array('class' => 'text-center noresult', 'colspan' => 9));
    $rows[] = $row;
}


$this->start('search');

echo $this->Form->create($eventTickets, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-9">{{content}}</div>', 'label' => null],
    'placeholder' => 'Search by Blog Title'
]);



$this->end();
$this->assign('searchActionRow', "col-md-3");
$btn = $this->Form->button('Search', array('class' => 'btn btn-default pull-right'));
$this->assign('btn', $btn);
if (!empty($rows)) {
    $this->append('table_row', $this->Html->tableCells($rows));
}

//$actionBtns = $this->Html->link('Export', ['export' => true], ['class' => 'btn btn-icon waves-effect waves-light btn-info']);
$actionBtns .= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);



$this->assign('actionBtns', $actionBtns);





