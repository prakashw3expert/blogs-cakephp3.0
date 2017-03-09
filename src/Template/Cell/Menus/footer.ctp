<?php

foreach ($menus as $menu) {
    $menu = json_decode($menu,true);
    $slug = $menu['slug'];
    ?>
    <div class="col-sm-2">
        <div class="widget">
            <h2><?php echo $menu['title']; ?></h2> 
            <?php
            if (!empty($menu['child_categories'])) {
                $subMneus = array();
                echo '<ul>';
                foreach ($menu['child_categories'] as $key => $childCategory) { 
                    $slug = $childCategory['slug'];
                    echo $this->element('footer-category', ['category' => $childCategory, 'key' => $key, 'slug' => $slug]);
                }
                if (count($menu['child_categories']) > 4) {
                    echo $this->Html->tag("li",$this->Html->link('<i>Load More</i>', 'javascript:void(0)', ['escape' => false,'class' => 'load_more_categories']));
                }
                echo '</ul>';
            }
            ?>

        </div>
    </div>

<?php } ?>

