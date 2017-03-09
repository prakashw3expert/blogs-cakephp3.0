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
                <h4>Profile Details</h4>
                
                <div class="form-group">
                    <label class="col-lg-3 control-label">Name <span>*</span></label>
                    <?php
                    echo $this->Form->input('name', [
                        'label' => false,
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ]
                    ]);
                    ?>
                </div>
                <?php if(empty($user->email)) { ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email Address <span>*</span></label>
                        <?php
                        echo $this->Form->input('email', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>
                <?php } ?>


                <div class="form-group">
                    <label class="col-lg-3 control-label">Select Country <span>*</span></label>
                    <?php
                    echo $this->Form->input('country_id', [
                        'label' => false,
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'empty' => 'Select Country',
                        'class' => 'form-control select2'
                            ]
                    );
                    ?>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">DOB <span>*</span></label>
                    <?php
                    echo $this->Form->input('dob', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control datepicker']);
                    
                    ?>
                    <label class="col-lg-2 control-label">Gender </label>
                    <div class="col-lg-3 gender">
                        <?php
                        echo $this->Form->select('gender', $user->genders, ['empty' => 'Select', 'class' => 'select2']);
                        echo $this->Form->error('gender');
                        ?>
                    </div>
                </div>


                <div class="form-group">
                        <label class="col-lg-3 control-label">About </label>
                        <?php
                        echo $this->Form->input('about', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Facebook URL </label>
                    <?php
                    echo $this->Form->input('facebook_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>
                    <label class="col-lg-2 control-label">Instagram Url </label>
                    <?php
                    echo $this->Form->input('instagram_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>

                </div>

                <div class="form-group">

                <label class="col-lg-3 control-label">Google+ URL </label>
                    <?php
                    echo $this->Form->input('google_plus_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>

                    <label class="col-lg-2 control-label">Linked In Url </label>
                    <?php
                    echo $this->Form->input('linkedIn_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>

                </div>

                <div class="form-group">
                    

                    <label class="col-lg-3 control-label">Youtube URL </label>
                    <?php
                    echo $this->Form->input('youtube_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>
                    
                    <label class="col-lg-2 control-label">Website URL </label>
                    <?php
                    echo $this->Form->input('website_url', [
                        'label' => false,
                        'type' => 'text',
                        'templates' => [
                            'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                            'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                        ],
                        'class' => 'form-control']);
                    ?>
                    
                </div>


                <?php $image = null;
                    if (!empty($user->image)) {
                        $image = '<div class="thumbnail " style="width:200px;">' . $this->Awesome->image('Users/image', $user->image, ['class' => 'img-responsive clearfix']) . '
                                                                                                                                    
                                                                                                                            </div>';
                    } ?>
                    <div class="form-group">
                    <label class="col-lg-3 control-label">Profile Image</label>
                    <?php echo $this->Form->input('image', [
                        'templates' => [
                                'inputContainer' => '<div class="col-lg-3 mt10 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                        'class' => 'filestyle',
                        'label' => false,
                        'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']); ?>
                   

                    <?php $image = null;
                    
                    if (!empty($user->cover_image)) {
                    $image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image('Users/cover_image', $user->cover_image, ['class' => 'img-responsive clearfix']) . '
                                                                                                                                    
                                                                                                                            </div>';
                    } ?>
                    
                    <label class="col-lg-2 control-label">Cover Image</label>
                    <?php echo $this->Form->input('cover_image', [
                         'templates' => [
                                'inputContainer' => '<div class="col-lg-3 mt10 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                        'class' => 'filestyle',
                        'label' => false,
                        'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']); ?>
                    </div>
                   


                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <?php
                        echo $this->Form->button('Update Settings', array('class' => 'btn btn-pink','ng-show' => 'editProfile'));
                        ?>

                        <?php
                        $submitBtn = $this->Html->link('Edit Profile', 'javascript:void(0)',array('class' => 'btn btn-pink','ng-show' => '!editProfile','ng-click' =>'enableEdit(1)'));
                        echo $submitBtn;
                        ?>
                        
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>

        </div>

    </div>


