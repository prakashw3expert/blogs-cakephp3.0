<?php
$this->assign('title', $magazine['title']);
$this->Html->addCrumb('Magazines', ['action' => 'index']);
$this->Html->addCrumb($magazine['title'], ['action' => 'view','slug' => $magazine['slug']]);
$title = (!empty($magazine['meta_title'])) ? $magazine['meta_title'] : $magazine['title'];
$title = (!empty($magazine['meta_keyword'])) ? $magazine['meta_keyword'] : $magazine['tags'];
$description = $magazine['meta_description'];



$socialImage = $this->Awesome->image('Magazines/image', $magazine['image'], ['class' => 'img-responsive', 'type' => 'large','tag' => false]);

if( !$description ){
    $description = $this->Text->truncate(strip_tags($magazine['description']),150,['exact' => false]);
}

$link = $this->Url->build(['controller' => 'magazines', 'action' => 'view',  'slug' => $magazine['slug']], ['base' => false]);
$downloadLink = $this->Url->build(['controller' => 'magazines', 'action' => 'download',  'slug' => $magazine['slug']], ['base' => false]);

$meta = null;

$meta .= $this->Html->meta('description', $description);

// Twitter card
$meta .= $this->Html->meta('twitter:card', Cake\Core\Configure::read('Twitter.card'));
$meta .= $this->Html->meta('twitter:site', Cake\Core\Configure::read('Twitter.site'));
$meta .= $this->Html->meta('twitter:title', $title);
$meta .= $this->Html->meta('twitter:description', $description);

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

<div id="site-content" class="site-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="left-content">
                <div class="details-news">											
                    <div class="post">
                        <div class="entry-header text-center">
                            <a href="<?php echo $downloadLink;?>" class="btn btn-primary" style="margin: 20px">Download</a>
                            <div class="entry-thumbnail text-center magazine_preview">
                                
                                <?php echo $this->Awesome->image('Magazines/image', $magazine['image'], ['class' => 'img-responsive1 text-center', 'type' => '']); ?>
                            </div>
                        </div>
                        <div class="post-content text-center">								
                            
                            <h2 class="entry-title">
                                <?php echo $magazine['title']; ?>
                            </h2>
                            <a href="<?php echo $downloadLink;?>" class="btn btn-primary" style="margin: 20px">Download</a>
                            <h4>Share this magazine</h4>
                            <?php
                            echo $this->element('share', array(
                                'url' => $link,
                                'title' => $magazine['title'],
                                'description' => $magazine['title'],
                                'image' => '',
                                    )
                            );
                            ?>
                            <div class="entry-content">
                                <?php echo $magazine['description']; ?>
                            </div>
                        </div>
                    </div><!--/post--> 
                </div><!--/.section-->
            </div><!--/.left-content-->
        </div>



    </div>
</div><!--/#site-content-->
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


        <?php echo $this->cell('Blog::magzines', ['limit' => 6,  'notIn' => $magazine['id']], ['cachse' => true]); ?>
        <div class="post google-add">
            <div class="add inner-add text-center">
                <a href="#"><img class="img-responsive" src="<?php echo $this->request->webroot; ?>img/post/google-add.jpg" alt="" /></a>
            </div><!--/.section-->
        </div><!--/.google-add-->
    </div>
</div>
<script async="" src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

