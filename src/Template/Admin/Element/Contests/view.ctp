<?php
$this->assign('title', $event['title']);

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
?>
<!-- HEADER -->  
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="entry-title"><?php echo $event['title']; ?></h2>
    </div>

</section>


<div class="container newsection">
    <div class="row">

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
                            var address = "<?php echo $event['address'] . ' ' . $event['address2'] . ', ' . $event['city'] . ', ' . $event['state'] . ', ' . $event['country']['name'] . ' - ' . $event['pincode']; ?>";

                            window.gMapsCallback = function () {
                                $(window).trigger('gMapsLoaded');
                            }

                            function initialize() {

                                geocoder = new google.maps.Geocoder();

                                var mapOptions = {
                                    zoom: 15,
                                    center: new google.maps.LatLng(<?php echo $event['lat']; ?>, <?php echo $event['lng']; ?>),
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                map = new google.maps.Map(document.getElementById('map_show'), mapOptions);

                                var infowindow = new google.maps.InfoWindow(
                                        {content: '<b>' + address + '</b>',
                                            size: new google.maps.Size(150, 50)
                                        });

                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(<?php echo $event['lat']; ?>, <?php echo $event['lng']; ?>),
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
                    <h4 class=""><?php echo $event->organizer;?></h4>
                    
                    <p><?php echo $event->organizer_details;?></p>
                    <a href="mailto:gerrardsmith@email.com" class="btn btn-black contact-button"><i class="button-icon fa fa-envelope-o"></i>Contact Gerrard Smith</a>
                    <ul class="social-icon">
                        <li class="facebook">
                            <a href="facebook.com/gerrardsmith.html"><i class="icon fa fa-facebook"></i>
                                <div class="content">facebook.com/gerrardsmith</div>
                            </a>
                        </li>
                        <li class="twitter">
                            <a href="twitter.com/gerrardsmith.html"><i class="icon fa fa-twitter"></i>
                                <div class="content">twitter.com/gerrardsmith</div>
                            </a>
                        </li>
                    </ul>

                </div>

            </div>
        </div>            <!-- col-md-9 -->
        <div class="col-md-9">

            <div class="event-info">
                <div class="post" style="margin-top:0px;">

                    <div class="entry-header">
                        <?php echo $this->Awesome->image('Events/image', $event['image'], ['style' => 'width:100%', 'type' => 'large']); ?>
                    </div>
                    <div class="post-content">
                        <section class="event-detail newsection">
                            <h2 class="main-title"><?php echo $event['title']; ?></h2>
                            <ul class="meta clearfix">

                                <li class="date"><i class="icon fa fa-calendar"></i> 
                                    <?php echo $this->element('event_date', ['event' => $event]); ?>
                                </li>
                                <li><i class="icon fa fa-home"></i> <?php echo $this->Html->link($event['venue'], ['controller' => 'events', 'action' => 'search', 'venue' => $event['venue']]); ?></li>
                                <li><i class="icon fa fa-map-marker"></i> <?php echo $this->Html->link($event['address'], ['controller' => 'events', 'action' => 'search', 'address' => $event['address']]); ?></li>
                                <li><i class="icon fa fa-user"></i><span class="text"><?php echo $this->Html->link($event['organizer'], ['controller' => 'events', 'action' => 'search', 'organizer' => $event['organizer']]); ?></span></li>
                            </ul>

                            <div class="sep event-detail-sep"></div>
                            <h3 class="entry-title">Whats About</h3><p><?php echo $event['description']; ?></p>
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
                                                <?= $this->Awesome->image('EventImages/image', $image['image'], []); ?>
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
