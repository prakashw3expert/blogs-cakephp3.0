<?php
$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);


$tableHeaders[] = array($this->Paginator->sort(__('title'), 'Title') => array('class' => 'id_class text-left'));
$tableHeaders[] = array(null => array());

$tableHeaders[] = array($this->Paginator->sort(__('download_count'), 'Download') => array('class' => 'id_class text-left'));

$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Added Date') => array('styles' => 'width:10%'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'styles' => 'width:5%'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if ($magazines->count() > 0) {
    
    foreach ($magazines->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        $row = array();
        
        $row[] = $this->Awesome->image('Magazines/image', $listOne['image'], ['class' => 'img-circle thumb-md clearfix']);
        $row[] = $listOne['title'];

        $row[] = $listOne['download_count'];

        $row[] = $listOne['created'];
        
        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));
        $links .= $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
} else {
    $row[] = array(__('No magzines added yet.'), array('class' => 'text-center noresult', 'colspan' => 9));
    $rows[] = $row;
}


$this->start('search');

echo $this->Form->create($modelClass, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
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


