<?php

$this->Html->addCrumb('Authors', ['action' => 'index']);

$this->Html->addCrumb($user->name, null);

?>

   <!--  <section class="content-header">
      <h3>
        Author Profile
      </h3>
    </section> -->

     <!-- <section class="content"> -->
      <div class="row">
      <div class="col-md-4 col-lg-3">
          <!-- Widget: user widget style 1 -->
          <div class="profile-detail card-box">
            <div>
          
               <?php echo $this->Awesome->image('Users/image', $user->image, ['class' => 'img-circle thumb-md clearfix', 'type' => 'thumbnail']); ?>
               
            <h3 class="profile-username text-center"><?php echo $user->name; ?></h3>

            <hr>
            <div class="text-left">
                    <p class="text-muted font-13"><strong>Email :</strong> <a class="pull-right"><?php echo $user->email; ?></a></p>
                    <p class="text-muted font-13"><strong>Gender :</strong> <a class="pull-right"><?php echo $user->gender; ?></a></p>

                   <!--  <div class="button-list m-t-20">
                        <?php if ($user->facebook_id) { ?>
                            <button type="button" class="btn btn-facebook waves-effect waves-light">
                                <i class="fa fa-facebook"></i>
                            </button>
                        <?php } ?>
                        <?php if ($user->twitter_id) { ?>
                            <button type="button" class="btn btn-twitter waves-effect waves-light">
                                <i class="fa fa-twitter"></i>
                            </button>
                        <?php } ?>
                        <?php if ($user->google_id) { ?>
                            <button type="button" class="btn btn-googleplus waves-effect waves-light">
                                <i class="fa fa-google-plus"></i>
                            </button>
                        <?php } ?>

                    </div> -->
            </div>
          </div>
          <!-- /.widget-user -->
         </div>
        </div>
        <div class="col-lg-9 col-md-8">
          <!--  <div class="nav-tabs-custom"> -->
            <ul class="nav nav-tabs tabs">
              <li class="active" style="width: 25%;"><a href="#settings" data-toggle="tab" >Settings</a></li>
              <li style="width: 25%;"><a href="#blogs" data-toggle="tab">Blogs</a></li>
              <li style="width: 25%;"><a href="#events" data-toggle="tab">Events</a></li>
              <li style="width: 25%;"></li>
            </ul> 

            <div class="tab-content"> 
                <div class="tab-pane active" id="settings"> 
                    <?php
                    unset($user['password']);
                    echo $this->Form->create($user, [
                        'novalidate' => true,
                        'type' => 'file',
                        'class' => 'form-horizontal'
                    ]);
                    ?>
                    <h4>Profile Details</h4>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Name <span>*</span></label>
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
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Email<span>*</span></label>
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

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Designation <span>*</span></label>
                        <?php
                        echo $this->Form->input('designation', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">DOB <span>*</span></label>
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
                        <label class="col-lg-1 control-label">Gender </label>
                        <div class="col-lg-4 gender">
                            <?php
                            echo $this->Form->select('gender', $user->genders, ['empty' => 'Select', 'class' => 'select2']);
                            echo $this->Form->error('gender');
                            ?>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Select Country <span>*</span></label>
                        <?php
                        echo $this->Form->input('country_id', [
                            'label' => false,
                            'empty' => 'Select Country',
                            'class' => 'form-control select2',
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    <?php $image = null;
                    if (!empty($user->image)) {
                        $image = '<div class="thumbnail " style="width:200px;">' . $this->Awesome->image('Users/image', $user->image, ['class' => 'img-responsive clearfix']) . '
                                                                                                                                    
                                                                                                                            </div>';
                    } ?>
                    <div class="form-group">
                    <label class="col-lg-2 control-label">Profile Image</label>
                    <?php echo $this->Form->input('image', [
                        'templates' => [
                                'inputContainer' => '<div class="col-lg-5 mt10 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                        'class' => 'filestyle',
                        'label' => false,
                        'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']); ?>
                    </div>

                    <?php $image = null;
                    if (!empty($user->cover_image)) {
                    $image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image('Users/cover_image', $user->cover_image, ['class' => 'img-responsive clearfix']) . '
                                                                                                                                    
                                                                                                                            </div>';
                    } ?>
                    <div class="form-group">
                    <label class="col-lg-2 control-label">Cover Image</label>
                    <?php echo $this->Form->input('cover_image', [
                         'templates' => [
                                'inputContainer' => '<div class="col-lg-5 mt10 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                        'class' => 'filestyle',
                        'label' => false,
                        'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']); ?>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-lg-2 control-label">About </label>
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
                        <label class="col-lg-2 control-label">Facebook Url </label>
                        <?php
                        echo $this->Form->input('facebook_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Youtube Url </label>
                        <?php
                        echo $this->Form->input('youtube_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-lg-2 control-label">Instagram Url </label>
                        <?php
                        echo $this->Form->input('instagram_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-2 control-label">Google Plus Url </label>
                        <?php
                        echo $this->Form->input('google_plus_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Linked In Url </label>
                        <?php
                        echo $this->Form->input('linkedIn_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Pinterest Url </label>
                        <?php
                        echo $this->Form->input('pinterest_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div>

                    <!-- <div class="form-group m-b-0">
                        <div class="col-sm-offset-4 col-sm-9 m-t-15"> -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                            echo $this->Form->button('<span>Update Profile</span>', array('class' => 'btn btn-pink')); ?>

                           <!--<?php echo $this->Html->link('<span>Delete</span>', ['action' => 'delete', $user->id], ['escape' => false, 'class' => 'btn btn-danger m-l-5', 'confirm' => __('Are you sure you want to delete this user ? ')]); ?>

                           <?php if ($user->status) {
                                echo $this->Html->link('<span>Block</span>', ['action' => 'changeStatus', $user->id, $user->status], ['escape' => false, 'class' => 'btn btn-info m-l-5', 'confirm' => __('Are you sure you want to block this user ? ')]);
                            } else {
                                echo $this->Html->link('<span>Unblock</span>', ['action' => 'changeStatus', $user->id, $user->status], ['escape' => false, 'class' => 'btn btn-info m-l-5', 'confirm' => __('Are you sure you want to block this user ? ')]);
                            }
                            ?>-->
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-lg-2 control-label">Active</label>
                    <div class="col-lg-3 gender">
                        <?php
                        echo $this->Form->select('status', $status, ['empty' => 'Select', 'class' => 'select2']);
                        echo $this->Form->error('status');
                        ?>
                    </div>
                </div>
                    <hr>
                    <h4>Change Password</h4>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Password </label>
                        <?php
                        echo $this->Form->input('password', [
                            'label' => false,
                            'autocomplete' => 'off',
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ],
                        ]);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Verify Password </label>
                        <?php
                        echo $this->Form->input('confirm_password', [
                            'label' => false,
                            'type' => 'password',
                            'autocomplete' => 'off',
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ],
                        ]);
                        ?>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php
                            $submitBtn = $this->Form->button('Change Password', array('class' => 'btn btn-pink'));
                            echo $submitBtn;
                            ?>
                        </div>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>

                <div class="tab-pane" id="blogs"> 
                        <?php
                        $tableHeaders = array();
                        $tableHeaders[] = array('' => array('style' => 'width:5%'));
                        $tableHeaders[] = array('Blog name' => array('style' => 'width:40%'));
                        $tableHeaders[] = array('Category' => array('style' => 'width:20%'));
                        $tableHeaders[] = array('Status' => array('style' => 'width:10%'));
                        $tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));
                        $rows = array();
                        if ($blogs->count() > 0) {
                            foreach ($blogs->toArray() as $key => $listOne) {
                                $listOne = $listOne->toArray();
                                $row = array();
                                $label = null;

                                $row[] = $this->Awesome->image('Blogs/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix index-image']);
                                $row[] = $label . $this->Html->link($listOne['title'], ['controller' => 'blogs', 'action' => 'view', 'slug' => $listOne['slug']]);              
                                
                                $row[] = $listOne['category']['title'];   
                                $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => ''));

                                $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('controller' => 'blogs', 'action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));


                                $row[] = array($links, array('class' => 'text-center'));
                                $rows[] = $row;
                            }
                        } else {
                            $noresult = '<div class="text-center clearfix m-b-20 m-t-10">
                                                        <span class="mini-stat-icon bg-info" style="float: none">
                                                        <i class="ion-information-circled text-white"></i>
                                                    </span>
                                                    </div>
                                                    <h4>' . $user->name . ' didn\'t add blogs yet!!</h4>';
                            $row[] = array($noresult, array('class' => 'text-center noresult', 'colspan' => 5));
                            $rows[] = $row;
                        }
                        ?>
                        <div class="table-responsive">

                            <table class="tablesaw table tablesaw-swipe">
                                <thead>
                                    <?php echo $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')); ?>
                                </thead>
                                <tbody>
                                    <?= $this->Html->tableCells($rows) ?>
                                </tbody>
                            </table>

                        </div>

                </div>

                <div class="tab-pane" id="events"> 
                        <?php
                        $tableHeaders = array();
                        $tableHeaders[] = array('' => array('style' => 'width:5%'));
                        $tableHeaders[] = array('Events name' => array('style' => 'width:35%'));
                        $tableHeaders[] = array('Event Date & Time' => array('style' => 'width:40%'));
                        $tableHeaders[] = array('Status' => array('style' => 'width:10%'));
                        $tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));
                        $rows = array();
                        if ($events->count() > 0) {
                            foreach ($events->toArray() as $key => $listOne) {
                                $listOne = $listOne->toArray();
                                $row = array();
                                $label = null;

                                $row[] = $this->Awesome->image('Events/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix index-image']);
                                $row[] = $label . $this->Html->link($listOne['title'], ['controller' => 'events', 'action' => 'view', 'slug' => $listOne['slug']]);              
                                
                                $row[] = $this->element('event_date',['event' => $listOne]).' '.$this->element('event_time',['event' => $listOne]);
                                $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => ''));

                                $links = $this->Html->link(__('<i class="fa fa-edit"></i>'), array('controller' => 'events', 'action' => 'edit', $listOne['id']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));


                                $row[] = array($links, array('class' => 'text-center'));
                                $rows[] = $row;
                            }
                        } else {
                            $row = array();
                            $noresult = '<div class="text-center clearfix m-b-20 m-t-10">
                                                        <span class="mini-stat-icon bg-info" style="float: none">
                                                        <i class="ion-information-circled text-white"></i>
                                                    </span>
                                                    </div>
                                                    <h4>' . $user->name . ' didn\'t add events yet!!</h4>';
                            $row[] = array($noresult, array('class' => 'text-center noresult', 'colspan' => 5));
                            $rows[] = $row;
                        }
                        ?>
                        <div class="table-responsive">

                            <table class="tablesaw table tablesaw-swipe">
                                <thead>
                                    <?php echo $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')); ?>
                                </thead>
                                <tbody>
                                    <?= $this->Html->tableCells($rows) ?>
                                </tbody>
                            </table>

                        </div>

                </div>
            </div>
        </div>

    </div>
    <!-- </section> -->


