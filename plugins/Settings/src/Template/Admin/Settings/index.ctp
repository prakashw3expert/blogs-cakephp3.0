<?php

$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);


$tableHeaders[] = $this->Paginator->sort(__('key'));
$tableHeaders[] = $this->Paginator->sort(__('value'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = null;
if (!empty($$viewVar)) {
    $entities = $$viewVar;
    foreach ($entities->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();
        $row = array();
        $row[] = $listOne['key'];

        $row[] = $listOne['value'];

        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit',$listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
}

$this->append('table_row', $this->Html->tableCells($rows));



