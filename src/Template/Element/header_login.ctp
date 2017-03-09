<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <?php echo $this->Html->link($this->Html->image('logo.png'), ['controller' => 'pages', 'action' => 'display','home'], ['escape' => false, 'class' => 'logo']); ?>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <ul class="nav navbar-nav navbar-right pull-right">
                    

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                            <?= $loggedInAs['name']; ?>
                            <?= $this->Awesome->image('Users/image', $loggedInAs['image'], ['class' => 'img-circle', 'type' => 'thumbnail']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                            <?= $this->Html->link('<i class="ti-settings m-r-5"></i> Profile Setting',['controller' => 'users','action' => 'view'],['escape' => false]);?>
                                
                            </li>
                            <li>
                            <?= $this->Html->link('<i class="ti-key m-r-5"></i> Change Password',['controller' => 'users','action' => 'chage_password'],['escape' => false]);?>
                                
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="ti-power-off m-r-5"></i> Logout', ['plugin' => false, 'controller' => 'users', 'action' => 'logout'], ['escape' => false]); ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->
