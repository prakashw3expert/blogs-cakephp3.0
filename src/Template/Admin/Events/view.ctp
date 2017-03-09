<script>
    var eventData = <?php echo json_encode($event); ?>;
</script>
<?php $this->Html->addCrumb($modelClass, ['controller' => 'events', 'action' => 'index']); ?>
<?php $this->Html->addCrumb($event->title, null); ?>
<div class="row">
    <div class="col-md-4 col-lg-3">
        <div class="profile-detail card-box">
            <div>
                <?php
                $image = $this->Awesome->image('Events/image', $event['image'], ['tag' => false]);
                echo $this->Awesome->image('Events/image', $event['image'], ['class' => 'img-circle thumb-md clearfix', 'title' => 'click to view full image', 'thumb' => 'thumbnail']);
                ?>
                <h4 class="text-uppercase font-600"><?php echo $event->title; ?></h4>
                <ul class="list-inline status-list m-t-20">
                    <li>
                        <?= $this->cell('Event::ticketsCount', ['event_id' => $event->id], ['cache1' => true]) ?>
                    </li>

                    <li>
                        <h3 class="text-success m-b-5"><?= $this->cell('Event::bookingsCount', ['event_id' => $event->id], ['cache1' => true]) ?></h3>
                        <p class="text-muted">Bookings</p>

                    </li>
                </ul>


                <hr>

                <div class="text-left">
                   <!--  <p class="text-muted font-13"><strong>Date :</strong> <span class="m-l-15"><?php echo $this->element('event_date', ['event' => $event]); ?></span></p> -->

                    <p class="text-muted font-13"><strong>Venue :</strong> <span class="m-l-15"><?php echo $event['venue']; ?></span></p>
                    <p class="text-muted font-13"><strong>Address :</strong> <span class="m-l-15"><?php echo $event['address'] . ' ' . $event['address2']; ?></span></p>
                    <p class="text-muted font-13"><strong>City :</strong> <span class="m-l-15"><?php echo $event['city']; ?></span></p>
                    <p class="text-muted font-13"><strong>State :</strong> <span class="m-l-15"><?php echo $event['state']; ?></span></p>
                    <p class="text-muted font-13"><strong>Country :</strong> <span class="m-l-15"><?php echo $event['country']['name']; ?></span></p>
                    <p class="text-muted font-13"><strong>Organizer :</strong> <span class="m-l-15"><?php echo $event['organizer']; ?></span></p>


                    <p class="text-muted font-13"><strong>Post Date :</strong> <span class="m-l-15"><?php echo $this->Awesome->date($event->created); ?></span></p>

                </div>


                <div class="button-list m-t-20">
                    <?php if ($event->facebook_url) { ?>
                        <button type="button" class="btn btn-facebook waves-effect waves-light">
                            <i class="fa fa-facebook"></i>
                        </button>
                    <?php } ?>
                    <?php if ($event->twitter_url) { ?>
                        <button type="button" class="btn btn-twitter waves-effect waves-light">
                            <i class="fa fa-twitter"></i>
                        </button>
                    <?php } ?>
                    <?php if ($event->google_url) { ?>
                        <button type="button" class="btn btn-googleplus waves-effect waves-light">
                            <i class="fa fa-google-plus"></i>
                        </button>
                    <?php } ?>
                    <?php if ($event->youtube_url) { ?>
                        <button type="button" class="btn btn-googleplus waves-effect waves-light">
                            <i class="fa fa-youtube"></i>
                        </button>
                    <?php } ?>

                </div>
            </div>

        </div>

        <div class="card-box p-b-0">
            <h>Posted By</h>
            <a href="javascript:;" class="center-block text-center text-dark">
                <?= $this->Awesome->image('Users/image', $event['user']['image'], ['class' => 'thumb-lg img-thumbnail img-circle', 'type' => 'thumbnail']); ?>
            </a>
            <div class="bg-custom pull-in-card p-20 widget-box-two m-b-0 m-t-30 list-inline text-center row">
                <div class="col-xs-12">
                    <h4 class="text-white m-0 font-600"><?= $event['user']['name'] ?></h4>
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
                <a href="#tickets" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Tickets</span> 
                </a> 
            </li> 

            <li class="tab">
                <a href="#orders" data-toggle="tab" aria-expanded="false"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Bookings</span> 
                </a> 
            </li> 
            <li class="tab">
                <a href="#gallery" data-toggle="tab" aria-expanded="false" id="gallerytab"> 
                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                    <span class="hidden-xs">Gallery</span> 
                </a> 
            </li> 

        </ul> 

        <div class="tab-content"> 
            <div class="tab-pane active" id="settings"> 
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Event Details</b></h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-20">
                                        <?php echo $this->element('event_add'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane active" id="tickets"> 
                <div class="row" ng-controller="eventTicketsController">

                    <div id="panel-modal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog"> 

                            <div class="panel panel-color panel-primary">
                                <div class="panel-heading"> 
                                    <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button> 
                                    <h3 class="panel-title">{{TicketTitle}}</h3> 
                                </div> 
                                <div class="panel-body"> 

                                    <?php
                                    echo $this->Form->create($event, [
                                        'novalidate' => true,
                                        'name' => 'ticketForm',
                                        'class' => 'createTicketForm',
                                        'ng-submit' => 'saveTicket($event, ticketForm.$valid)',
                                    ]);
                                    ?>
                                    <div class="row"> 
                                        <div class="col-md-8"> 
                                            <div class="form-group"> 
                                                <label for="field-1" class="control-label">Ticket Name</label>
                                                <?php
                                                echo $this->Form->input('name', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Early Bird,RSVP...',
                                                    'ng-model' => 'EventTickets.name'
                                                ]);
                                                ?>
                                            </div>
                                            <div class="error">{{EventTickets.name.$error}}</div> 
                                        </div> 
                                        <div class="col-md-4"> 
                                            <div class="form-group"> 
                                                <label for="field-2" class="control-label">Quantity available</label> 
                                                <?php
                                                echo $this->Form->input('quantity', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => '100',
                                                    'ng-model' => 'EventTickets.quantity'
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 
                                    </div> 

                                    <div class="row"> 
                                        <div class="col-md-4"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">Ticket Type</label> 
                                                <?php
                                                echo $this->Form->input('type', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => '100',
                                                    'ng-model' => 'EventTickets.type', //, 'Paid' => 'Paid', 'Donation' => 'Donation'
                                                    'options' => array('Free' => 'Free')
                                                ]);
                                                ?>

                                            </div> 
                                        </div> 

                                        <div class="col-md-4" ng-if="EventTickets.type != 'Free'"> 
                                            <div class="form-group"> 
                                                <label for="field-5" class="control-label">Price</label> 
                                                <?php
                                                echo $this->Form->input('price', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => '200',
                                                    'ng-model' => 'EventTickets.price',
                                                ]);
                                                ?>

                                                
                                            </div> 
                                        </div> 
                                        <?php
                                        echo $this->Form->input('id', [
                                            'ng-model' => 'EventTickets.id',
                                        ]);
                                        ?>
                                        <div class="col-md-4"> 
                                            <div class="form-group"> 
                                                <label for="field-6" class="control-label">Sales channel</label> 
                                                <?php
                                                echo $this->Form->input('sale_chanel', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => '100',
                                                    'ng-model' => 'EventTickets.sale_chanel',
                                                    'options' => array('Everywhere' => 'Everywhere', 'Online' => 'Online Only', 'Door' => 'At the Door Only')
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 
                                    </div> 

                                    <div class="row"> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">Ticket sales start</label> 
                                                <?php
                                                echo $this->Form->input('sale_start_date', [
                                                    'label' => false,
                                                    'type' => 'text',
                                                    'ng-model' => 'EventTickets.sale_start_date',
                                                    'class' => 'datepicker']);
                                                ?>
                                            </div> 
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">&nbsp;</label> 
                                                <?php
                                                echo $this->Form->input('start_time', [
                                                    'label' => false,
                                                    'type' => 'text',
                                                    'ng-model' => 'EventTickets.start_time',
                                                    'autocomplete' => 'off',
                                                    'templates' => [
                                                        'inputContainer' => '<div class="col-lg-12 input-group clockpicker {{type}}{{required}}">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                                        'inputContainerError' => '<div class="col-lg-12 input-group clockpicker {{type}}{{required}} has-error">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                                    ],
                                                    'class' => '']);
                                                ?>
                                            </div> 
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">Ticket sales end</label> 
                                                <?php
                                                echo $this->Form->input('sale_end_date', [
                                                    'label' => false,
                                                    'class' => 'form-control datepicker',
                                                    'ng-model' => 'EventTickets.sale_end_date',
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">&nbsp;</label> 
                                                <?php
                                                echo $this->Form->input('end_time', [
                                                    'label' => false,
                                                    'type' => 'text',
                                                    'ng-model' => 'EventTickets.end_time',
                                                    'autocomplete' => 'off',
                                                    'templates' => [
                                                        'inputContainer' => '<div class="col-lg-12 input-group clockpicker {{type}}{{required}}">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                                        'inputContainerError' => '<div class="col-lg-12 input-group clockpicker {{type}}{{required}} has-error">{{content}}<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>',
                                                    ],
                                                    'class' => '']);
                                                ?>
                                            </div> 
                                        </div> 

                                    </div> 

                                    <div class="row"> 
                                        <label class="col-md-12 control-label">Tickets allowed per order</label> 
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">Minimum</label> 
                                                <?php
                                                echo $this->Form->input('min_order_count', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'ng-model' => 'EventTickets.min_order_count',
                                                    'placeholder' => 1
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <label  class="control-label">Maximum</label> 
                                                <?php
                                                echo $this->Form->input('max_order_count', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'ng-model' => 'EventTickets.max_order_count',
                                                    'placeholder' => 10
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 

                                    </div> 

                                    <div class="row"> 
                                        <div class="col-md-12"> 
                                            <div class="form-group no-margin"> 
                                                <label for="field-7" class="control-label">Ticket description</label> 
                                                <?php
                                                echo $this->Form->input('description', [
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Write something about Ticket',
                                                    'ng-model' => 'EventTickets.description'
                                                ]);
                                                ?>
                                            </div> 
                                        </div> 
                                    </div> 
                                    <div class="modal-footer"> 
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                                        <button class="ladda-button btn btn-primary" data-style="expand-left" type="submit"><span class="ladda-label">
                                                Submit
                                            </span>
                                            <span class="ladda-spinner"></span></button>
                                    </div>
                                    <?php echo $this->Form->end(); ?>
                                </div> 
                            </div>

                        </div>
                    </div>

                    <?php
                    $tableHeaders = array();
                    $tableHeaders[] = array('Ticket ID' => array('style2' => 'width:5%'));
                    $tableHeaders[] = array('Ticket name' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Quantity available' => array('style2' => 'width:70%'));
                    $tableHeaders[] = array('Price' => array('style' => 'style2:70%'));
                    $tableHeaders[] = array('Sales Date' => array('style' => 'style2:70%'));
                    $tableHeaders[] = array('Type' => array('style' => 'style2:70%'));

                    $tableHeaders[] = array('Action' => array('class' => 'action-btn-2 text-center', 'style' => 'style2:10%'));
                    ?>
                    <div class="table-responsive">

                        <table class="tablesaw table tablesaw-swipe table-bordered">
                            <thead>
                                <?php echo $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')); ?>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(key, value) in tickets">
                                    <td>{{value.id}}</td>
                                    <td>{{value.name}}</td>
                                    <td>{{value.quantity}}</td>
                                    <td>{{value.price}}</td>
                                    <td>{{value.sale_start_date}} to <br/> {{value.sale_end_date}}</td>
                                    <td>{{value.type}}</td>
                                    <td>
                                        <a href="#" ng-click="editTicket(value.id)"><i class="fa fa-pencil"></i></a>
                                        <a href="#" ng-click="removeTicket(value.id)" class="pull-right m-r-15"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>

                                <tr ng-show="tickets.length > 0">
                                    <td colspan="8" class="text-left">
                                        <button type="button" class="btn btn-sm btn-default  btn-rounded waves-effect waves-light" ng-click="createTicket();">Create New Ticket</button>
                                    </td>
                                </tr>

                                <tr ng-show="tickets.length <= 0">
                                    <td colspan="8" class="text-center">
                                        <div class="text-center clearfix m-b-10">
                                            <span class="mini-stat-icon bg-info" style="float: none">
                                                <i class="ion-calendar text-white"></i>
                                            </span>
                                        </div>
                                        <p>In auctor lobortis lacus. Praesent congue erat at massa. Quisque id mi. Donec id justo. Nulla neque dolor, sagittis eget, iaculis quis, molestie non, velit.</p>
                                        <button type="button" class="btn btn-sm btn-default btn-rounded waves-effect waves-light" ng-click="createTicket();">Create Ticket</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="tab-pane active" id="orders"> 
                <div class="row">
                    <?php
                    $tableHeaders = array();
                    $tableHeaders[] = array('Ticket Id' => array());
                    $tableHeaders[] = array('Ticket Name' => array());
                    $tableHeaders[] = array('User name' => array());

                    $tableHeaders[] = array('Quantity' => array());
                    $tableHeaders[] = array('Amount' => array());
                    $rows = array();
                    $row = array();
                    if (!empty($orders)) {

                        foreach ($orders as $key => $listOne) {
                            $tickets = [];
                            foreach ($listOne->tickets as $key => $ticket) {
                                $tickets[] = $ticket->name . ' - ' . $ticket->type;
                            }

                            $row = array();
                            $row[] = $listOne->id;
                            $row[] = implode(' / ', $tickets);
                            $row[] = $this->Html->link($listOne->user->name, ['controller' => 'users', 'action' => 'view', 'slug' => $listOne->user->slug]);


                            $row[] = $listOne->quantity;

                            $links = ($listOne->type == 'free') ? 'Free' : $listOne->amount;

                            $row[] = array($links, array('class' => 'text-centers'));
                            $rows[] = $row;
                        }
                    } else {
                        $noresult = '<div class="text-center clearfix m-b-20 m-t-10">
                        <span class="mini-stat-icon bg-warning" style="float: none">
                            <i class="ion-social-usd text-white"></i>
                        </span>
                    </div>
                    <h4> No booking taken yet!!!</h4>';
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
            
            <div class="tab-pane" id="gallery"> 
                <div class="card-box">
                    <div class="row">
                        <?php
                        echo $this->Form->create($event, [
                            'novalidate' => true,
                            'type' => 'file',
                        ]);
                        ?>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <h4 class="m-b-10 header-title text-right"><b>Upload Images </b></h4>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <?php
                            echo $this->Form->file('image[]', [
                                'label' => "",
                                'multiple' => 'multiple',
                                'class' => 'filestyle', 'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
                            echo $this->Form->error('image');
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <?php echo $this->Form->button('Upload', array('class' => 'btn btn-success', 'name' => 'gallery')); ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                    <hr>
                    <?php
                    $tableHeaders = array();
                    $tableHeaders[] = array('Image' => array('style' => 'width:70%'));

                    $tableHeaders[] = array('Remove' => array('class' => 'action-btn-2 text-center', 'style' => 'width:10%'));


                    $rows = array();
                    if (!empty($event['event_images'])) {
                        foreach ($event['event_images'] as $key => $image) {
                            $image = $image->toArray();
                            $imageLink = $this->Awesome->image('EventImages/image', $image['image'], ['tag' => false]);
                            $row = array();
                            $row[] = $this->Html->link($this->Awesome->image('EventImages/image', $image['image'], ['class' => 'thumb-lg clearfix', 'title' => 'click to view full image']), $imageLink, ['class' => 'image-popup', 'escape' => false]);

                            $links = $this->Form->postLink(
                                    '<i class="fa fa-times"></i>', ['action' => 'delete_img', $image['id']], ['escape' => false, 'class' => 'btn btn-md btn-danger delete_btn tooltips', 'confirm' => __('Are you sure you want to delete this ? ')]);


                            $row[] = array($links, array('class' => 'text-center'));
                            $rows[] = $row;
                        }
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="tablesaw table tablesaw-swipe table-bordered">
                            <thead>
                                <?php echo $this->Html->tableHeaders($tableHeaders, array('class' => 'heading'), array('class' => 'sorting')); ?>
                            </thead>

                            <tbody>
                                <?php echo $this->Html->tableCells($rows); ?>
                            </tbody>
                        </table>
                        <?php if ($rows == null) { ?>
                            <div class="btn btn-block btn--md btn-white waves-effect waves-light">
                                <strong>Oops!</strong> No records found.
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            
        </div>
        
    </div>

    <?php
    if ($galleryAction == 'gallery') {
        echo $this->start('jsSection');
        echo '<script type="text/javascript">
        $(document).ready(function(){
            $("#gallerytab").click();
        });
    </script>';
        $this->end();
    }
    ?>




