<footer id="footer">
    <div class="footer-top">
        <div class="container text-center">
            <div class="logo-icon">
                <?php echo $this->Html->image('logo.png', ['class' => 'img-responsive']); ?>
            </div>
        </div>
    </div>
    <div class="footer-menu">
        <div class="container">
            <ul class="nav navbar-nav">                       
                <li><?php echo $this->Html->link('Home', ['plugin' => false, 'controller' => 'pages', 'action' => 'display', 'home']); ?></li>
                <li><?php echo $this->Html->link('About', ['plugin' => false, 'controller' => 'pages', 'action' => 'view', 'about-us']); ?></li>
                <li><?php echo $this->Html->link('Privacy Policy', ['plugin' => false, 'controller' => 'pages', 'action' => 'view', 'privacy-policy']); ?></li>
                <li><?php echo $this->Html->link('Term & Condtions', ['plugin' => false, 'controller' => 'pages', 'action' => 'view', 'term-and-conditions']); ?></li>
                <li><?php echo $this->Html->link('Events', ['plugin' => false, 'controller' => 'events', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link('Contests', ['plugin' => false, 'controller' => 'contests', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link('Magazines', ['plugin' => false, 'controller' => 'magazines', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link('Contact Us', ['plugin' => false, 'controller' => 'contacts', 'action' => 'view', 'contact-us']); ?></li>
            </ul> 
        </div>
    </div>
    <div class="bottom-widgets">
        <div class="container">
            <?php echo $cell = $this->cell('Menus::footer', [], ['cache' => true]); ?>
            <div class="col-sm-4">
                <div class="widget news-letter">
                    <h2>Subscribe Our Newsletter</h2>
                    <div class="alert "  ng-if="SubscribeMessage" ng-class="{'alert-success' : SubscribeStatus, 'alert-danger' : !SubscribeStatus}">
                      {{SubscribeMessage}}
                    </div>
                    <div  ng-show="!SubscribeStatus">
                        <form action="#" method="post" id="subscribe-form" name="subscribe-form" ng-submit="Subscribe($event)" >
                            <input type="email" placeholder="Your E-mail" name="email" required="" ng-model="email">
                            <button type="submit" name="subscribe" id="subscribe">Subscribe</button>
                        </form>
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; Copyrights reserved 2016, PlanetJaipur.com 
                <a href="" class="pull-right">Developed By: Bekground.com</a>
            </p>
        </div>
    </div>		
</footer>

<?= $this->AssetCompress->script('main'); ?>

<?= $this->Html->script('events/main1'); ?>

<?= $this->Html->script('angular'); ?>

<?= $this->fetch('jsSection');?>