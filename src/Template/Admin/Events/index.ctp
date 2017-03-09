<?php
$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

// $tableHeaders[] = array($this->Form->checkbox($modelClass . '.id.', array('class' => 'group-checkable', 'data-set' => "#psdata_table .checkboxes", 'hiddenField' => false)) => array('class' => 'check_box'));


$tableHeaders[] = array($this->Paginator->sort(__('title'), 'Title') => array('class' => 'id_class text-left', 'style' => 'width:40%','data-tablesaw-sortable-col data-tablesaw-priority'=>"persist"));
$tableHeaders[] = array($this->Paginator->sort(__('start_date'), 'Event Date & Time') => array('style' => 'width:30%'));

$tableHeaders[] = array($this->Paginator->sort(__('user.name'), 'User Name') => array('class' => 'id_class text-center1', 'style' => 'width:15%'));


$tableHeaders[] = array($this->Paginator->sort(__('view_count'),'Views') => array('class' => 'text-center', 'style' => 'width:5%'));


$tableHeaders[] = array('Bookings' => array('class' => 'text-center', 'style' => 'width:5%'));

$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('class' => 'text-center', 'style' => 'width:10%'));

$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'style' => 'width:5%'));

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
        $eventTitlte = $listOne['title'];
        $row = array();
        // $row[] = $this->Form->checkbox('id.' . $key, array('class' => 'checkboxes', 'value' => $listOne['id'], 'hiddenField' => false));
        //$row[] = array($listOne['id'], array('class' => 'text-center'));
        $label = null;
        
        $label .= $this->Awesome->image('Events/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix m-r-10','type' => 'thumbnail']);
        if($listOne['status']){
            $row[] = $label . $this->Html->link($eventTitlte.' <i class="fa fa-external-link" aria-hidden="true"></i>',['prefix' => false,'controller' => 'events','action' => 'view','slug' => $listOne['slug']],['escape' => false,'target' => '_blnak']);
        }
        else{
            $row[] = $label . $eventTitlte;
        }

        $row[] = $this->element('event_date',['event' => $listOne]).' '.$this->element('event_time',['event' => $listOne]);


        if($listOne['user']['role_id'] == 1){
         $usrLink = array('controller' => 'users','action' => 'view','slug' => $listOne['user']['slug']);
     }
     else if($listOne['user']['role_id'] == 2){
        $usrLink = array('controller' => 'authors','action' => 'view', $listOne['user']['slug']);
    }
    else{
        $usrLink = '#';
    }
    $row[] = $this->Html->link($listOne['user']['name'],$usrLink,['target' => '_blank']);
    $row[] = array($listOne['view_count'], array('class' => 'text-center'));
    $row[] = array($this->cell('Event::bookingsCount', ['event_id' => $listOne['id']], ['cache1' => true]), array('class' => 'text-center'));
    $row[] = array($this->Form->checkbox('status', [
        'checked' => $listOne['status'],
        'class' => "change_status",
        'data-size'=>"small",
        'data-plugin' => 'switchery',
        'data-model' => $modelClass,
        'data-id' => $listOne['id'],
        'id' => "event_".$listOne['id'],
        'data-value' => $listOne['status']
        ]), array('class' => 'text-center'));

    $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'view', $listOne['slug']), array('class' => 'btn btn-xs green', 'escape' => false));
    $links .= $this->Form->postLink(
        '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



    $row[] = array($links, array('class' => 'text-center'));
    $rows[] = $row;
}
} else {
    $row[] = array(__('<h5 class="text-danger">No result found.</h5>'), array('class' => 'text-center noresult', 'colspan' => 8));
    $rows[] = $row;
}


$this->start('search');

echo $this->Form->create($events, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
    ));
echo $this->Form->input('keyword', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-3">{{content}}</div>', 'label' => null],
    'placeholder' => 'Type title, location, organizer'
    ]);



echo $this->Form->input('date', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-3">{{content}}</div>', 'label' => null],
    'placeholder' => 'Event Date',
    'type' => 'text',
    'class' => 'datepicker'
    ]);

$this->end();
$this->assign('searchActionRow', "col-md-6");
$btn = $this->Form->button('Search', array('class' => 'btn btn-default pull-right'));
$this->assign('btn', $btn);
if (!empty($rows)) {
    $this->append('table_row', $this->Html->tableCells($rows));
}

//$actionBtns = $this->Html->link('Export', ['export' => true], ['class' => 'btn btn-icon waves-effect waves-light btn-info']);
$actionBtns .= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);



$this->assign('actionBtns', $actionBtns);

$sort['status'] = 'Active';
$sort['created'] = 'Recent Added';
$sort['modified'] = 'Recent Modified';
$sort['view_count'] = 'Viewed';
$this->start('bulk_action');
?>
<div class="tablesaw-bar mode-stack">
    <div class="tablesaw-sortable-switch tablesaw-toolbar">
        <label>Sort:
            <span class="btn btn-small">
            <div class="btn-group dropdown open">
                <?php echo ($this->request->query('sort')) ? $sort[$this->request->query('sort')] : 'Recent Added';?> <?php echo (($this->request->query('direction') == 'desc') || empty($this->request->query('direction'))) ? '<i class="ion-ios7-arrow-thin-down"></i>' : '<i class="ion-ios7-arrow-thin-up"></i>';?>
                <i class="ion-chevron-down m-l-10"></i>
                <button type="button" class="btn btn-link dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu m-t-20" role="menu">
                    <li><?php echo $this->Paginator->sort('status', 'Active ↓',array('direction' => 'desc', 'lock' => true)); ?></li>
                    <li><?php echo $this->Paginator->sort('view_count', 'Viewed ↓', array('direction' => 'desc', 'lock' => true)); ?></li>
                    <li><?php echo $this->Paginator->sort('created', 'Recent Added ↓', array('direction' => 'desc', 'lock' => true)); ?></li>
                    <li><?php echo $this->Paginator->sort('modified', 'Recent Modified ↓', array('direction' => 'desc', 'lock' => true)); ?></li>

                </ul>
                </div>
            </span>
        </label>
    </div>
</div>
<?php
$this->end();
