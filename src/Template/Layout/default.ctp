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
?>
<!DOCTYPE html>
<html class="loading">
<?= $this->element('head') ?>
<body class="pj-main">
    <div id="main-wrapper" class="homepage">
        <?php
        echo $this->element('header');
        ?>

        <div class="container">
            <?php
            $topAds = Cake\Core\Configure::read('Ads.Top');
            if (!empty($topAds)) {
                ?>
                <div class="google-add">
                    <div class="add inner-add text-center">
                        <?php echo $topAds;?>
                    </div><!--/.section-->
                </div>
                <?php } ?>
                <div class="page-breadcrumbs">
                    <h1 class="section-title"><?php echo ($this->fetch('page_title')) ? $this->fetch('page_title') : $this->fetch('title') ?></h1>	
                    <div class="world-nav cat-menu"> 
                        <?php
                        echo $this->Html->getCrumbList(
                                [
                            'lastClass' => 'active',
                            'class' => 'list-inline',
                                ], ['text' => 'Home',
                            'url' => ['controller' => 'pages', 'action' => 'display','home'],]
                        );
                        ?>
                    </div>
                </div>
                <div class="section">
                    <div class="row">
                        <div class="col-sm-9">
                            <?= $this->Flash->render() ?>
                            <?= $this->fetch('content') ?>
                        </div><!--/.col-sm-9 -->	

                        <div class="col-sm-3">
                            <?php echo $this->element('right-side'); ?>
                        </div>
                    </div>				
                </div><!--/.section-->
            </div><!--/.container-->
        </div><!--/#main-wrapper-->
        <?php
        echo $this->element('footer');
        ?>

    </body>
    </html>
