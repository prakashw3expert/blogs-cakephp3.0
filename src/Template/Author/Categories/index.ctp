<?php

$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

//$tableHeaders[] = array($this->Form->checkbox($modelClass . '.id.', array('class' => 'group-checkable', 'data-set' => "#psdata_table .checkboxes", 'hiddenField' => false)) => array('class' => 'check_box'));
//$tableHeaders[] = '';
$tableHeaders[] = array($this->Paginator->sort(__('id'), 'ID') => array('class' => 'id_class text-center'));
$tableHeaders[] = $this->Paginator->sort(__('title'), 'Catetgory Name');
if (empty($parent_id)) {
    $tableHeaders[] = $this->Paginator->sort(__('child_count'),'Sub Categories');
}
$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('class' => 'text-center'));

$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Added Date') => array('class' => 'date-class'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = '';
if (!empty($categories)) {
    foreach ($categories->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        $row = array();
      
        $row[] = array($listOne['id'], array('class' => 'text-center'));
        $row[] = $listOne['title'];
        if (empty($parent_id)) {
            $row[] = $this->Html->link($listOne['child_count'], ['action' => 'index', $listOne['id']]);
        }
        $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => 'text-center'));
        $row[] = $listOne['created'];

        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));
        $links .= $this->Form->postLink(
                '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
}


$this->start('search');

echo $this->Form->create($categories, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-9">{{content}}</div>', 'label' => null],
    'placeholder' => 'Search by Name'
]);



$this->end();
$this->assign('searchActionRow', "col-md-3");
$btn = $this->Form->button('Search', array('class' => 'btn btn-default pull-right'));
$this->assign('btn', $btn);
if (!empty($rows)) {
    $this->append('table_row', $this->Html->tableCells($rows));
}

$actionBtns = $this->Html->link('Export', ['export' => true], ['class' => 'btn btn-icon waves-effect waves-light btn-info']);
$actionBtns .= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);
;

$this->assign('actionBtns', $actionBtns);


