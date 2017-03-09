<?php
$coverImage = $this->Awesome->image('Users/cover_image', $user['cover_image'], ['class' => 'img-responsive', 'type' => 'large','tag' => false]);
?>
<div id="site-content" class="site-content">
    <div class="author-details">
        <div class="author-heading" style="background-image:url(<?php echo $coverImage;?>)">
            <div class="author-profile">
                <div class="author-gravatar">
                    <?php echo $this->Awesome->image('Users/image', $user['image'], ['class' => 'img-responsive', 'type' => 'thumbnail', 'width' => '100px']); ?>
                </div>
                <div class="author-name">
                    <h1><?= $user['name']; ?></h1>
                    <p><?= $user['designation']; ?></p>
                </div>
                <div class="author-social">
                    <?php
                    $social = [];
                    if (!empty($user['facebook_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-facebook"></i>', $this->Awesome->addHttp($user['facebook_url']), ['escape' => false, 'target' => '_blank']);
                    }

                    if (!empty($user['twitter_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-twitter"></i>', $this->Awesome->addHttp($user['twitter_url']), ['escape' => false, 'target' => '_blank']);
                    }

                    if (!empty($user['google_plus_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-google-plus"></i>', $this->Awesome->addHttp($user['google_plus_url']), ['escape' => false, 'target' => '_blank']);
                    }

                    if (!empty($user['linkedIn_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-linkedin"></i>', $this->Awesome->addHttp($user['linkedIn_url']), ['escape' => false, 'target' => '_blank']);
                    }

                    if (!empty($user['youtube_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-youtube"></i>', $this->Awesome->addHttp($user['youtube_url']), ['escape' => false, 'target' => '_blank']);
                    }

                    if (!empty($user['pinterest_url'])) {
                        $social[] = $this->Html->link('<i class="fa fa-pinterest"></i>', $this->Awesome->addHttp($user['pinterest_url']), ['escape' => false, 'target' => '_blank']);
                    }
                    if (!empty($social)) {
                        $this->Html->tag('p', 'Find Me');
                        echo $this->Html->nestedList($social, ['class' => 'list-inline social-icons']);
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="author-info">
            <h3>About Me</h3>
            <p><?php echo $user['about']; ?></p>
        </div>
    </div>
</div><!--/#site-content-->

<div class="row">
    <div class="col-sm-12">
        <h1 class="section-title">My Blogs</h1>
        <div class="section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section">
                        <div class="row">
                            <?php
                            foreach ($blogs as $blog) {
                                $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog['category']['slug'], 'slug' => $blog['slug']];
                                ?>
                                <div class="col-sm-4">
                                    <div class="post medium-post blog-post">

                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']), $link, ['escape' => false]) ?>
                                            </div>
                                        </div>
                                        <div class="post-content">								
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="publish-date"><i class="fa fa-clock-o"></i>
                                                        <?php echo $this->Awesome->date($blog['created']); ?>
                                                    </li>
                                                    <li class="views"><i class="fa fa-eye"></i><a href="#"><?php echo $this->Awesome->niceCount($blog['view_count']); ?></a></li>
                                                </ul>
                                            </div>
                                            <h2 class="entry-title">
                                                <?php echo $this->Html->link($this->Text->truncate($blog['title'], 50), $link); ?>
                                            </h2>
                                        </div>
                                    </div><!--/post--> 
                                </div>
                                <?php } ?>
                                <?php if ($blogs->count() == 0) { ?>
                                <div class="col-sm-12">
                                    <h2 class="entry-title">
                                        No records found!!!
                                    </h2>
                                </div>
                                <?php } ?>
                                
                            </div>
                            <?php echo $this->element('pagination');?>
                        </div><!--/.section -->	

                    </div>
                </div>

            </div><!--/.section -->	

        </div>
    </div>
   
    <?php echo $this->AssetCompress->css('event');?>

    <?= $this->cell('Event::userEvents', ['user_id' => $user['id']], ['cache1' => true]) ?>
    