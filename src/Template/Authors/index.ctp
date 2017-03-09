<div class="author-listing">
    <div class="authors">
        <ul class="row">
            <?php
            if ($success && $authors->count() > 0) {
                foreach ($authors as $author) {
                    $author = $author->toArray();
                    
                    $url = ['controller' => 'authors','action' => 'view','slug' => $author['slug']]
                    ?>
                    <li class="col-sm-6 col-md-4">
                        <div class="single-author">
                            <div class="author-bg">
                                <?php echo $this->Awesome->image('Users/cover_image', $author['cover_image'], ['class' => 'img-responsive', 'type' => 'large']); ?>
                            </div>
                            <div class="author-image">
                                <?php echo $this->Html->link($this->Awesome->image('Users/image', $author['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']),$url,['escape' => false]); ?>
                            </div>
                            <div class="author-info">
                                <h2><?php echo $this->Html->link($author['name'], $url); ?></h2>
                                <p><?php echo $author['designation']; ?></p>
                            </div>
                            <div class="author-social">
                                <?php
                                $social = [];
                                if (!empty($author['facebook_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-facebook"></i>', $author['facebook_url'], ['escape' => false, 'target' => '_blank']);
                                }

                                if (!empty($author['twitter_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-twitter"></i>', $author['twitter_url'], ['escape' => false, 'target' => '_blank']);
                                }

                                if (!empty($author['google_plus_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-google-plus"></i>', $author['google_plus_url'], ['escape' => false, 'target' => '_blank']);
                                }

                                if (!empty($author['linkedIn_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-linkedin"></i>', $author['linkedIn_url'], ['escape' => false, 'target' => '_blank']);
                                }

                                if (!empty($author['youtube_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-youtube"></i>', $author['youtube_url'], ['escape' => false, 'target' => '_blank']);
                                }

                                if (!empty($author['pinterest_url'])) {
                                    $social[] = $this->Html->link('<i class="fa fa-pinterest"></i>', $author['pinterest_url'], ['escape' => false, 'target' => '_blank']);
                                }
                                if (!empty($social)) {
                                    $this->Html->tag('p', 'Find Me');
                                    echo $this->Html->nestedList($social, ['class' => 'list-inline social-icons']);
                                }
                                ?>


                            </div>
                        </div><!-- single-author -->
                    </li>
                <?php }
            }
            ?>
        </ul>
    </div>
</div><!-- author-listing -->

<?php echo $this->element('pagination');?>