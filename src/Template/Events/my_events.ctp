<?php

$this->extend('/Common/index');
$this->Html->addCrumb($modelClass, null);
$this->assign('title', "My Events");
//$tableHeaders[] = '';
//$tableHeaders[] = array($this->Paginator->sort(__('id'), 'ID') => array('class' => 'id_class text-center', 'style2' => 'width:5%'));

$tableHeaders[] = array($this->Paginator->sort(__('title'), 'Event Title') => array('class' => 'id_class text-left', 'style2' => 'width:5%'));
//$tableHeaders[] = array(null => array('style2' => 'width:30%'));

$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('class' => 'text-center', 'style2' => 'width:10%'));
$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Date') => array('style2' => 'width:30%'));

$tableHeaders[] = array($this->Paginator->sort(__('view_count'), 'Views') => array('style2' => 'width:30%'));
$tableHeaders[] = 'Bookings';

$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'style2' => 'width:5%'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if ($events->count() > 0) {
    
    foreach ($events->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        $row = array();
        //$row[] = array($listOne['id'], array('class' => 'text-center'));
        $label = null;
        if ($listOne['featured'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect waves-light btn-primary btn-xs" title="Featured"><i class="fa fa-star"></i></span> ';
        }
        if ($listOne['promoted'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect btn-default waves-light btn-xs" title="Promoted"><i class="fa fa-heart-o"></i></span> ';
        }
        $label .= " ".$this->Awesome->image('Events/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix m-r-10','type' => 'thumbnail']);
        $row[] = $label . $this->Html->link($listOne['title'],['controller' => 'events','action' => 'viewDetails','slug' => $listOne['slug']]);

        $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => 'text-center'));
        $row[] = $this->element('event_date',['event' => $listOne]).' '.$this->element('event_time',['event' => $listOne]);
        $row[] = array($listOne['view_count'], array('class' => 'text-center'));
        $row[] = array($this->cell('Event::bookingsCount', ['event_id' => $listOne['id']], ['cache1' => true]), array('class' => 'text-center'));

        $links = $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
} else {
    $row[] = array(__('You didn\'t added events yet!', $modelClass), array('class' => 'text-center noresult', 'colspan' => 9));
    $rows[] = $row;
}


$this->start('search');

echo $this->Form->create($events, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('keyword', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-9">{{content}}</div>', 'label' => null],
    'placeholder' => 'Search by Title'
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



