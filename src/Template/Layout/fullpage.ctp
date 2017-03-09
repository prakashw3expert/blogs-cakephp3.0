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
    <body>
        <div id="main-wrapper" class="homepage">
            <?php
            echo $this->element('header');
            ?>

            <div class="container">
                
                <div class="section">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $this->Flash->render() ?>
                            <?= $this->fetch('content') ?>
                        </div><!--/.col-sm-9 -->	
                    </div>				
                </div><!--/.section-->
            </div><!--/.container-->
        </div><!--/#main-wrapper-->
        <?php
        echo $this->element('footer');
        ?>
    </body>
</html>

