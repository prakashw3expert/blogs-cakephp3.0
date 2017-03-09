<div class="post small-post">
    <div class="entry-header">
        <div class="entry-thumbnail">
            <?php echo $this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']) ?>
        </div>
    </div>
    <div class="post-content">								
        <div class="entry-meta">
            <ul class="list-inline">
                <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $this->Awesome->date($blog['created']); ?> </a></li>
            </ul>
        </div>
        <h2 class="entry-title">
            <?php echo $this->Html->link($this->Text->truncate($blog['title'],50), ['controller' => 'blog', 'action' => 'view', 'slug' => $blog['slug'], 'id' => $blog['id']]); ?>
        </h2>
    </div>
</div><!--/post--> 