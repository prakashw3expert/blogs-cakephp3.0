<?php
$this->Html->addCrumb('Contests', ['action' => 'index']);

$this->Html->addCrumb($contest->title, null);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box text-center">
            <div class="row">
                <h4 class="m-t-0 header-title"><b><?php echo $contest->title; ?></b></h4>
                <p class="text-muted m-b-30 font-13">
                    <?php echo $contest->description; ?>
                </p>
            </div>
        </div>
    </div>
</div> <!-- end row -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="header-title">Entries</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="row grid">
            <?php foreach ($entries as $entry) { ?>
                <div class="col-lg-4 grid-item">
                    <div class="panel panel-default hover-effect">
                        <div class="panel-heading p-0">
                            <?php echo $this->Awesome->image('ContestParticipates/image', $entry['image'], ['class' => 'img-responsive']); ?>
                        </div>
                        <div class="panel-body">
                            <div class="clearfix col-lg-10 col-md-10 col-sm-10">
                                <h4 class="m-t-0 m-b-5"><?php echo $entry->title; ?></h4>
                                <h5 class="m-t-0 m-b-5"><?php echo $this->Html->link($entry->user['name'],['controller' => 'users','action' => 'view','slug' => $entry->user['slug']],['target'=>'_blank']); ?></h5>

                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 p-t-20">
                                <div class="text-center m-b-5">
                                    <i class="mdi md-favorite text-danger"></i>
                                </div>
                                <div class="text-center">
                                    <?php echo $entry->likes; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>

            <?php if ($entries->count() <= 0) { ?>
                <div class="col-lg-4 grid-item"><h4 class="m-t-0 m-b-5">No entries yet!</h4></div>
            <?php } ?>
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


    <?php
    echo $this->start('jsSection');

    echo '<script src="https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>';
    echo '<script type="text/javascript">
            $(".grid").masonry({
            itemSelector: ".grid-item",
            
            
        });
</script>';

    $this->end();
    ?>
