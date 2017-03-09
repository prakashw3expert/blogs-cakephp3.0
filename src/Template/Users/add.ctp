<div class="signup-page">
    <div class="container">
        <div class="row">
            <!-- user-login -->	
            
            <div class="col-sm-6 col-sm-offset-3">
                <?= $this->Flash->render() ?>
                <div class="ragister-account account-login">		
                    <h1 class="section-title title"><?= $title_for_layout;?></h1>
                    <div class="login-options text-center">
                        <a href="javascript:void(0)" ng-click="authenticate('facebook')"  class="facebook-login"><i class="fa fa-facebook"></i> Login with Facebook</a>
                        <a href="javascript:void(0)" ng-click="authenticate('google')"  class="google-login"><i class="fa fa-google-plus"></i> Login with Google</a>

                    </div>
                    <div class="devider text-center">Or</div>
                    <?php
                    echo $this->Form->create($user, [
                        'novalidate' => true,
                    ]);
                    
                    echo $this->Form->input('role_id', ['options' => ['1' => 'User','2' => 'Author'],'label' => 'Are you ?']);
                    
                    echo $this->Form->input('name');
                    
                    echo $this->Form->input('email');

                    echo $this->Form->input('password');
                    echo $this->Form->input('confirm_password', ['type' => 'password']);
                    
                    ?>
                    <!-- checkbox -->
                    <div class="checkbox form-group">
                        <label class="pull-left" for="signing">
                        <?php echo $this->Form->checkbox('signing',['id' => 'signing']); ?>
                           <!--  <input type="checkbox" name="signing" id="signing"> -->
                            I agree to our Terms and Conditions 
                        </label>
                    </div>	
                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="new-user text-center">
                        <p>Already have an account ? <?= $this->Html->link('Signin', ['plugin' => false, 'controller' => 'users', 'action' => 'login']); ?> </p>
                    </div>

                </div>
            </div><!-- user-login -->			
        </div><!-- row -->	
    </div><!-- container -->
</div><!-- signup-page -->


<?php
//$this->extend('/Common/Admin/add');
//$this->Html->addCrumb($modelClass, ['action' => 'index']);
//$this->Html->addCrumb('Add User', null);
//$this->start('form');
//echo $this->Form->create($user, [
//    'novalidate' => true,
//    'align' => $this->Awesome->boostrapFromLayout
//]);
//
//echo $this->Form->input('name');
//// Password
//
//echo $this->Form->input('email');
////echo $this->Form->input('country_id', ['empty' => 'Select Country', 'class' => 'form-control select2']);
////echo $this->Form->input('dob', ['class' => 'form-control datepicker', 'type' => 'text']);
////echo $this->Form->input('gender', ['empty' => 'Select', 'class' => 'select2', 'options' => $user->genders]);
////$image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image('Authors/image', $user['image'], ['class' => 'img-responsive clearfix']) . '
////                                                                                                                
////                                                                                                        </div>';
////echo $this->Form->input('image', [
////    'templates' => ['file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
////    'class' => 'filestyle',
////    'label' => 'Profile Image',
////    'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
//
//
//echo $this->Form->input('password');
//echo $this->Form->input('confirm_password', ['type' => 'password']);
//
////echo $this->Form->button('Add');
//
//$this->end();

