<?php
$this->Html->addCrumb($title, ['action' => 'myEvents']);
if ($event->id) {
    $this->Html->addCrumb('Edit Event', null);
} else {
    $this->Html->addCrumb('Add Event', null);
}
?>
<div class="row" ng-controller="eventsController">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Event Details</b></h4>

            <div class="row">
                <div class="col-lg-9">

                    <div class="p-20">
                        <?php
                        echo $this->Form->create($event, [
                            'novalidate' => true,
                            'type' => 'file',
                            'class' => 'form-horizontal google_map1'
                        ]);
                        ?>
                        <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCfmBVfi_cIk55CJ481sek_LQaYvV4Ju-4&libraries=places&"></script>-->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Even Title <span>*</span></label>
                            <?php
                            echo $this->Form->input('title', [
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}</div>',
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="form-group">


                            <label class="col-lg-4 control-label">Start <span>*</span></label>
                            <?php
                            echo $this->Form->input('start_date', [
                                'label' => false,
                                'type' => 'text',
                                'autocomplete' => 'off',
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}</div>',
                                ],
                                'class' => 'datepicker']);
                            ?>
                            <?php
                            echo $this->Form->input('start_time', [
                                'label' => false,
                                'type' => 'text',
                                'autocomplete' => 'off',
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-2 input-group clockpicker {{type}}{{required}}">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                    'inputContainerError' => '<div class="col-lg-2 col-lg-2 input-group clockpicker {{type}}{{required}} has-error">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                ],
                                'class' => '']);
                            ?>

                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">Ends <span>*</span></label>
                            <?php
                            echo $this->Form->input('end_date', [
                                'label' => false,
                                'type' => 'text',
                                'autocomplete' => 'off',
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-3 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-3 input {{type}}{{required}} has-error">{{content}}</div>',
                                ],
                                'class' => 'datepicker']);
                            ?>
                            <?php
                            echo $this->Form->input('end_time', [
                                'label' => false,
                                'type' => 'text',
                                'autocomplete' => 'off',
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-2 input-group clockpicker {{type}}{{required}}">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                    'inputContainerError' => '<div class="col-lg-2 input-group clockpicker {{type}}{{required}} has-error">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                ],
                                'class' => '']);
                            ?>

                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">Location <span>*</span></label>
                            <div class="col-lg-6">
                                <?php
                                echo $this->Form->input('venue', [
                                    'label' => false, 'type' => 'text',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'Enter the venue\'s name'
                                ]);
                                echo $this->Form->input('address', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'address',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'Address'
                                ]);
                                echo $this->Form->input('address2', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'address',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'Address2'
                                ]);
                                echo $this->Form->input('city', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'address',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'City']
                                );
                                echo $this->Form->input('state', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'address',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'State']);
                                echo $this->Form->input('pincode', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'address',
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'placeholder' => 'Zip / Postal Code'
                                ]);
                                echo $this->Form->input('country_id', [
                                    'label' => false,
                                    'templates' => [
                                        'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                                        'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}</div>',
                                    ],
                                    'empty' => 'Select Country',
                                    'class' => 'form-control select2'
                                        ]
                                );
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Event Image</label>
                            <?php
                            $image = "";
                            '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image($modelClass . '/image', $event['image'], ['class' => 'img-responsive clearfix']) . '
                                                                                                                
                                                                                                        </div>';
                            echo $this->Form->input('image', [
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-5 mt10 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}</div>',
                                    'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                                'label' => false,
                                'class' => 'filestyle', 'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Event Details <span>*</span></label>
                            <?php
                            echo $this->Form->input('description', [
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 mt10 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} error">{{content}}</div>',
                                ],
                                'label' => false,
                                'id' => 'editor2', 'style' => 'height:300px;']);
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Even Organizer <span>*</span></label>
                            <?php
                            echo $this->Form->input('organizer', [
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}</div>',
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Even Organizer Detail <span>*</span></label>
                            <?php
                            echo $this->Form->input('organizer_details', [
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}</div>',
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-offset-4 col-sm-9 m-t-15">
                                <?php
                                $submitBtn = $this->Form->button('Publish Event', array('class' => 'btn btn-success'));
                                $caneclBtn = $this->Html->link('Cancel', array('action' => 'myEvents'), array('class' => 'btn btn-default m-l-5'));
                                echo $submitBtn;
                                echo $caneclBtn;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

