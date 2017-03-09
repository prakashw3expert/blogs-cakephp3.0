<ul class="nav navbar-nav">                       
    <?php
    $key = 0;
    foreach ($menus as $menu) {
        $key++;
        $menu = json_decode($menu, true);
        $slug = $menu['slug'];
        ?>
        <li class="more dropdown">
            <?php
            if ($menu['child_categories']) {
                echo $this->Html->link($menu['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $slug], ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
            } else {
                echo $this->Html->link($menu['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $slug], []);
            }

            if (!empty($menu['child_categories'])) {
                $subMneus = array();
                foreach ($menu['child_categories'] as $childCategory) {
                    $slug = $childCategory['slug'];
                    $subMneus[] = $this->Html->link($childCategory['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $slug,'parent' => $menu['slug']]);
                    
                }
                echo $this->Html->nestedList($subMneus, ['class' => 'dropdown-menu', 'style'=>'right:auto;']);
            }
            ?>
        </li>
        <?php
        if ($key == 1) {
            echo '<li class="environment dropdown mega-dropdown">';
            echo $this->Html->link('Events', ['controller' => 'events', 'action' => 'index'], ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
            echo '</li>';
        }

        if ($key == 3) {
            echo '<li class="environment dropdown mega-dropdown">';
            echo $this->Html->link('Contest', ['controller' => 'contests', 'action' => 'index'], ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
            echo '</li>';
        }
    }
    ?>


</ul> 