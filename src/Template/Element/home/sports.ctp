<?php if ($blogs) { ?>
<div class="section sports-section">
    <h1 class="section-title title"><?php echo $category['title']; ?></h1>
    <div class="cat-menu">         
        <?php echo $this->Html->link('See all', ['controller' => 'blogs', 'action' => 'index', 'category' => $category['slug']]); ?>
    </div>										
    <?php foreach ($blogs as $key => $blog) {
        if(isset($blog->category->parent->slug)){
            $link = ['controller' => 'blogs', 'action' => 'view','parent' => $blog->category->parent->slug, 'category' => $blog->category->slug, 'slug' => $blog->slug];
        } else{
            $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog->category->slug, 'slug' => $blog->slug];
        }
        ?>
        <div class="post medium-post single_line_title">
            <div class="entry-header">
                <div class="entry-thumbnail">
                    <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']), $link, ['escape' => false]) ?>
                </div>
            </div>
            <div class="post-content">								
                <div class="entry-meta">
                    <ul class="list-inline">
                        <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $this->Awesome->date($blog['created']); ?> </a></li>
                        <li class="views"><a href="#"><i class="fa fa-eye"></i><?php echo $this->Awesome->niceCount($blog['view_count']); ?></a></li>
                    </ul>
                </div>
                <h2 class="entry-title">
                    <?php echo $this->Html->link($this->Text->truncate($blog['title'], 55), $link); ?>
                </h2>
            </div>
        </div><!--/post--> 
        <?php } ?>

    </div>
    <?php } ?>
