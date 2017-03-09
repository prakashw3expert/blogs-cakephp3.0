<?php
echo $this->Form->create($event, [
    'novalidate' => true,
    'type' => 'file',
    'class' => 'form-horizontal google_map1'
]);
?>
<div class="form-group">
    <label class="col-lg-2 control-label">Event Title <span>*</span></label>
    <?php
    echo $this->Form->input('title', [
        'label' => false,
        'templates' => [
            'inputContainer' => '<div class="col-lg-10 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-10 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ]
    ]);
    ?>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Start <span>*</span></label>
    <?php
    echo $this->Form->input('start_date', [
        'label' => false,
        'type' => 'text',
        'placeholder' => 'Start Date',
        'autocomplete' => 'off',
        'templates' => [
            'inputContainer' => '<div class="col-lg-2 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-2 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'datepicker']);
    ?>
    <?php
    echo $this->Form->input('start_time', [
        'label' => false,
        'type' => 'text',
        'placeholder' => 'Start Time',
        'autocomplete' => 'off',
        'templates' => [
            'inputContainer' => '<div class="col-lg-2  clockpicker {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-2 col-lg-2 clockpicker {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => '']);
    ?>


    <label class="col-lg-2 control-label">Ends <span>*</span></label>
    <?php
    echo $this->Form->input('end_date', [
        'label' => false,
        'type' => 'text',
        'placeholder' => 'End Date',
        'autocomplete' => 'off',
        'templates' => [
            'inputContainer' => '<div class="col-lg-2 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-2 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'datepicker']);
    ?>
    <?php
    echo $this->Form->input('end_time', [
        'label' => false,
        'type' => 'text',
        'placeholder' => 'End Time',
        'autocomplete' => 'off',
        'templates' => [
            'inputContainer' => '<div class="col-lg-2 clockpicker {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-2 clockpicker {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => '']);
    ?>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">Location <span>*</span></label>
    <div class="col-lg-10">
        <?php
        echo $this->Form->input('venue', [
            'label' => false, 'type' => 'text',
            'templates' => [
                'inputContainer' => '<div class="mt10 {{type}}{{required}}">{{content}}</div>',
                'inputContainerError' => '<div class="mt10 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
            ],
            'placeholder' => 'Enter the venue\'s name'
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label"> <span></span></label>
    <?php
    echo $this->Form->input('address', [
        'label' => false,
        'type' => 'text',
        'class' => 'address',
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'placeholder' => 'Address'
    ]);
    ?>
    <?php
    echo $this->Form->input('address2', [
        'label' => false,
        'type' => 'text',
        'class' => 'address',
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'placeholder' => 'Address2'
    ]);
    ?>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label"> <span></span></label>
    <?php
    echo $this->Form->input('city', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'placeholder' => 'City'
    ]);
    ?>
    <?php
    echo $this->Form->input('state', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'placeholder' => 'State'
    ]);
    ?>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label"> <span></span></label>
    <?php
    echo $this->Form->input('pincode', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'placeholder' => 'Zip / Postal Code'
    ]);
    ?>
    <?php
    echo $this->Form->input('country_id', [
        'label' => false,
        'templates' => [
            'inputContainer' => '<div class="col-lg-5 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-5 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'empty' => 'Select Country',
        'class' => 'form-control select2'
            ]
    );
    ?>
</div>




<div class="form-group">
    <label class="col-lg-2 control-label">Event Image</label>
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
    <label class="col-lg-2 control-label">Event Details <span>*</span></label>
    <?php
    echo $this->Form->input('description', [
        'templates' => [
            'inputContainer' => '<div class="col-lg-10 mt10 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-10 input {{type}}{{required}} has-error" id="description">{{content}}{{error}}</div>',
        ],
        'label' => false,
        'id' => 'summernotePJ']);
    ?>
</div>
 <div class="form-group">
    <label class="col-lg-2 control-label">Facebook URL </label>
    <?php
    echo $this->Form->input('facebook_url', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'form-control']);
    ?>
    <label class="col-lg-2 control-label">Instagram Url </label>
    <?php
    echo $this->Form->input('instagram_url', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'form-control']);
    ?>

</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Google+ URL </label>
    <?php
    echo $this->Form->input('google_plus_url', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'form-control']);
    ?>
    <label class="col-lg-2 control-label">Twitter Url </label>
    <?php
    echo $this->Form->input('twitter_url', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'form-control']);
    ?>

</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Youtube URL </label>
    <?php
    echo $this->Form->input('youtube_url', [
        'label' => false,
        'type' => 'text',
        'templates' => [
            'inputContainer' => '<div class="col-lg-4 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-4 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ],
        'class' => 'form-control']);
    ?>

</div>
<hr>
<h4 class="">Event Organizer</h4>
<div class="form-group">
    <label class="col-lg-2 control-label">Name <span>*</span></label>
    <?php
    echo $this->Form->input('organizer', [
        'label' => false,
        'templates' => [
            'inputContainer' => '<div class="col-lg-10 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-10 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ]
    ]);
    ?>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Detail <span>*</span></label>
    <?php
    echo $this->Form->input('organizer_details', [
        'label' => false,
        'templates' => [
            'inputContainer' => '<div class="col-lg-10 {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="col-lg-10 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        ]
    ]);
    ?>
</div>
<div class="form-group m-b-0">
    <div class="col-sm-offset-2 col-sm-10 m-t-15">
        <?php
        $submitBtn = $this->Form->button('Submit', array('class' => 'btn btn-success event-post', 'name' => 'update'));
        $caneclBtn = $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn btn-default m-l-5'));
        echo $submitBtn;
        echo $caneclBtn;
        ?>
    </div>
</div>

<?php echo $this->Form->end(); ?>