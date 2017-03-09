<?php $this->Html->addCrumb('Profile Settings', null); ?>
<script type="text/javascript">
    var isEdit = <?php echo $isEdit;?>;
</script>
<div class="row" ng-controller="editProfileController">
    <div class="col-lg-12 col-md-12">

        <div class="tab-content"> 
            <div class="tab-pane active"> 

                <?php 
                unset($user['password']);
                echo $this->Form->create($user, [
                    'novalidate' => true,
                    'type' => 'file',
                    'class' => 'form-horizontal card-box',
                ]);
                ?>
                <h4>Change Password</h4>
                <hr>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Cureent Password </label>
                    <?php
                    echo $this->Form->input('current_password', [
                        'label' => false,
                        'type' => 'password',
                        'autocomplete' => 'off',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                    ]);
                    ?>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Password </label>
                    <?php
                    echo $this->Form->input('password', [
                        'label' => false,
                        'autocomplete' => 'off',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                    ]);
                    ?>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Verify Password </label>
                    <?php
                    echo $this->Form->input('confirm_password', [
                        'label' => false,
                        'type' => 'password',
                        'autocomplete' => 'off',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                    ]);
                    ?>

                </div>

                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <?php
                        $submitBtn = $this->Form->button('Change Password', array('class' => 'btn btn-pink','ng-show' => 'editProfile'));
                        echo $submitBtn;
                        ?>
                        
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>

        </div>

    </div>


