<div class="widget">
    <h1 class="section-title title">Popular</h1>
    <ul class="post-list">
        <?php foreach ($blogs as $blog) {
            if(isset($blog->category->parent->slug)){
                $link = ['controller' => 'blogs', 'action' => 'view','parent' => $blog->category->parent->slug, 'category' => $blog->category->slug, 'slug' => $blog->slug];
            } else{
                $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog->category->slug, 'slug' => $blog->slug];
            }
            ?>
            <li>
                <div class="post small-post">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']),$link,['escape' => false]) ?>
                        </div>
                    </div>
                    <div class="post-content">								
<!--                        <div class="video-catagory">
                            <?php //echo $this->Html->link($blog['category']['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $blog['category']['slug']]); ?>
                        </div>-->

                        <h2 class="entry-title">
                        <?php echo $this->Html->link($this->Text->truncate($blog['title'], 45), $link); ?>
                        </h2>
                    </div>
                </div><!--/post--> 
            </li>
            <?php } ?>
        </ul>
    </div><!--/#widget-->
