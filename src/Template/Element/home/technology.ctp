<?php
if (!empty($blogs)) {
    $blog = $blogs[0];
    if(isset($blog->category->parent->slug)){
        $link = ['controller' => 'blogs', 'action' => 'view','parent' => $blog->category->parent->slug, 'category' => $blog->category->slug, 'slug' => $blog->slug];
    } else{
        $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog->category->slug, 'slug' => $blog->slug];
    }
    unset($blogs[0]);
    ?>
    <div class="section technology-news">
        <h1 class="section-title"><?php echo $category['title']; ?></h1>
        <div class="cat-menu">         
           <?php echo $this->Html->link('See all',['controller' => 'blogs','action' => 'index','category' => $category['slug']]);?>
       </div>
       <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="post">
                <div class="entry-header">
                    <div class="entry-thumbnail technology-news">
                        <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'large']),$link,['escape' => false]) ?>
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
                        <?php echo $this->Html->link($this->Text->truncate($blog['title'],60), $link); ?>
                    </h2>
                    <div class="entry-content">
                        <p><?php echo $this->Text->truncate(strip_tags($blog['description']), 137); ?></p>
                    </div>
                </div>
            </div><!--/post--> 
        </div>
        <div class="col-md-4 col-sm-12">
            <?php foreach ($blogs as $blog) { 
                if(isset($blog->category->parent->slug)){
                    $link = ['controller' => 'blogs', 'action' => 'view','parent' => $blog->category->parent->slug, 'category' => $blog->category->slug, 'slug' => $blog->slug];
                } else{
                    $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog->category->slug, 'slug' => $blog->slug];
                }
                ?>
                <div class="post small-post">
                    <div class="entry-header">
                        <div class="entry-thumbnail technology-news-small">
                            <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']),$link,['escape' => false]) ?>
                        </div>
                    </div>
                    <div class="post-content">								
                        <div class="entry-meta">
                            <ul class="list-inline">
                                <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $this->Awesome->date($blog['created']); ?> </a></li>
                            </ul>
                        </div>
                        <h2 class="entry-title">
                            <?php echo $this->Html->link($this->Text->truncate($blog['title'],38), $link); ?>
                        </h2>
                    </div>
                </div><!--/post--> 
                <?php } ?>
            </div>
        </div>
    </div><!--/technology-news-->
    <?php } ?>