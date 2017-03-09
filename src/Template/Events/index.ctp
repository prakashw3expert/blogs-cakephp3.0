<style type="text/css" data-type="vc_shortcodes-custom-css">.event_intro_beck{padding-top: 70px !important;padding-bottom: 70px !important;background-image: url(http://localhost/themes/event/innwithemes.com/eventonwp/wp-content/uploads/2014/12/light-1e5ba.jpg?id=450) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;margin-top: -20px;}.vc_custom_1423310322620{padding-top: 0px !important;padding-bottom: 0px !important;}</style>		
<div class="wpb_row pix-row vc_row-fluid event_intro_beck light normal">
    <div class="bg-pos-rel">
        <div class="pix-con clearfix">
            <div class="pix-container">
                <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                        <h2 class="main-title title sub-title-con   size-lg alignCenter" style="font-weight: 300; ">Get Ready for The Next Event. Its Beginning!</h2><p class="sub-title " >Authoritatively repurpose cross-media technologies rather than front-end communities. Efficiently implement professional schema after diverse results.</p>
                        
                        <div class="login-options text-center">
                            <?php 
                            echo $this->Html->link('Post Your Event',['controller' => 'events','action' => 'add'],['class' => 'btn btn-primary']);
                            ?>
                        </div>

                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="wpb_row pix-row vc_row-fluid vc_custom_1423310322620 light normal" style="background-color:#735cb0 !important;">
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
                        <div class="vc_col-sm-12 wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="tabs event-tab upcoming-popular-tab">

                                    <ul class="clearfix">
                                        <li><a href="#all_events">All Events</a></li>
                                        <li><a href="#today_events">Today Events</a></li>
                                        <li><a href="#upcoming_events">Upcoming Events</a></li>
                                    </ul>

                                    <div id="all_events">
                                        <div class="event-container">
                                            <div class="row">
                                                <?= $this->cell('Event::all', [], ['cache1' => true]) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="today_events">
                                        <div class="event-container">
                                            <div class="row">
                                                <?= $this->cell('Event::today', [], ['cache1' => true]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="upcoming_events">
                                        <div class="event-container">
                                            <div class="row">
                                                <?= $this->cell('Event::upcoming', [], ['cache1' => true]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo $this->Html->link('View All Event',['controller' => 'events','action' => 'search'],['class' => 'clear btn btn-border btn-md btn-color']);?>

                                </div>

                            </div> 
                        </div> 

                    </div></div></div></div>
