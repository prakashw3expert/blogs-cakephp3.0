<?php
$plugin = $params['plugin'];
$controller = strtolower($params['controller']);
$action = $params['action'];

$menus = array();
$menus[] = $this->Html->link('<i class="ti-home"></i> <span> Dashboard </span>',['plugin' => false,'controller' => 'dashboard','action' => 'index'],['escape' => false]);


$activeClass = ($controller == 'users') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ti-user"></i> <span> Users </span> ',['plugin' => false,'controller' => 'users','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'authors') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ti-user"></i> <span> Authors </span>',['plugin' => false,'controller' => 'authors','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'blogs') ? 'active' : null;
$menus[] = $this->Html->link('<i class=" ti-pencil-alt"></i><span> Blogs </span>',['plugin' => false,'controller' => 'blogs','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'categories') ? 'active' : null;
$menus[] = $this->Html->link('<i class=" ti-layers-alt"></i><span> Categories </span>',['plugin' => false,'controller' => 'categories','action' => 'index'],['escape' => false,'class' => $activeClass]);


$activeClass = ($controller == 'pages') ? 'active' : null;
$menus[] = $this->Html->link('<i class="md md-pages"></i><span> Pages </span>',['plugin' => false,'controller' => 'pages','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'contactqueries') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ion-android-contacts"></i><span> Contact Queries </span>',['plugin' => false,'controller' => 'contactQueries','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'emailtemplates') ? 'active' : null;
$menus[] = $this->Html->link('<i class=" ti-layers-alt"></i><span> Email Templates </span>',['plugin' => false,'controller' => 'emailTemplates','action' => 'index'],['escape' => false,'class' => $activeClass]);

$activeClass = ($controller == 'settings') ? 'active' : null;
//$menus[] = $this->Html->link('<i class="ti-settings"></i><span> Settings </span>',['plugin' => 'settings','controller' => 'settings','action' => 'index'],['escape' => false,'class' => $activeClass]);
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <?php echo $this->Html->nestedList($menus, [], ['class' => 'has_sub']);?>
            
        </div>
        <div class="clearfix"></div>
    </div>
</div>
