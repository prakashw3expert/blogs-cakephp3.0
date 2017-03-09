<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <?php echo $this->Html->link($this->Html->image('logo.png'), ['controller' => 'blogs', 'action' => 'index'], ['escape' => false, 'class' => 'logo']); ?>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <ul class="nav navbar-nav navbar-right pull-right">

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                            <?= $loggedInAs['name']; ?>
                            <img src="<?php echo $this->request->webroot; ?>assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                            <!--<li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li>-->

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
