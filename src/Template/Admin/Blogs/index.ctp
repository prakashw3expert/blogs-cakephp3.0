<?php
$this->extend('/Common/Admin/index');
$this->Html->addCrumb($modelClass, null);

// $tableHeaders[] = array($this->Form->checkbox($modelClass . '.id.', array('class' => 'group-checkable', 'data-set' => "#psdata_table .checkboxes", 'hiddenField' => false)) => array('class' => 'check_box','style' => 'width:5%'));
//$tableHeaders[] = '';
//$tableHeaders[] = array($this->Paginator->sort(__('id'), 'ID') => array('class' => 'id_class text-center', 'style' => 'width:5%'));

$tableHeaders[] = array($this->Paginator->sort(__('title'), 'Title') => array('class' => 'id_class text-left', 'style' => 'width:5%'));

$tableHeaders[] = array(null => array('style' => 'width:34%'));

$tableHeaders[] = array($this->Paginator->sort(__('Users.name'),'Author') => array('class' => 'text-center1', 'style' => 'width:15%'));
$tableHeaders[] = array($this->Paginator->sort(__('catetory.title'), 'Category') => array('class' => 'id_class text-center1', 'style' => 'width:13%'));

$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('class' => 'text-center', 'style' => 'width:10%'));

$tableHeaders[] = array($this->Paginator->sort(__('view_count'),'Views') => array('class' => 'text-center1', 'style' => 'width:5%'));

$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Added Date') => array('style' => 'width:13%'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'style' => 'width:5%'));

$this->append('table_head', $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')));

$tableHeaders = array();


$this->append('form-start', $this->Form->create($modelClass, array(
            'type' => 'post',
            'class' => 'form-horizontal list_data_form',
            'novalidate' => true,
)));



$rows = array();
if (!empty($blogs)) {
    foreach ($blogs->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        $row = array();
        // $row[] = $this->Form->checkbox('id.' . $key, array('class' => 'checkboxes', 'value' => $listOne['id'], 'hiddenField' => false));
        //$row[] = array($listOne['id'], array('class' => 'text-center'));
        $label = null;
        if ($listOne['featured'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect waves-light btn-primary btn-xs" title="Featured"><i class="fa fa-star"></i></span> ';
        }
        if ($listOne['promoted'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect btn-default waves-light btn-xs" title="Promoted"><i class="fa fa-heart-o"></i></span> ';
        }
        $row[] = $this->Awesome->image('Blogs/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix','type' => 'thumbnail']);
        $row[] = $label . $listOne['title'];
        $row[] = $this->Html->link($listOne['user']['name'],['controller' => 'authors','action' => 'view',$listOne['user']['slug']]);
        $row[] = $listOne['category']['title'];

        $row[] = array($this->Form->checkbox('status', [
        'checked' => $listOne['status'],
        'class' => "change_status",
        'data-size'=>"small",
        'data-plugin' => 'switchery',
        'data-model' => $modelClass,
        'data-id' => $listOne['id'],
        'id' => "event_".$listOne['id'],
        'data-value' => ($listOne['status']) ? 1 : 0,
        ]), array('class' => 'text-center'));

        $row[] = $listOne['view_count'];
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

echo $this->Form->create($blogs, array(
    'novalidate' => true,
    'type' => 'get',
    'class' => 'form-inline',
));
echo $this->Form->input('q', [
    'templates' => ['inputContainer' => '<div class="form-group col-md-5">{{content}}</div>', 'label' => null],
    'placeholder' => 'Search by Blog Title'
]);

echo $this->Form->input('category_id', [
    'label' => 'Category', 'class' => 'select2', 'empty' => 'Select Category',
    'templates' => ['inputContainer' => '<div class="form-group col-md-4">{{content}}</div>', 'label' => null],
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

$sort['status'] = 'Published';
$sort['featured'] = 'Featured';
$sort['created'] = 'Recent Added';
$sort['modified'] = 'Recent Modified';
$sort['view_count'] = 'Most Viewed';
$this->start('bulk_action');
?>
<div class="tablesaw-bar mode-stack">
    <div class="tablesaw-sortable-switch tablesaw-toolbar">
        <label>Sort:
            <span class="btn btn-small btn-select">
                <div class="btn-group dropdown open">
                    <?php echo ($this->request->query('sort')) ? $sort[$this->request->query('sort')] : 'Recent Added';?> <?php echo (($this->request->query('direction') == 'desc') || empty($this->request->query('direction'))) ? '<i class="ion-ios7-arrow-thin-down"></i>' : '<i class="ion-ios7-arrow-thin-up"></i>';?>
                    <i class="ion-chevron-down m-l-10"></i>
                    <button type="button" class="btn btn-link dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false"></button>
                    <ul class="dropdown-menu m-t-20" role="menu">
                    <li><?php echo $this->Paginator->sort('featured', null, array('direction' => 'desc')); ?></li>
                        <li><?php echo $this->Paginator->sort('status', 'Published ↓',array('direction' => 'desc', 'lock' => true)); ?></li>
                        <li class="divider"></li>
                        <li><?php echo $this->Paginator->sort('view_count', 'Most Viewed ↓', array('direction' => 'desc', 'lock' => true)); ?></li>
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
/*
$this->start('bulk_action');
?>
<div class="form-group">
    <?php
    echo $this->Form->input('featured', [
        'options' => [
            $this->Url->build(['controller' => 'blogs', "action" => "featuredAll"], ['base' => false]) => 'Move to Featured',
            $this->Url->build(['controller' => 'blogs', "action" => "removeFeaturedAll"], ['base' => false]) => 'Remove Featured',
            // $this->Url->build(['controller' => 'blogs', "action" => "promotedAll"], ['base' => false]) => 'Move to Promoted',
            // $this->Url->build(['controller' => 'blogs', "action" => "removePromotedAll"], ['base' => false]) => 'Remove Promoted',
            $this->Url->build(['controller' => 'blogs', "action" => "publishAll"], ['base' => false]) => 'Publish',
            $this->Url->build(['controller' => 'blogs', "action" => "removePublishdAll"], ['base' => false]) => 'Un Publish',
            $this->Url->build(['controller' => 'blogs', "action" => "deleteAll"], ['base' => false]) => 'Delete'],
        'class' => 'selectpicker bukl_action m-r-5',
        'data-style' => 'btn-default btn-custom',
        'label' => false,
        'empty' => 'Bulk Action',
    ]);
    ?>
    <button type="submit" class="btn btn-default btn-custom waves-effect waves-light m-r-5 m-l-5">Apply</button>
</div>

<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Sort By <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
        <li><?php echo $this->Paginator->sort('featured', null, array('direction' => 'desc')); ?></li>
        <!-- <li><?php //echo $this->Paginator->sort('promoted', null, array('direction' => 'desc')); ?></li> -->
        <li><?php echo $this->Paginator->sort('status', 'Published'); ?></li>
        <li class="divider"></li>
        <li><?php echo $this->Paginator->sort('view_count', 'Most Viewed', array('direction' => 'desc')); ?></li>
        <li><?php echo $this->Paginator->sort('created', 'Recent Added', array('direction' => 'desc')); ?></li>

        <li><?php echo $this->Paginator->sort('modified', 'Recent Modified', array('direction' => 'desc')); ?></li>
    </ul>
</div>
<?php
$this->end();
*/