<div class="section lifestyle-section">
    <h1 class="section-title">More Magazines</h1>
    <div class="cat-menu">         
        <?php echo $this->Html->link('See all', ['controller' => 'magazines', 'action' => 'index']); ?>
    </div>
    <div class="row">
        <?php
        foreach ($magazines as $magazine) {
            $link = ['controller' => 'magazines', 'action' => 'view', 'slug' => $magazine['slug']];
            ?>
            <div class="col-sm-4">
                <div class="post medium-post blog-post">

                    <div class="entry-header">
                        <div class="entry-thumbnail text-center magazine_preview">
                            <?php echo $this->Html->link($this->Awesome->image('Magazines/image', $magazine['image'], ['class' => 'img-responsive', 'type' => 'large']), $link, ['escape' => false]) ?>
                        </div>
                    </div>
                    <div class="post-content">								
                        <h2 class="entry-title">
                            <?php echo $this->Html->link($this->Text->truncate($magazine['title'], 50), $link); ?>
                        </h2>
                    </div>
                </div><!--/post--> 
            </div>
        <?php } ?>

    </div>
</div>
