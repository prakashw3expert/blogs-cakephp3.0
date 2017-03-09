<?php
$plugin = $params['plugin'];
$controller = strtolower($params['controller']);
$action = $params['action'];

if ($loggedInAs['role']['alias'] == 'author') {
   $activeClass = ($controller == 'blogs' ) ? 'active' : null;
$menus[] = $this->Html->link('<i class="ion-edit"></i><span> Manage Blogs </span>',['plugin' => false,'controller' => 'blogs','action' => 'myBlogs'],['escape' => false,'class' => $activeClass]);
 
}
$activeClass = ($controller == 'events'  && $action != 'add') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ion-calendar"></i><span> Manage Events </span>',['plugin' => false,'controller' => 'events','action' => 'myEvents'],['escape' => false,'class' => $activeClass]);


$activeClass = ($controller == 'events' && $action == 'add') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ion-calendar"></i><span> Create Events </span>',['plugin' => false,'controller' => 'events','action' => 'add'],['escape' => false,'class' => $activeClass]);


$activeClass = ($controller == 'orders') ? 'active' : null;
$menus[] = $this->Html->link('<i class=" fa fa-inr"></i><span> Tickets </span>',['plugin' => false,'controller' => 'orders','action' => 'index'],['escape' => false,'class' => $activeClass]);




$activeClass = ($controller == 'users') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ti-settings"></i><span> Profile Settings </span>',['plugin' => false,'controller' => 'users','action' => 'view'],['escape' => false,'class' => $activeClass]);


$activeClass = ($controller == 'settings') ? 'active' : null;
$menus[] = $this->Html->link('<i class="ti-power-off"></i><span> Logout </span>',['plugin' => false,'controller' => 'users','action' => 'logout'],['escape' => false,'class' => $activeClass]);
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
