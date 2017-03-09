<?php

$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

//$tableHeaders[] = array($this->Form->checkbox($modelClass . '.id.', array('class' => 'group-checkable', 'data-set' => "#psdata_table .checkboxes", 'hiddenField' => false)) => array('class' => 'check_box'));
//$tableHeaders[] = '';
$tableHeaders[] = array($this->Paginator->sort(__('id'), 'ID') => array('class' => 'id_class text-center'));
$tableHeaders[] = '';
$tableHeaders[] = $this->Paginator->sort(__('name'), 'Name');
$tableHeaders[] = $this->Paginator->sort(__('email'));
$tableHeaders[] = $this->Paginator->sort(__('blog_count'),'Blog Posted');

//$tableHeaders[] = $this->Paginator->sort(__('location'));
$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Added Date') => array('class' => 'date-class'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if (!empty($authors)) {
    foreach ($authors->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        $row = array();
        //$row[] = $this->Form->checkbox($modelClass . '.id.' . $key, array('class' => 'checkboxes', 'value' => $listOne['id'], 'hiddenField' => false));
        $row[] = array($listOne['id'], array('class' => 'text-center'));
        $row[] = $this->Awesome->image('Authors/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix','type' => 'thumbnail']);
        $row[] = $listOne['name'];

        $row[] = $listOne['email'];
        $row[] = $listOne['blog_count'];

        $row[] = $this->Awesome->date($listOne['created']);

        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));
        $links .= $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
} else {
    $row[] = array(__('NoResult', $modelClass), array('class' => 'text-center noresult', 'colspan' => 9));
    $rows[] = $row;
}


$this->start('search');

echo $this->Form->create($authors, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-9">{{content}}</div>', 'label' => null],
    'placeholder' => 'Search by Name, Email Address...'
]);



$this->end();
$this->assign('searchActionRow', "col-md-3");
$btn = $this->Form->button('Search', array('class' => 'btn btn-default pull-right'));
$this->assign('btn', $btn);
if(!empty($rows)){
    $this->append('table_row', $this->Html->tableCells($rows));
}


$actionBtns = $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);


$this->assign('actionBtns', $actionBtns);


