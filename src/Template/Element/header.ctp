<style type="text/css">
    #mainmenu .dropdown-menu li a{
        padding: 10px 20px !important;
        line-height: 1.8 !important;
    }

</style>

<style type="text/css">
    @media (max-width: 767px){
        .navbar-nav>li>a {
            line-height: 1.8 !important;
        }
    }

</style>
<header id="navigation">
    <div class="navbar" role="banner">
        <div class="container">
            <?php echo $this->Html->link($this->Html->image('logo.png'), ['controller' => 'pages', 'action' => 'display', 'home'], ['escape' => false, 'class' => 'secondary-logo']); ?>
        </div>
        <div class="topbar">
            <div class="container">
                <div id="topbar" class="navbar-header">							
                    <?php echo $this->Html->link($this->Html->image('logo.png', ['class' => 'main-logo img-responsive']), ['controller' => 'pages', 'action' => 'display', 'home'], ['escape' => false]); ?>
                    <div id="topbar-right">

                    </div>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
            </div> 
        </div> 
        <div id="menubar" class="container">	
            <nav id="mainmenu" class="navbar-left collapse navbar-collapse"> 
                <?php echo $this->cell('Menus', [], ['cache' => false]); ?>					
            </nav>
            <div class="searchNlogin">
                <ul>
                    <?php if (!$loggedInAs) { ?>
                        <li class="dropdown user-panel"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                            <div class="dropdown-menu top-user-section">
                                <div class="top-user-form">
                                    <?php
                                    echo $this->Form->create('User', [
                                        'novalidate' => true,
                                        'id' => 'top-login',
                                        'url' => ['plugin' => false, 'controller' => 'users', 'action' => 'login']
                                    ]);
                                    ?>
                                    <div class="input-group" id="top-login-username">
                                        <span class="input-group-addon"><img src="<?php echo $this->request->webroot; ?>img/others/user-icon.png" alt="" /></span>
                                        <?=
                                        $this->Form->input('email', [
                                            'label' => false,
                                            'templates' => [
                                                'inputContainer' => '{{content}}',
                                            ],
                                            'class' => 'form-control',
                                            'placeholder' => 'Email Address'
                                        ]);
                                        ?>
                                    </div>
                                    <div class="input-group" id="top-login-password">
                                        <span class="input-group-addon"><img src="<?php echo $this->request->webroot; ?>img/others/password-icon.png" alt="" /></span>
                                        <?=
                                        $this->Form->input('password', [
                                            'label' => false,
                                            'templates' => [
                                                'inputContainer' => '{{content}}',
                                            ],
                                            'class' => 'form-control',
                                            'placeholder' => 'Password'
                                        ]);
                                        ?>
                                    </div>
                                    <div>
                                        <p class="reset-user"> 
                                            <?= $this->Html->link('I forgot my password', ['plugin' => false, 'controller' => 'users', 'action' => 'forgot']); ?>
                                        </p>
                                        <button class="btn btn-danger" type="submit">Login</button>
                                    </div>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                                <div class="create-account">
                                    <?= $this->Html->link('Create a New Account', ['plugin' => false, 'controller' => 'users', 'action' => 'add']); ?>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                    <?php if ($loggedInAs) { ?>
                        <li class="dropdown user-panel">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                <?= $this->Awesome->image('Users/image', $loggedInAs['image'], ['class' => 'img-circle thumb-sm', 'type' => 'thumbnail', 'width' => 20]); ?>
                            </a>

                            <div class="dropdown-menu top-user-section offline">
                                <ul class="list-group">
                                    <?php if ($loggedInAs['role']['alias'] == 'author') { ?>
                                        <li class="list-group-item"><?= $this->Html->link('My Blogs', ['controller' => 'blogs', 'action' => 'myBlogs'], ['escape' => false]); ?></li>
                                    <?php } else { ?>
                                        <li class="list-group-item"><?= $this->Html->link('Tickets', ['controller' => 'orders', 'action' => 'index'], ['escape' => false]); ?></li>
                                    <?php } ?>
                                    <li class="list-group-item"><?= $this->Html->link('Manage Events', ['controller' => 'events', 'action' => 'myEvents'], ['escape' => false]); ?></li> 
                                    <li class="list-group-item"><?= $this->Html->link('Create an Event', ['controller' => 'events', 'action' => 'add'], ['escape' => false]); ?></li> 
                                    <li class="list-group-item"><?= $this->Html->link('Account Settings', ['controller' => 'users', 'action' => 'view'], ['escape' => false]); ?></li> 
                                    <li class="list-group-item"><?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout'], ['escape' => false]); ?> </li> 
                                </ul>

                            </div>
                        </li>
                    <?php } ?>

                </ul>

            </div><!-- searchNlogin -->
        </div>
    </div>
</header><!--/#navigation--> 