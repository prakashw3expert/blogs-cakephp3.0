<div class="signup-page">
    <div class="container">
        <div class="row">
            <!-- user-login -->			
            <div class="col-sm-6 col-sm-offset-3">
                <div class="ragister-account account-login">		
                    <h1 class="section-title title">User Login</h1>
                    <div class="login-options text-center">
                        <a href="javascript:void(0)" ng-click="authenticate('facebook')"  class="facebook-login"><i class="fa fa-facebook"></i> Login with Facebook</a>
                        <a href="javascript:void(0)" ng-click="authenticate('google')"  class="google-login"><i class="fa fa-google-plus"></i> Login with Google</a>

                    </div>
                    <div class="devider text-center">Or</div>
                    <?= $this->Flash->render('auth') ?>
                    <?= $this->Flash->render() ?>
                    <?php
                    echo $this->Form->create('User', [
                        'novalidate' => true,
                        'id' => 'registation-form'
                    ]);

                    echo $this->Form->input('email');

                    echo $this->Form->input('password');
                    ?>
                    <!-- checkbox -->
                    <div class="checkbox">
                        <label class="pull-left"><input type="checkbox" name="signing" id="signing"> Keep Me Login </label>
                        <?= $this->Html->link('I forgot my password?',['plugin' => false,'controller' => 'users','action' => 'forgot'],['class' => 'pull-right']);?>
                        
                    </div><!-- checkbox -->	
                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="new-user text-center">
                        <p>Don't have an account ? <?= $this->Html->link('Register Now',['plugin' => false,'controller' => 'users','action' => 'add']);?> </p>
                    </div>

                </div>
            </div><!-- user-login -->			
        </div><!-- row -->	
    </div><!-- container -->
</div><!-- signup-page -->

<?php 
echo $this->start('jsSection');
echo $this->Html->script('satellizer.min.js'); 
echo $this->Html->script('satellizer.js'); 
$this->end();?>