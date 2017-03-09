<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$site =  \Cake\Core\Configure::read('Site.name');

?>
<!DOCTYPE html>
<html>
    <?= $this->element('head') ?>
    <body>
        <div class="error-page text-center">
            <div class="container">
                <div class="logo">
                    <?php echo $this->Html->link($this->Html->image('logo.png', ['class' => 'img-responsive']), ['controller' => 'pages', 'action' => 'display', 'home'], ['escape' => false,'alt' => $site]); ?>
                </div>
                <div class="error-content">
                    <?php echo $this->Html->image('others/error.png', ['class' => 'img-responsive','alt' => '']); ?>
                    <h1>Something Wrong Here</h1>
                    <p>The requested URL /das was not found on this server.</p>
                    <?php echo $this->Html->link('Back Home',['controller' => 'pages','action' => 'display','home'],['class' => 'btn btn-primary']);?>
                </div>
                <div class="copyright">
                    <p><?php echo \Cake\Core\Configure::read('Site.copyright');?></p>
                </div>

            </div><!--/.container-->
        </div><!--/#main-wrapper-->
        <?= $this->AssetCompress->script('main'); ?>
    </body>
</html>