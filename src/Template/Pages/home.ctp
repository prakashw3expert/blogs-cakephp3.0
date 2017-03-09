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
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;

$this->layout = 'home';

$blockDetails = [
    1 => ['name' => 'technology', 'itemCount' => 3],
    2 => ['name' => 'health', 'itemCount' => 6],
    3 => ['name' => 'lifestyle', 'itemCount' => 6],
    4 => ['name' => 'sports', 'itemCount' => 4],
    5 => ['name' => 'sports', 'itemCount' => 4],
];
?>

<div class="section">
    <div class="row">
        <div class="site-content col-md-9">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $featured = $this->cell('Blog::featured', [], ['cache' => false]);
                    if ($featured) {
                        echo $featured;
                    }
                    ?>
                </div>
                <!-- <div class="col-sm-4">
                    <?php
                    // $promoted = $this->cell('Blog::promoted', [], ['cache' => false]);
                    // if ($promoted) {
                    //     echo $promoted;
                    // }
                    ?>
                </div> -->
            </div>
            <div class="row">
                <?php
                $promoted = $this->cell('Blog::updated', [], ['cache' => false]);
                if ($promoted) {
                    echo $promoted;
                }
                ?>
            </div>
        </div><!--/#content-->

        <div class="col-md-3 visible-md visible-lg">
            <?= $this->element('ads',['type' => 'Home.First']);?>
        </div><!--/#add-->
    </div>
</div><!--/.section-->

<div class="section add inner-add">
    <?= $this->element('ads',['type' => 'Home.Second']);?>
</div><!--/.section-->

<div class="section">
    <div class="row">
        <div class="col-md-9 col-sm-8">
            <div id="site-content">
                <div class="row">
                    <div class="col-md-8 col-sm-6">
                        <div class="left-content">

                            <?php
                            $block = 1;
                            foreach ($nomeCategories as $key => $value) {
                                $category = json_decode($value, true);
                                echo $this->cell('Blog::blogsByCategory', ['category' => $category, 'limit' => $blockDetails[$block]['itemCount'], 'block' => $blockDetails[$block]['name']], ['cachse' => true]);
                                $block++;
                                unset($nomeCategories[$key]);
                                if ($block > 3) {
                                    break;
                                }
                            }
                            ?>


                            <div class="section add inner-add">
                                <a href="#"><img class="img-responsive" src="<?php echo $this->request->webroot; ?>img/post/add/add4.jpg" alt="" /></a>
                            </div>


                        </div><!--/.left-content-->
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="middle-content">
                            <?php
                            $block = 4;
                            foreach ($nomeCategories as $key => $value) {
                                $category = json_decode($value, true);
                                echo $this->cell('Blog::blogsByCategory', ['category' => $category, 'limit' => $blockDetails[$block]['itemCount'], 'block' => $blockDetails[$block]['name']], ['cachse' => true]);
                                $block++;
                                if ($block > 5) {
                                    break;
                                }
                                unset($nomeCategories['$key']);
                            }
                            ?>

                        </div><!--/.middle-content-->
                    </div>
                </div>
            </div><!--/#site-content-->
        </div>
        <div class="col-md-3 col-sm-4">
            <?php echo $this->element('right-side'); ?>
        </div>
    </div>
</div><!--/.section-->
