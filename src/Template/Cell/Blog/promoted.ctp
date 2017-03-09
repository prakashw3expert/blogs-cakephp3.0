<div class="post feature-post">
    <?php if ($blog) {
        if(isset($blog->category->parent->slug)){
            $link = ['controller' => 'blogs', 'action' => 'view','parent' => $blog->category->parent->slug, 'category' => $blog->category->slug, 'slug' => $blog->slug];
        } else{
            $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog->category->slug, 'slug' => $blog->slug];
        }
        ?>
        <div class="entry-header">
            <div class="entry-thumbnail featured_image">
            <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'large']), $link, ['escape' => false]) ?>
            </div>
            <div class="catagory <?php echo $blog['category']['tag'] ?>">
                <?php echo $this->Html->link($blog['category']['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $blog['category']['slug']]); ?>
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
                <?php echo $this->Html->link($this->Text->truncate($blog['title'], 45), $link); ?>
            </h2>
        </div>
        <?php } ?>
    </div><!--/post--> 
