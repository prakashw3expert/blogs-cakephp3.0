<?php
if(isset($categoryData->parent->title)){
    $this->Html->addCrumb(__($categoryData->parent->title), ['action' => 'index','category' => $categoryData->parent->slug]);
}

if (!empty($category)) {
    $this->Html->addCrumb($category, ['action' => 'index']);
    $this->assign('title', $category);
}
$resultCount = $this->Paginator->counter('{{count}}');

if (!empty($this->request->params['tag'])) {
    $this->assign('page_title', $resultCount.' result found for '.$this->request->params['tag']);
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="section">
            <div class="row">
                <?php
                foreach ($blogs as $blog) {
                    $categoryData = $blog->category;
                    
                    if(isset($categoryData->parent->title)){
                    $link = ['controller' => 'blogs', 'action' => 'view','parent' => $categoryData->parent->slug, 'category' => $blog['category']['slug'], 'slug' => $blog['slug']];
                    } else{
                        $link = ['controller' => 'blogs', 'action' => 'view', 'category' => $blog['category']['slug'], 'slug' => $blog['slug']];
                    }
                    ?>
                    <div class="col-sm-4">
                        <div class="post medium-post blog-post">

                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <?php echo $this->Html->link($this->Awesome->image('Blogs/image', $blog['image'], ['class' => 'img-responsive', 'type' => 'thumbnail']),$link,['escape' => false]) ?>
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
                <?php }  ?>
                <?php if ($blogs->count() == 0) { ?>
                    <div class="col-sm-12">
                        <h2 class="entry-title">
                            No records found!!!
                        </h2>
                    </div>
                <?php } ?>
            </div>
        </div><!--/.section -->

    </div>
</div>
<?php echo $this->element('pagination');?>
