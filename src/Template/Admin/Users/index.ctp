<?php

$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

//$tableHeaders[] = array($this->Form->checkbox($modelClass . '.id.', array('class' => 'group-checkable', 'data-set' => "#psdata_table .checkboxes", 'hiddenField' => false)) => array('class' => 'check_box'));
//$tableHeaders[] = '';
$tableHeaders[] = array($this->Paginator->sort(__('id'), 'ID') => array('class' => 'id_class text-center','style2' => 'width:5%'));
$tableHeaders[] = array($this->Paginator->sort(__('name'), '') => array('style2' => 'width:5%'));
$tableHeaders[] = array('' => array('style2' => 'width:15%'));
$tableHeaders[] = array($this->Paginator->sort(__('email')) => array('style2' => 'width:30%'));
$tableHeaders[] = array($this->Paginator->sort(__('age'), 'Age & Gender') => array('style2' => 'width:15%'));
$tableHeaders[] = array($this->Paginator->sort(__('countries.name'),'Country') => array('style2' => 'width:10%'));
$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('style2' => 'width:5%'));

$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Join Date') => array('class' => 'date-class', 'style2' => 'width:10%'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'style2' => 'width:5%'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if ($success && $users->count() > 0) {
    foreach ($users->toArray() as $key => $listOne) {
        $row = array();
        //$row[] = $this->Form->checkbox($modelClass . '.id.' . $key, array('class' => 'checkboxes', 'value' => $listOne['id'], 'hiddenField' => false));
        $row[] = array($listOne['id'], array('class' => 'text-center'));
        $row[] = $this->Awesome->image('Users/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix','type' => 'thumbnail']);
        $row[] = $this->Html->link($listOne->name,['controller' => 'users','action' => 'view','slug' => $listOne->slug]);

        $row[] = $listOne->email;
        $row[] = $listOne->age . '' . $listOne->gender;

        $row[] = $listOne->country->name;
        $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => 'text-center2'));
        $row[] = $this->Awesome->date($listOne->created);

        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit', $listOne->id), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));
        $links = $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne->id], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);


        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
}


$this->start('search');

echo $this->Form->create($users, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-4">{{content}}</div>', 'label' => null],
    'placeholder' => 'User Name , Email Address'
]);



echo $this->Form->input('gender', [
    'options' => $user->genders,
    'class' => 'form-control select2',
    'templates' => ['inputContainer' => '<div class="form-group col-md-2">{{content}}</div>', 'label' => null],
    'empty' => 'Gender'
]);

echo $this->Form->input('country_id', [
    'class' => 'form-control select2',
    'templates' => ['inputContainer' => '<div class="form-group col-md-3">{{content}}</div>', 'label' => null],
    'empty' => 'Country',
    'default' => Cake\Core\Configure::read('default.country')
]);




$this->end();
$this->assign('searchActionRow', "col-md-2");
$btn = $this->Form->button('Search', array('class' => 'btn btn-default pull-right'));
$this->assign('btn', $btn);
if (!empty($rows)) {
    $this->append('table_row', $this->Html->tableCells($rows));
}


$actionBtns .= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);
$this->assign('actionBtns', $actionBtns);


