<?php

$this->Html->addCrumb($modelClass, ['action' => 'index']);

$this->Html->addCrumb($user->name, null);

?>
<div class="row">
    <div class="col-md-4 col-lg-3">
        <div class="profile-detail card-box">
            <div>
                <?php echo $this->Awesome->image('Users/image', $user->image, ['class' => 'img-circle thumb-sm clearfix', 'type' => 'thumbnail']); ?>
                <h4 class="text-uppercase font-600"><?php echo $user->name; ?></h4>
                <h5 class=""><?php echo $user->email; ?></h5>
                <hr>

                <div class="text-left">
                    <p class="text-muted font-13"><strong>Age :</strong> <span class="m-l-15"><?php echo $user->age; ?></span></p>
                    <p class="text-muted font-13"><strong>Gender :</strong> <span class="m-l-15"><?php echo $user->gender; ?></span></p>

                    <p class="text-muted font-13"><strong>Country :</strong> <span class="m-l-15"><?php echo $user->country->name; ?></span></p>
                    <p class="text-muted font-13"><strong>Join Date :</strong> <span class="m-l-15"><?php echo $this->Awesome->date($user->created); ?></span></p>

                </div>


                <div class="button-list m-t-20">
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

                </div>
            </div>

        </div>

    </div>


    <div class="col-lg-9 col-md-8">

        <ul class="nav nav-tabs tabs">
            <li class="active tab"> 
                <a href="#settings" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                    <span class="hidden-xs">Settings</span> 
                </a> 
            </li> 
            <li class="tab">
                <a href="#events" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Events</span> 
                </a> 
            </li> 
            <li class="tab">
                <a href="#tickets" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Purchased Tickets</span> 
                </a> 
            </li> 


        </ul> 

        <div class="tab-content"> 
            <div class="tab-pane active" id="settings"> 
                <?php
                unset($user['password']);
                echo $this->Form->create($user, [
                    'novalidate' => true,
                    'type' => 'file',
                    'class' => 'form-horizontal card-box'
                ]);
                ?>
                <h4>Profile Details</h4>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Name <span>*</span></label>
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
                    <label class="col-lg-4 control-label">Email Address <span>*</span></label>
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
                    <label class="col-lg-4 control-label">Select Country <span>*</span></label>
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
                    <label class="col-lg-4 control-label">DOB <span>*</span></label>
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
                        <label class="col-lg-4 control-label">About </label>
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



                <?php $image = null;
                    if (!empty($user->image)) {
                        $image = '<div class="thumbnail " style="width:200px;">' . $this->Awesome->image('Users/image', $user->image, ['class' => 'img-responsive clearfix']) . '
                                                                                                                                    
                                                                                                                            </div>';
                    } ?>
                    <div class="form-group">
                    <label class="col-lg-4 control-label">Profile Image</label>
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
                    <label class="col-lg-4 control-label">Cover Image</label>
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
                        <label class="col-lg-4 control-label">Facebook Url </label>
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
                        <label class="col-lg-4 control-label">Instagram Url </label>
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
                        <label class="col-lg-4 control-label">Google Plus Url </label>
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
                        <label class="col-lg-4 control-label">Linked In Url </label>
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
                        <label class="col-lg-4 control-label">Youtube Url </label>
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

                    <!-- <div class="form-group">
                        <label class="col-lg-4 control-label">Pinterest Url </label>
                        <?php
                        echo $this->Form->input('pinterest_url', [
                            'label' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ]
                        ]);
                        ?>
                    </div> -->
                    <div class="form-group">
                    <label class="col-lg-4 control-label">Website Url </label>
                        
                        <?php
                        echo $this->Form->input('website_url', [
                            'label' => false,
                            'type' => 'text',
                            'templates' => [
                                'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                            ],
                            'class' => 'form-control']);
                        ?>
                    </div>
                

                <div class="form-group">
                    <label class="col-lg-4 control-label">Active</label>
                    <div class="col-lg-3 gender">
                        <?php
                        echo $this->Form->select('status', $status, ['empty' => 'Select', 'class' => 'select2']);
                        echo $this->Form->error('status');
                        ?>
                    </div>
                </div>



                <div class="form-group m-b-0">
                    <div class="col-sm-offset-4 col-sm-9 m-t-15">
                        <?php
                        echo $this->Form->button('Update Profile', array('class' => 'btn btn-pink'));

                        echo $this->Html->link('Delete', ['action' => 'delete', $user->id], ['escape' => false, 'class' => 'btn btn-danger m-l-5', 'confirm' => __('Are you sure you want to delete this user ? ')]);

                        if ($user->status) {
                            echo $this->Html->link('Block', ['action' => 'changeStatus', $user->id, $user->status], ['escape' => false, 'class' => 'btn btn-info m-l-5', 'confirm' => __('Are you sure you want to block this user ? ')]);
                        } else {
                            echo $this->Html->link('Unblock', ['action' => 'changeStatus', $user->id, $user->status], ['escape' => false, 'class' => 'btn btn-info m-l-5', 'confirm' => __('Are you sure you want to block this user ? ')]);
                        }
                        ?>
                    </div>
                </div>
                <hr>
                <h4>Change Password</h4>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Password </label>
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
                    <label class="col-lg-4 control-label">Verify Password </label>
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

                <div class="form-group m-b-0">
                    <div class="col-sm-offset-4 col-sm-9 m-t-15">
                        <?php
                        $submitBtn = $this->Form->button('Change Password', array('class' => 'btn btn-pink'));
                        echo $submitBtn;
                        ?>
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            </div>

            <div class="tab-pane active" id="events"> 
                <div class="row">
                    <?php
                    $tableHeaders = array();
                    $tableHeaders[] = '';
                    $tableHeaders[] = array('Event name' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Status' => array('style' => 'style2:70%'));
                    $tableHeaders[] = array('Event Date' => array('style' => 'style2:70%'));
                    $tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));
                    $rows = array();
                    if ($events->count() > 0) {

                        foreach ($events->toArray() as $key => $listOne) {
                            $listOne = $listOne->toArray();

                            $row = array();
                            $label = null;

                            $row[] = $this->Awesome->image('Events/image', $listOne['image'], ['class' => 'img-circle thumb-sm clearfix']);
                            $row[] = $label . $this->Html->link($listOne['title'], ['controller' => 'events', 'action' => 'view', 'slug' => $listOne['slug']]);

                            $row[] = array($this->Awesome->getLabedStatus($listOne['status']), array('class' => 'text-center'));
                            $row[] = $this->element('event_date', ['event' => $listOne]);

                            $links = $this->Html->link(__('<i class="fa fa-eye"></i>'), array('controller' => 'events', 'action' => 'view', 'slug' => $listOne['slug']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));


                            $row[] = array($links, array('class' => 'text-center'));
                            $rows[] = $row;
                        }
                    } else {
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

            <div class="tab-pane active" id="tickets"> 
                <div class="row">
                    <?php
                    $tableHeaders = array();
                    $tableHeaders[] = array('Ticket Id' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Ticket' => array('style' => 'style2:70%'));
                    $tableHeaders[] = array('Event name' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Quantity' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Amount' => array('style2' => 'width:70%'));
                    //$tableHeaders[] = '';
                    $rows = array();
                    $row = array();
                    if ($orders->count() > 0) {

                        foreach ($orders as $key => $order) {
                            $tickets = [];

                            foreach ($order->tickets as $key => $ticket) {
                                $tickets[]  = $ticket->name .' - '.$ticket->type;
                            }
                            $row = array();
                            $row[] = $order->id;
                            $row[] = implode(' / ', $tickets);
                            $row[] = $this->Html->link($order->event->title, ['controller' => 'events', 'action' => 'view', 'slug' => $order->event->slug]);
                            $row[] = $order->quantity;
                            $row[] = ($order->amount) ? $order->amount : 'Free';
                            $links = $this->Html->link(__('<i class="fa fa-eye"></i>'), array('controller' => 'events', 'action' => 'view', 'slug' => $order['slug']), array('class' => 'btn btn-xs green tooltips', 'data-placement' => "top", 'data-original-title' => "Delete", 'title' => 'Edit', 'escape' => false));


                            //$row[] = array($links, array('class' => 'text-center'));
                            $rows[] = $row;
                        }
                    } else {
                        $noresult = '<div class="text-center clearfix m-b-20 m-t-10">
                                                    <span class="mini-stat-icon bg-warning" style="float: none">
                                                    <i class="ion-social-usd text-white"></i>
                                                </span>
                                                </div>
                                                <h4>' . $user->name . ' didn\'t booked tickets yet!!</h4>';
                        $row[] = array($noresult, array('class' => 'text-center noresult', 'colspan' => 6));
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

</div>
