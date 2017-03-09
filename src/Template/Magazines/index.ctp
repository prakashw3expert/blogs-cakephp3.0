<?php
$this->Html->addCrumb('Magazines', ['action' => 'index']);
if (!empty($category)) {
    $this->assign('title', $category);
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="section">
            <div class="row">
                <?php foreach ($magazines as $magazine) {
                    $link = ['controller' => 'magazines', 'action' => 'view','slug' => $magazine['slug']];
                    ?>
                    <div class="col-sm-4">
                        <div class="post medium-post blog-post">

                            <div class="entry-header">
                                <div class="entry-thumbnail text-center magazine_preview">
                                    <?php echo $this->Html->link($this->Awesome->image('Magazines/image', $magazine['image'], ['class' => 'img-responsive', 'type' => 'large']),$link,['escape' => false]) ?>
                                </div>
                            </div>
                            <div class="post-content">								
                                <h2 class="entry-title">
                                    <?php echo $this->Html->link($this->Text->truncate($magazine['title'], 50), $link); ?>
                                </h2>
                            </div>
                        </div><!--/post--> 
                    </div>
                <?php }  ?>
                <?php if ($magazines->count() == 0) { ?>
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
