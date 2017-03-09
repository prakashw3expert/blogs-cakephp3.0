<style>
    .medium-post .entry-thumbnail, .entry-thumbnail.box-standard {
        height: auto;
    }
    .entry-thumbnail img{width: 100%}
    .post.medium-post .entry-title{min-height: auto;}
    .post-content {
        padding: 0px 10px;
        position: absolute;
        margin-top: -42px;
        color: #fff;
        background: rgba(0, 0, 0, 0.2);
        width: 94.6%;
    }
    .post-content .entry-title a{color: #fff;}
    i.fa.fa-meh-o.fa-4 {
        font-size: 32px;
        margin-top: -5px;
    }
</style>

<section class="sub-banner">
    <div class="container">
        <h2 class="entry-title"><?php echo $contest['title']; ?></h2>
        <div class=" pull-right">
            <?php
            $time = $contest['expiry'];
            if (!$time->isPast()) {
                echo $this->Html->link('Participate now!', ['controller' => 'contests', 'action' => 'participate', 'slug' => $contest['slug']], ['class' => 'btn btn-success']);
            }
            ?>
            <?php echo $this->Html->link('View Contest!', ['controller' => 'contests', 'action' => 'view', 'slug' => $contest->slug], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
</section>

<section class=" m-b-20">
    <div class="container">
        <div class="row" style="margin-left:-30px; margin-right: -30px;">

            <div class="col-md-12">
                <?= $this->Flash->render() ?>
                <?php if ($entries->count() > 0) { ?>
                <div class="left-content grid">
                    <?php
                    foreach ($entries as $entry) {
                        $link = ['controller' => 'contests', 'action' => 'entry', 'slug' => $entry['contest']['slug'], 'entry' => $entry['slug']];
                        ?>
                        <div class="col-sm-6 grid-item">
                            <div class="post medium-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <?php echo $this->Html->link($this->Awesome->image('ContestParticipates/image', $entry['image'], ['class' => '']), $link, ['escape' => false]); ?>
                                    </div>
                                </div>
                                <div class="post-content">								
                                    <h2 class="entry-title">
                                        <?php echo $this->Html->link($entry->title, $link); ?>
                                        <?php
                                        if (!empty($entry->contest_participates_users[0]) && !empty($entry->contest_participates_users[0]['id'])) {
                                            echo $this->Html->link('<i class="fa fa-meh-o fa-4" aria-hidden="true"></i>', 'javascript:void(0)', ['class' => 'pull-right liked', 'escape' => false, 'rel' => 'nofollow', 'data-toggle' => "tooltip", 'title' => 'You have liked.']);
                                        } else {
                                            echo $this->Html->link('<i class="fa fa-meh-o fa-4" aria-hidden="true"></i>', ['controller' => 'contests', 'action' => 'like', 'slug' => $entry['contest']['slug'], 'entry' => $entry['slug']], ['class' => 'pull-right', 'escape' => false, 'rel' => 'nofollow', 'data-toggle' => "tooltip", 'title' => 'Like']);
                                        }
                                        ?>

                                    </h2>
                                </div>
                            </div><!--/post--> 
                        </div>
                        <?php } ?>

                    </div>
                    <?php } else { ?>
                    <div class="">
                        <div class="text-center">
                            <div class="widget clearfix m-b-10">
                                <div class="eventform-con clearfix text-center">
                                    <h1><i class="fa fa-info-circle" aria-hidden="true"></i></h1>
                                    <h2>No one participant in this contest yet!</h2>
                                    <h5> </h5>
                                    <?php echo $this->Html->link('Click here to view contest!', ['controller' => 'contests', 'action' => 'view', 'slug' => $contest->slug], ['class' => '']); ?>
                                </div>
                            </div>

                        </div>
                        <?php } ?>
                        <?php echo $this->element('pagination'); ?>
                    </div><!--/.col-sm-9 -->	

                </div>				
            </div><!--/.section-->
        </section>


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
