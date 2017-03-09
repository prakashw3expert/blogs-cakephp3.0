<?php
$this->Html->addCrumb('My Blogs', null);

$tableHeaders[] = array($this->Paginator->sort(__('title'), 'Title') => array('class' => 'id_class text-left', 'style' => 'width:40%'));
$tableHeaders[] = array($this->Paginator->sort(__('catetory.title'), 'Category') => array('class' => 'id_class text-center1', 'style' => 'width:15%'));


$tableHeaders[] = array($this->Paginator->sort(__('status')) => array('class' => 'text-center', 'style' => 'width:10%'));

$tableHeaders[] = array($this->Paginator->sort(__('view_count'),'Views') => array('class' => 'text-center', 'style' => 'width:10%'));

$tableHeaders[] = array($this->Paginator->sort(__('created'), 'Added Date') => array('style' => 'width:15%'));
$tableHeaders[] = array('Actions' => array('class' => 'action-btn-2 text-center', 'style' => 'width:10%'));





$rows = array();
if (!empty($blogs)) {

    foreach ($blogs->toArray() as $key => $listOne) {
        $listOne = $listOne->toArray();

        if(!empty($listOne['category']['parent']['title'])){
            $link = ['controller' => 'blogs', 'action' => 'view','parent' => $listOne['category']['parent']['slug'], 'category' => $listOne['category']['slug'], 'slug' => $listOne['slug']];
        } else{
            $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $listOne['category']['slug'], 'slug' => $listOne['slug']];
        }

        $blogTitle = $this->Text->truncate($listOne['title'],110);

        $row = array();
        $label = null;
        if ($listOne['featured'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect waves-light btn-primary btn-xs" title="Featured"><i class="fa fa-star"></i></span> ';
        }
        if ($listOne['promoted'] == 1) {
            $label .= '<span class="btn btn-icon waves-effect btn-default waves-light btn-xs" title="Promoted"><i class="fa fa-heart-o"></i></span> ';
        }
        $label .= $this->Awesome->image('Blogs/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix m-r-10', 'type' => 'thumbnail']);

        if($listOne['status']){
            $row[] = $label . $this->Html->link($blogTitle.' <i class="fa fa-external-link" aria-hidden="true"></i>',$link,['escape' => false,'target' => '_blank']);
        }
        else{
            $row[] = $label .$blogTitle;
        }
        $row[] = $listOne['category']['title'];

        $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => 'text-center'));
        $row[] = array($listOne['view_count'], array('class' => 'text-center'));
        $row[] = $this->Awesome->date($listOne['created']);

        $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));
        $links .= $this->Form->postLink(
            '<i class="fa fa-times"></i>', ['action' => 'delete', $listOne['id']], ['escape' => false, 'class' => 'btn btn-xs red delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);



        $row[] = array($links, array('class' => 'text-center'));
        $rows[] = $row;
    }
}

$actionBtns = '';
$actionBtns .= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']);
?>

<?php if ($blogs->count() <= 0) { ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="alert alert- fade in m-t-20 text-center">
                <h1><i class="icon-info"></i></h1>
                <h3><?php echo $loggedInAs['name']; ?> you didn't add blog yet</h3>

                <?php echo $this->Html->link('Write your first blog',['action' => 'add'],['class' => 'btn btn-warning waves-effect waves-light w-lg']);?>
            </div>
        </div>
    </div> <!-- end col -->

</div>
<?php } ?>

<?php if ($blogs->count() > 0) { ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">

            <div class="form-inline m-b-10">
                <div class="row">
                    <div class="col-sm-8 text-xs-center">
                        <h4 class="m-t-10 m-b-10 header-title"><b><?php echo $title; ?></b></h4>

                    </div>
                    <div class="col-sm-4 text-xs-center text-right">
                        <div class="button-list pull-right pull-right">
                            <?php echo $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-default']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="tablesaw table tablesaw-swipe table-bordered1">
                    <thead>
                        <?php echo $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')); ?>
                    </thead>

                    <tbody>
                        <?php echo $this->Html->tableCells($rows); ?>
                    </tbody>
                </table>


            </div>

            <div class="row">

                <div class="col-sm-6 pagination">
                    <?php
// Change a template
                    $config = [
                    'nextActive' => '<li class="next"><a rel="next" href="{{url}}">{{text}}</a></li>',
                    'nextDisabled' => '<li class="next disabled"><span>{{text}}</span></li>',
                    'prevActive' => '<li class="prev"><a rel="prev" href="{{url}}">{{text}}</a></li>',
                    'prevDisabled' => '<li class="prev disabled"><span>{{text}}</span></li>',
                    'counterRange' => '{{start}} - {{end}} of {{count}}',
                    'counterPages' => '{{page}} of {{pages}}',
                    'first' => '<li class="first"><a href="{{url}}">{{text}}</a></li>',
                    'last' => '<li class="last"><a href="{{url}}">{{text}}</a></li>',
                    'number' => '<li><a href="{{url}}">{{text}}</a></li>',
                    'current' => '<li class="active"><span>{{text}}</span></li>',
                    'ellipsis' => '<li class="ellipsis"><a href="#">...</a></li>',
                    'sort' => '<a href="{{url}}">{{text}}</a>',
                    'sortAsc' => '<a class="asc" href="{{url}}">{{text}}</a>',
                    'sortDesc' => '<a class="desc" href="{{url}}">{{text}}</a>',
                    'sortAscLocked' => '<a class="asc locked" href="{{url}}">{{text}}</a>',
                    'sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>',
                    ];
                    $this->Paginator->templates($config);

                    echo $this->Paginator->counter(
                        'Page {{page}} of {{pages}}, showing {{current}} records out of
                        {{count}} total'
                        );
//, starting on record {{start}}, ending on {{end}}
                        ?>
                    </div>
                    <div class="col-sm-6 text-right">
                        <ul class="pagination">
                            <?= $this->Paginator->prev('<i class="fa fa-fw fa-chevron-left"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->numbers(['first' => 2, 'last' => 2, 'before' => false, 'after' => false, 'modulus' => 6]) ?>
                            <?= $this->Paginator->next('<i class="fa fa-fw fa-chevron-right"></i>', ['escape' => false]) ?>
                        </ul>
                    </div>
                </div>


            </div>
        </div> <!-- end col -->

    </div>
    <?php } ?>

