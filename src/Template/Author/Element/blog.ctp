<div class="entry-header">
    <div class="entry-thumbnail">
        <?php echo $this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'large']) ?>
    </div>
    <div class="catagory world"><a href="#"><?php echo $blog['category']['title']; ?></a></div>
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
        <?php echo $this->Html->link($this->Text->truncate($blog['title'], 40), ['controller' => 'blog', 'action' => 'view', 'slug' => $blog['slug'], 'id' => $blog['id']]); ?>
    </h2>
</div>