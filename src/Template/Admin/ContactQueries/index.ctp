<?php $this->Html->addCrumb('Contact Queries', null); ?>

<div class="row">
    <div class="col-lg-8">
        <?php
        echo $this->Form->create($contactQueries, array(
            'novalidate' => true,
            'type' => 'get',
        ));
        echo $this->Form->input('q', [
            'templates' => ['inputContainer' => '<div class="form-group contact-search m-b-30">{{content}}<button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button></div>', 'label' => null],
            'placeholder' => 'Search...'
        ]);
        echo $this->Form->end();
        ?>

        <?php if ($contactQueries->count() > 0) { ?>
            <div class="card-box m-b-10">
                <div class="table-box opport-box">
                    <div class="table-detail col-lg-2">
                        <div class="member-info">
                            <h4 class="m-t-0"><b>Name</b></h4>
                        </div>
                    </div>

                    <div class="table-detail col-lg-4">
                        <b>Email Address</b>
                    </div>

                    <div class="table-detail col-lg-3">
                        <b>Subject</b>
                    </div>

                    <div class="table-detail col-lg-2">
                        <b>Date</b>
                    </div>

                    <div class="table-detail table-actions-bar col-lg-1">
                        <b> Action</b>
                    </div>

                </div>

            </div>
            <?php
            foreach ($contactQueries as $contactQuery) {
                $contactQuery = $contactQuery->toArray();
                ?>
                <div class="card-box m-b-10">
                    <div class="table-box opport-box">

                        <div class="table-detail col-lg-2">
                            <div class="member-info">
                                <h4 class="m-t-0"><b><?php echo $contactQuery['name']; ?> </b></h4>

                            </div>
                        </div>

                        <div class="table-detail col-lg-4">
                            <b><?php echo $contactQuery['email']; ?></b>
                        </div>

                        <div class="table-detail col-lg-3">
                            <b><?php echo $contactQuery['subject']; ?></b>
                        </div>
                        <div class="table-detail col-lg-2">
                            <b><?php echo $this->Awesome->date($contactQuery['created']); ?></b>
                        </div>
                        <div class="table-detail table-actions-bar col-lg-1">
                            <?= $this->Form->postLink(__('<i class="md md-close"></i>'), ['action' => 'delete', $contactQuery['id']], ['class' => 'table-action-btn', 'confirm' => __('Are you sure you want to delete # {0}?', $contactQuery['id']), 'escape' => false]) ?>

                        </div>

                    </div>
                    <p class="text-dark m-b-5"><b>Message: </b> <span class="text-muted"><?php echo $contactQuery['message']; ?></span></p>

                </div>
                <?php
            }
        }
        ?>


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



    </div> <!-- end col -->

    <div class="col-lg-4">
        <div class="mini-stat clearfix card-box">
            <span class="mini-stat-icon bg-info"><i class="ion-android-contact text-white"></i></span>
            <div class="mini-stat-info text-right text-dark">
                <span class="counter text-dark"><?= $this->cell('Contact', ['-0 DAY']); ?></span>
                Today Total Queries
            </div>

        </div>

        <div class="mini-stat clearfix card-box">
            <span class="mini-stat-icon bg-warning"><i class="ion-android-contact text-white"></i></span>
            <div class="mini-stat-info text-right text-dark">
                <span class="counter text-dark"><?= $this->cell('Contact', ['-7 DAY']); ?></span>
                Queries in last 7 days
            </div>

        </div>

        <div class="mini-stat clearfix card-box">
            <span class="mini-stat-icon bg-pink"><i class="ion-android-contacts text-white"></i></span>
            <div class="mini-stat-info text-right text-dark">
                <span class="counter text-dark"><?= $this->cell('Contact', ['-30 DAY']); ?></span>
                Queries in last 30 days
            </div>

        </div>

        <div class="mini-stat clearfix card-box">
            <span class="mini-stat-icon bg-success"><i class="ion-eye text-white"></i></span>
            <div class="mini-stat-info text-right text-dark">
                <span class="counter text-dark"><?= $this->cell('Contact', ['All']); ?></span>
                Total Queries
            </div>

        </div>


    </div>

</div>