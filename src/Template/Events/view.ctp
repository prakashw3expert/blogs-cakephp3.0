<?php
$this->assign('title', $event['title']);


$location = array();
$location[] = $event['address'];
if(!empty($event['address2'])){
    $location[] = $event['address2'];    
}
$location[] = $event['city'];
$location[] = $event['state'];
$location[] = $event['country']['name'];
$location[] = $event['pincode'];
$location = implode(',', $location);

$title = (!empty($event['meta_title'])) ? $event['meta_title'] : $event['title'];
$title = (!empty($event['meta_keyword'])) ? $event['meta_keyword'] : $event['tags'];
$description = $event['meta_description'];

$author = $event['user']['name'];

$socialImage = $this->Awesome->image('Blogs/image', $event['image'], ['class' => 'img-responsive', 'type' => 'large', 'tag' => false]);

if (!$description) {
    $description = $this->Text->truncate(strip_tags($event['description']), 150, ['exact' => false]);
}

$link = $this->Url->build(['controller' => 'events', 'action' => 'view', 'slug' => $event['slug']], ['base' => false]);

$meta = null;
$meta .= $this->Html->meta('description', $description);

// Twitter card
$meta .= $this->Html->meta('twitter:card', Cake\Core\Configure::read('Twitter.card'));
$meta .= $this->Html->meta('twitter:site', Cake\Core\Configure::read('Twitter.site'));
$meta .= $this->Html->meta('twitter:title', $title);
$meta .= $this->Html->meta('twitter:description', $description);
$meta .= $this->Html->meta('twitter:creator', $author);
$meta .= $this->Html->meta('twitter:image', $socialImage);


// Open Graph

$meta .= $this->Html->meta('og:title', $title);
$meta .= $this->Html->meta('og:type', Cake\Core\Configure::read('Seo.og.type'));
$meta .= $this->Html->meta('og:url', $link);
$meta .= $this->Html->meta('og:image', $socialImage);
$meta .= $this->Html->meta('og:description', $description);
$meta .= $this->Html->meta('og:site_name', Cake\Core\Configure::read('Site.name'));
$meta .= $this->Html->meta('fb:admins', Cake\Core\Configure::read('Facebook.admins'));


$this->assign('meta', $meta);

  $isImage = ($event['image'] && file_exists('files/Events/image/'. $event['image'])) ? true : false;

?>
<!-- HEADER -->  
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="entry-title"><?php echo $event['title']; ?></h2>
        <?php 
    echo $this->Html->link('Post Your Event',['controller' => 'events','action' => 'add'],['class' => 'btn btn-primary pull-right']);
    ?>
    </div>

    
                        

</section>

<?= $this->cell('Event::viewEvent', ['event_id' => $event->id,'user_id' => $loggedInAs['id']], ['cache1' => true]) ?>

<div class="container newsection">
<?php
             $this->Html->getCrumbList(
            [
            'lastClass' => 'active',
            'class' => 'list-inline',
            ], ['text' => 'Home',
            'url' => ['controller' => 'pages', 'action' => 'display','home'],]
            );
        ?>
    <div class="row">
     <?= $this->Flash->render() ?>
     <div class="col-md-3" role="complementary">
        <div id="aside" class="sidebar style1 m-t-10" style="padding-top:20px;">
            <div class="venue widget">
                <div class="pix-map">
                    <div class="map_api" id="map_show" style="width:98%; height:300px"></div>

                </div>
                <?php $this->start('jsSection'); ?>
                <script type="text/javascript">
                    jQuery(function ($) {
                        $(window).bind('gMapsLoaded', initialize);
                        loadGoogleMaps();
                        var address = "<?php echo $location; ?>";

                        window.gMapsCallback = function () {
                            $(window).trigger('gMapsLoaded');
                        }

                        function initialize() {

                            geocoder = new google.maps.Geocoder();

                            var mapOptions = {
                                zoom: 10,
                                center: new google.maps.LatLng(<?php echo ($event['lat']) ? $event['lat'] : 0; ?>, <?php echo ($event['lng']) ? $event['lng'] : 0; ?>),
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };

                            map = new google.maps.Map(document.getElementById('map_show'), mapOptions);

                            var infowindow = new google.maps.InfoWindow(
                                {content: '<b>' + address + '</b>',
                                size: new google.maps.Size(150, 50)
                            });

                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(<?php echo ($event['lat']) ? $event['lat'] : 0; ?>, <?php echo ($event['lng']) ? $event['lng'] : 0; ?>),
                                map: map,
                                title: address
                            });
                            google.maps.event.addListener(marker, 'click', function () {
                                infowindow.open(map, marker);
                            });




                        }


                        function loadGoogleMaps() {
                            var script_tag = document.createElement('script');
                            script_tag.setAttribute("type", "text/javascript");
                            script_tag.setAttribute("src", "https://maps.google.com/maps/api/js?key=AIzaSyCfmBVfi_cIk55CJ481sek_LQaYvV4Ju-4&sensor=false&callback=gMapsCallback");
                            (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
                        }

                    });
                </script>
                <?php $this->end(); ?>
            </div>

            <div class="organizer widget m-b-20">
                <h3 class="">Organizer</h3>
                <h4 class=""><?php echo $event->organizer; ?></h4>

                <p><?php echo $event->organizer_details; ?></p>
                <?php if($event->user) { ?>
                    <a href="mailTo:<?php echo $event->user->email;?>" class="btn btn-black contact-button"><i class="button-icon fa fa-envelope-o"></i>Contact <?php 

                    echo $event->user->name;
                    ?>
                    </a>
                <?php } ?>
                    <?php if(!empty($event->facebook_url)
                        || $event->facebook_url
                        || $event->instagram_url
                        || $event->twitter_url
                        || $event->google_plus_url
                        || $event->linkedIn_url
                        || $event->youtube_url
                        || $event->pinterest_url

                        ){
                        echo '<h2>Found Us</h2>';
                    }
                    ?>
                    <ul class="social-icon">
                        <?php if($event->facebook_url) { ?>
                        <li class="facebook">
                            <a href="<?php echo $this->Awesome->addhttp($event->facebook_url);?>"><i class="icon fa fa-facebook"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->facebook_url);?></div>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($event->instagram_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->instagram_url);?>"><i class="icon fa fa-instagram"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->instagram_url);?></div>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($event->twitter_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->user->twitter_url);?>"><i class="icon fa fa-twitter"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->twitter_url);?></div>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($event->google_plus_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->user->google_plus_url);?>"><i class="icon fa fa-google"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->google_plus_url);?></div>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($event->linkedIn_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->user->linkedIn_url);?>"><i class="icon fa fa-linkedin"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->linkedIn_url);?></div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($event->youtube_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->user->youtube_url);?>"><i class="icon fa fa-youtube"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->youtube_url);?></div>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if($event->pinterest_url) { ?>
                        <li class="twitter">
                            <a href="<?php echo $this->Awesome->addhttp($event->user->pinterest_url);?>"><i class="icon fa fa-pinterest"></i>
                                <div class="content"><?php echo $this->Awesome->removeHttp($event->pinterest_url);?></div>
                            </a>
                        </li>
                        <?php } ?>


                    </ul>

                </div>

            </div>
        </div>            <!-- col-md-9 -->
        <div class="col-md-9">

            <div class="event-info">
                <div class="post" style="margin-top:0px;">
                    <?php if($isImage){?>
                        <div class="entry-header">
                            <?php echo $this->Awesome->image('Events/image', $event['image'], ['style' => 'width:100%', 'type' => 'large']); ?>
                        </div>
                    <?php } ?>
                    <div class="post-content">
                        <section class="event-detail newsection">
                            <h2 class="main-title"><?php echo $event['title']; ?></h2>
                            <ul class="meta clearfix">

                                <li class="date"><i class="icon fa fa-calendar"></i> 
                                    <?php echo $this->element('event_date', ['event' => $event]); ?>
                                </li>
                                <li class="date"><i class="icon fa fa-clock-o"></i> 
                                    <?php echo $this->element('event_time', ['event' => $event]); ?>
                                </li>
                                <!-- <li><i class="icon fa fa-home"></i> <?php echo $this->Html->link($event['venue'], ['controller' => 'events', 'action' => 'search', 'venue' => $event['venue']]); ?></li> -->
                                <li><i class="icon fa fa-map-marker"></i> <?php echo $this->Html->link($location, ['controller' => 'events', 'action' => 'search', 'city' => $event['city'],'state' => $event['state']]); ?></li>
                                <li><i class="icon fa fa-user"></i><span class="text"><?php echo $this->Html->link($event['organizer'], ['controller' => 'events', 'action' => 'search', 'organizer' => $event['organizer']]); ?></span></li>
                            </ul>

                            <?php foreach ($event['event_tickets'] as $ticket) { 
                                if($ticket->booked < $ticket->quantity) {
                                    echo '<a href="#myModal" class="btn btn-primary"  data-toggle="modal" data-target="">Register</a>';
                                    break;
                                } 
                            } 
                            ?>

                            <?php if(!empty($event['event_tickets'])) { ?>
                            
                            <?php } ?>
                            <div class="sep event-detail-sep"></div>
                            <h3 class="entry-title">Whats About</h3><p><?php echo $event['description']; ?></p>
                            <h4>Share this Event</h4>
                            <?php
                            echo $this->element('share', array(
                                'url' => $link,
                                'title' => $event['title'],
                                'description' => $event['title'],
                                'image' => '',
                                )
                            );
                            ?>
                        </section>
                        <section class="speakers-tabs newsection show">


                        </section> 
                        <?php if (!empty($event['event_images'])) { ?>
                        <section class="event-gallery newsection clearfix">
                            <h2 class="entry-title">Gallery of Event</h2>
                            <div class="owl-team">
                                <?php
                                foreach ($event['event_images'] as $key => $image) {
                                    ?>
                                    <div class="event-gallery-content">
                                        <div class="gallery-event-img">
                                            <?php
                                             $imageLink = $this->Awesome->image('EventImages/image', $image['image'], ['tag' => false]);

                                            echo $this->Html->link($this->Awesome->image('EventImages/image', $image['image'], []),$imageLink,['escape' => false,'class' => 'image-popup']); ?>
                                        </div>
                                            <!--                                            <div class="content">
                                                                                            <h3 class="entry-title">Ethical Vortals</h3><p>Meeting</p>
                                                                                        </div>-->
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </section>
                                                                            <?php } ?>
                                                                            <div class="comments-wrapper">
                                                                                <h1 class="section-title title">Comments</h1>
                                                                                <div id="fb-root"></div>
                                                                                <script>(function (d, s, id) {
                                                                                    var js, fjs = d.getElementsByTagName(s)[0];
                                                                                    if (d.getElementById(id))
                                                                                        return;
                                                                                    js = d.createElement(s);
                                                                                    js.id = id;
                                                                                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=194605903956837";
                                                                                    fjs.parentNode.insertBefore(js, fjs);
                                                                                }(document, 'script', 'facebook-jssdk'));</script>


                                                                                <div class="comments-box">
                                                                                    <form id="comment-form" name="comment-form" method="post">
                                                                                        <div class="fb-comments" data-href="<?php echo $link; ?>" data-numposts="5"></div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>



                                                    </div><!--/#main-wrapper--> 


                                                    <style>
                                                        .table tr td.infoText{
                                                            border-bottom: 15px solid #fff !important;
                                                        }
                                                        .table{
                                                            margin-bottom: -15px;
                                                        }
                                                        .ticket-quantity{
                                                            margin-top: 25px !important;
                                                        }
                                                    </style>
                                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="eventTicketBookConttroller">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">Select Tickets</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert " ng-show="message" ng-class="{'alert-success' : status, 'alert-danger' : !status}">
                                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                        {{message}}
                                                                    </div>

                                                                    <table class="table"> 
                                                                        <?php foreach ($event['event_tickets'] as $ticket) { 
                                                                            if($ticket->booked < $ticket->quantity) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td  class="active no-border-bottom">
                                                                                        <?php echo $sales = ' Sales End : ' . $this->Awesome->date($ticket->sale_end_date) . ' ' . $this->Awesome->date($ticket->end_time, 'h:i A'); ?>
                                                                                        <h4><?php echo $ticket->name; ?></h4>
                                                                                        <?php
                                                                                        if ($ticket->type == 'Paid') {
                                                                                            echo '<small class="clearfix"><i class="fa fa-inr"></i> ' . $ticket->price . '</small>';
                                                                                        } else {
                                                                                            echo '<small class="clearfix">' . $ticket->type . '</small>';
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td  class="active no-border-bottom">
                                                                                        <?php
                                                                                        $quantity = array();
                                                                                        $minQuantity = $ticket->min_order_count;
                                                                                        $maxQuantity = $ticket->max_order_count;

                                                                                        $remaining = $ticket->quantity - $ticket->booked;

                                                                                        $maxQuantity = ($remaining < $maxQuantity) ? $remaining : $maxQuantity;

                                                                                        for ($start = $minQuantity; $start <= $maxQuantity; $start++) {
                                                                                            $quantity[$start] = $start;
                                                                                        }
                                                                                        echo $this->Form->select('quantity', $quantity, ['empty' => 'QTY', 'class' => 'ticket-quantity', 'data-ticketId' => $ticket->id, 'data-amount' => $ticket->price]);
                                                                                        ?>

                                                                                    </td>
                                                                                </tr>
                                                                                <?php if($ticket->description) { ?>
                                                                                    <tr>
                                                                                        <td colspan="2" class="active infoText" ><p class="small">Tickets Info : <?php echo $ticket->description; ?></p></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            <?php } 
                                                                        } ?>


                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="row">

                                                                        <div class="col-md-4 text-left" ng-show="ticketCount">QTY : {{ticketCount}}</div>
                                                                        <div class="col-md-4 text-left" ng-show="ticketAmount"><i class="fa fa-inr"></i> {{ticketAmount}}</div>
                                                                        <div class="col-md-4 pull-right"><button type="button" class="btn btn-primary" ng-disabled="!ticketCount || processForm" ng-click="bookTicket()">Continue</button></div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
