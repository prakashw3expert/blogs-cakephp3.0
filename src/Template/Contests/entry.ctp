<?php
$this->assign('title', $contestEntry['contest']['title']);

$title = (!empty($contestEntry['meta_title'])) ? $contestEntry['meta_title'] : $contestEntry['title'];
$title = (!empty($contestEntry['meta_keyword'])) ? $contestEntry['meta_keyword'] : $contestEntry['tags'];
$description = $contestEntry['meta_description'];

$author = $contestEntry['user']['name'];
$keyword = $contestEntry['tags'];

$socialImage = $this->Awesome->image('ContestParticipates/image', $contestEntry['image'], ['class' => 'img-responsive', 'tag' => false]);

if (!$description) {
    $description = $this->Text->truncate(strip_tags($contestEntry['description']), 150, ['exact' => false]);
}

$link = $this->Url->build(['controller' => 'blogs', 'action' => 'view', 'category' => $contestEntry['category']['slug'], 'slug' => $contestEntry['slug']], ['base' => false]);

$meta = null;
$meta .= $this->Html->meta('keywords', $keyword);
$meta .= $this->Html->meta('description', $description);

// Twitter card
$meta .= $this->Html->meta('twitter:card', Cake\Core\Configure::read('Twitter.card'));
$meta .= $this->Html->meta('twitter:site', Cake\Core\Configure::read('Twitter.site'));
$meta .= $this->Html->meta('twitter:title', $title);
$meta .= $this->Html->meta('twitter:description', $description);
$meta .= $this->Html->meta('twitter:creator', $author);
$meta .= $this->Html->meta('twitter:image', $socialImage);


// Open Graph

$meta .= $this->Html->meta('og:title', $title);
$meta .= $this->Html->meta('og:type', Cake\Core\Configure::read('Seo.og.type'));
$meta .= $this->Html->meta('og:url', $link);
$meta .= $this->Html->meta('og:image', $socialImage);
$meta .= $this->Html->meta('og:description', $description);
$meta .= $this->Html->meta('og:site_name', Cake\Core\Configure::read('Site.name'));
$meta .= $this->Html->meta('fb:admins', Cake\Core\Configure::read('Facebook.admins'));


$this->assign('meta', $meta);
?>

<section class="sub-banner">
    <div class="container">
        <h2 class="entry-title"><?php echo $contestEntry['contest']['title']; ?></h2>
        <div class=" pull-right">
            <?php
            $time = $contestEntry['contest']['expiry'];
            if (!$time->isPast()) {
                echo $this->Html->link('Participate now!', ['controller' => 'contests', 'action' => 'participate', 'slug' => $contestEntry['contest']['slug']], ['class' => 'btn btn-success']);
            }
            ?>
            <?php echo $this->Html->link('View Entries!', ['controller' => 'contests', 'action' => 'enteries', 'slug' => $contestEntry['contest']['slug']], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

</section>

<section class=" m-b-20">

    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="left-content">
                    <div class="details-news">
                        <?= $this->Flash->render() ?>
                        <div class="post">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <?php echo $this->Awesome->image('ContestParticipates/image', $contestEntry['image'], ['class' => 'img-responsive']); ?>
                                </div>
                            </div>
                            <div class="post-content">								
                                <h2 class="entry-title">
                                    <?php echo $this->Html->link($contestEntry->title, ['controller' => 'contests', 'action' => 'entry', 'slug' => $contestEntry['contest']['slug'], 'entry' => $contestEntry['slug']]); ?>
                                    <?php
                                    $string = 'Like';
                                    if ($contestEntry->likes) {
                                        $string = $contestEntry->likes;
                                        $string .= ($contestEntry->likes > 1) ? ' Likes' : ' Like';

                                        if (!empty($contestEntry->contest_participates_users[0]) && !empty($contestEntry->contest_participates_users[0]['id'])) {

                                            $string = $this->Html->tag('span', $string, ['class' => 'like']);
                                            echo $this->Html->link($string . ' <i class="fa fa-meh-o fa-4" aria-hidden="true"></i>', 'javascript:void(0)', ['class' => 'pull-right liked', 'escape' => false, 'rel' => 'nofollow', 'data-toggle' => "tooltip", 'title' => 'You have liked.']);
                                        } else {
                                            $string = $this->Html->tag('span', $string, ['class' => 'like']);
                                            echo $this->Html->link($string . ' <i class="fa fa-meh-o fa-4" aria-hidden="true"></i>', ['controller' => 'contests', 'action' => 'like', 'slug' => $contestEntry['contest']['slug'], 'entry' => $contestEntry['slug']], ['class' => 'pull-right', 'escape' => false, 'rel' => 'nofollow', 'data-toggle' => "tooltip", 'title' => 'Like']);
                                        }
                                    } else {
                                        $string = $this->Html->tag('span', $string, ['class' => 'like']);
                                        echo $this->Html->link($string . ' <i class="fa fa-meh-o fa-4" aria-hidden="true"></i>', ['controller' => 'contests', 'action' => 'like', 'slug' => $contestEntry['contest']['slug'], 'entry' => $contestEntry['slug']], ['class' => 'pull-right', 'escape' => false, 'rel' => 'nofollow', 'data-toggle' => "tooltip", 'title' => 'Like']);
                                    }
                                    ?>
                                </h2>
                            </div>

                            <div class="post-content">								

                                <?php
                                echo $this->element('share', array(
                                    'url' => $link,
                                    'title' => $contestEntry['title'],
                                    'description' => $contestEntry['title'],
                                    'image' => '',
                                        )
                                );
                                ?>
                                <div class="entry-content">
                                    <?php echo $contestEntry['description']; ?>
                                </div>
                            </div>
                        </div><!--/post--> 
                    </div><!--/.section-->
                </div><!--/.left-content-->
            </div>



        </div>

        <div class="row">
            <div class="col-sm-12">								
                <div class="comments-wrapper">
                    <h1 class="section-title title">Comments</h1>
                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id))
                                return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=194605903956837";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>


                    <div class="comments-box">
                        <form id="comment-form" name="comment-form" method="post">
                            <div class="fb-comments" data-href="<?php echo $link; ?>" data-numposts="5"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/#site-content-->
</section>

