<?php
$categorySlug = $blog['category']['slug'];
if(!empty($blog['category']['parent']['slug'])){
    $categorySlug  = $blog['category']['parent']['slug'];
    $this->Html->addCrumb(__($blog['category']['parent']['title']), ['action' => 'index','category' => $blog['category']['parent']['slug']]);
}
$this->Html->addCrumb($blog['category']['title'], ['action' => 'index','category' => $blog['category']['slug']]);
// $this->Html->addCrumb($blog['title'], ['action' => 'view','category' => $blog['category']['slug'],'slug' => $blog['slug']]);
//echo "<pre>";print_r($blog);die;
$title = (!empty($blog['meta_title'])) ? $blog['meta_title'] : $blog['title'].' | '.$blog['category']['title'];
$keywords = (!empty($blog['meta_keyword'])) ? $blog['meta_keyword'] : $blog['tags'];
$description = $blog['meta_description'];

$author = $blog['user']['name'];
$this->assign('title', $title);
$this->assign('page_title', $blog['title']);
$socialImage = $this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'large','tag' => false]);

if( !$description ){
    $description = $this->Text->truncate(strip_tags($blog['description']),150,['exact' => false]);
}

$link = $this->Url->build(['controller' => 'blogs', 'action' => 'view', 'category' => $blog['category']['slug'], 'slug' => $blog['slug']], ['base' => false]);


$meta = null;

$meta .= $this->Html->meta('keywords', $keywords);
$meta .= $this->Html->meta('description', $description);

// Twitter card
$meta .= $this->Html->meta('twitter:card', Cake\Core\Configure::read('Twitter.card'));
$meta .= $this->Html->meta('twitter:site', Cake\Core\Configure::read('Twitter.site'));
$meta .= $this->Html->meta('twitter:title', $title);
$meta .= $this->Html->meta('twitter:url', $title);
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

$tags = ($blog['tags']) ? explode(',',$blog['tags']) : null;

$this->assign('meta', $meta);

?>

<div id="site-content" class="site-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="left-content">
                <div class="details-news">                                          
                    <div class="post">
                        <div class="entry-header">
                        <?php if($blog['image'] && file_exists('files/Blogs/image/'.$blog['image'])) { ?>
                            <div class="entry-thumbnail">
                                <?php echo $this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'large']); ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="post-content">                              
                            <div class="entry-meta">
                                <ul class="list-inline">
                                    <li class="posted-by"><i class="fa fa-user"></i> by 
                                        <?php echo $this->Html->link($blog['user']['name'], ['controller' => 'authors','action' => 'view','slug' => $blog['user']['slug']]); ?>
                                    </li>
                                    <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $this->Awesome->date($blog['created']); ?> </a></li>
                                    <li class="views"><i class="fa fa-eye"></i><a href="#"><?php echo $this->Awesome->niceCount($blog['view_count']); ?></a></li>
<!--                                    <li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
    <li class="comments"><i class="fa fa-comment-o"></i><a href="#">189</a></li>-->
</ul>
</div>
<h2 class="entry-title">
    <?php echo $blog['title']; ?>
</h2>

<div class="entry-content">
    <div class="blog-contents-editor">
        <?php echo $blog['description']; ?>
    </div>
    <h4 class="mt-10">Share this <?php echo ($categorySlug == 'news') ? 'News' : 'Blog';?></h4>
    <?php
    echo $this->element('share', array(
        'url' => $link,
        'title' => $blog['title'],
        'description' => $blog['title'],
        'image' => '',
        )
    );
    ?>
    <?php if(!empty($tags)) { ?>
    <h5>Tags</h5>
    <ul class="list-inline tag-cloud  feature-post">
        <?php foreach ($tags as $key => $value) {
            if(!empty($value)){
                echo '<li class="catagory sport">'.$this->Html->link($value,['controller' => 'blogs','action' => 'index','tag' => urlencode($value)],['class' => '']).'</li>';
            }
            
        } ?>
    </ul>
    <?php } ?>
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
        <div class="post google-add">
            <div class="add inner-add text-center">
                <a href="#"><img class="img-responsive" src="<?php echo $this->request->webroot; ?>img/post/google-add.jpg" alt="" /></a>
            </div><!--/.section-->
        </div><!--/.google-add-->

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


        <?php echo $this->cell('Blog::blogsByCategory', ['category' => $blog['category'], 'limit' => 6, 'block' => 'related', 'notIn' => $blog['id']], ['cachse' => true]); ?>

    </div>
</div>
<script async="" src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<style type="text/css">
    .blog-contents-editor img{width: 100% !important}
</style>
