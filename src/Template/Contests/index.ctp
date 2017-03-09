<!-- HEADER -->  
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="entry-title">Photography Contests</h2>
    </div>

</section>


<section class="events  newsection">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section listing-news">
                    <?php
                    foreach ($contests as $contest) {
                        $link = ['controller' => 'contests', 'action' => 'view', 'slug' => $contest->slug];
                        ?>
                        <div class="post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <?php 
                                    /* if ($contest->contest_participates) { ?>
                                        <div class="row">
                                            <?php
                                            foreach ($contest->contest_participates as $image) {
                                                echo '<div class="col-sm-4 image-cloud">';
                                                echo $this->Html->link($this->Awesome->image('ContestParticipates/image', $image['image'], ['type' => 'thumbnail']), $link, ['escape' => false]);
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    } else {
                                        echo $this->Html->link($this->Awesome->image('Contests/image', $contest['image'], ['style' => 'width:100%']), $link, ['escape' => false]);
                                    }
                                     * */
                                     echo $this->Html->link($this->Awesome->image('Contests/image', $contest['image'], ['style' => 'width:100%']), $link, ['escape' => false]);
                                    ?>
                                </div>

                            </div>
                            <div class="post-content">								
                                <h1 class="entry-title">
                                    <?php echo $this->Html->link($contest->title, $link); ?>
                                </h1>
                                <div class="entry-meta">
                                    <ul class="list-inline">
                                        <?php
                                        $time = $contest->expiry;
                                        $date = 'Ended';
                                        if (!$time->isPast()) {
                                            $date = $time->timeAgoInWords([
                                                'accuracy' => 'day'
                                            ]);

                                            $date = 'Ending in ' . $date . ' from now';
                                        }
                                        ?>
                                        <li> 
                                            <h4> <?php echo $date; ?>  | <?php
                                                echo ($contest->enteries) ? $contest->enteries : 0;
                                                echo ($contest->enteries > 1) ? ' entries' : ' entry';
                                                ?>
                                            </h4>
                                        </li>

                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <p><?php echo $this->Text->truncate($contest->description, 150); ?></p>
                                </div>
                            </div>
                        </div><!--/post--> 
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>˙
