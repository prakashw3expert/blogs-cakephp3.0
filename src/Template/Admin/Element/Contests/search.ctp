<div class="wpb_row pix-row vc_row-fluid light normal" style="background-color:#735cb0 !important;margin-top: -20px">
    <div class="bg-pos-rel">
        <div class="pix-con clearfix">
            <div class="pix-container">
                <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                        <section class="eventform newsection">
                            <div class="event-title">
                                <h2 class="entry-title" style="color:#fff;">Find what you want</h2>
                            </div>

                            <div class="eventform-con">
                                <?php
                                echo $this->Form->create($modelClass, [
                                    'novalidate' => true,
                                    'url' => ['action' => 'search'],
                                    'type' => 'get'
                                ]);

                                echo $this->Form->input('keyword', [
                                    'label' => false,
                                    'placeholder' => 'Search Keyword',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-input search-location">{{content}}<i class="icon fa fa-search"></i></div>',
                                    ]
                                ]);

                                echo $this->Form->input('date', [
                                    'label' => false,
                                    'placeholder' => 'mm/dd/yy',
                                    'class' => 'date_timepicker_start',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-input">{{content}} <i class="open icon fa fa-calendar"></i></div>',
                                    ]
                                ]);
                                ?>


                                <div class="form-input">
                                    <div class="styled-select">
                                        <?php
                                        echo $this->Form->input('city', [
                                            'label' => false,
                                            'empty' => 'Select Location',
                                            'options' => $cities,
                                            'templates' => [
                                                'inputContainer' => '{{content}}',
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>

                                <button  type="submit" class="btn btn-primary btn-md btn-pri">find event</button>

                                <?php echo $this->Form->end(); ?>
                            </div>


                        </section>
                    </div> 
                </div> 

            </div>
        </div>
    </div>
</div>

<div class="wpb_row pix-row vc_row-fluid dark normal">
    <div class="bg-pos-rel">
        <div class="pix-con clearfix">
            <div class="pix-container">
                <?= $this->element('events', ['events' => $events]); ?>
            </div> 
        </div>
    </div>
</div>

