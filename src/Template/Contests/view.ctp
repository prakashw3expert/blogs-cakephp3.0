<?php

use Cake\I18n\Time;

$this->assign('title', 'Contests');

$this->Html->addCrumb('Contests', ['action' => 'index']);
$this->Html->addCrumb($contest['title'], ['action' => 'view','slug' => $contest['slug']]);

$title = (!empty($contest['meta_title'])) ? $contest['meta_title'] : $contest['title'];
$title = (!empty($contest['meta_keyword'])) ? $contest['meta_keyword'] : $contest['tags'];
$description = $contest['meta_description'];

$author = $contest['user']['name'];
$keyword = $contest['tags'];

$socialImage = $this->Awesome->image('Contests/image', $contest['image'], ['class' => 'img-responsive', 'type' => 'large', 'tag' => false]);

if (!$description) {
    $description = $this->Text->truncate(strip_tags($contest['description']), 150, ['exact' => false]);
}

$link = $this->Url->build(['controller' => 'blogs', 'action' => 'view', 'category' => $contest['category']['slug'], 'slug' => $contest['slug']], ['base' => false]);

$meta = null;
$meta .= $this->Html->meta('keywords', $keyword);
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

$backgorundColurs = ['#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#e67e22', '#95a5a6', '#7f8c8d', '#bdc3c7', '#f39c12', '#777d47'];
$rand = rand(0, count($backgorundColurs) - 1);
$backColour = $backgorundColurs[$rand];
?>

<div id="site-content" class="site-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="left-content">

                <div class="middle-content">										
                    <div class="post football-result">
                        <div class="featured-result"  style="background: <?php echo $backColour; ?>">
                            <h1 class="league-name"><?php echo $contest['title']; ?></h1>
                            <div class="row">
                                <?php
                                $time = $contest->expiry;
                                $date = '<div class="clocktime"></div>';
                                if ($time->isPast()) {
                                    $date = 'Ended';
                                }

                                $now = new Time();
                                $expiry = new Time($time);
                                $difference = $expiry->diff($now);
                                $difference = (array) $difference;
                                
                                $minutes = 0;
                                $minutes += $difference['y'] * 12 * 30 * 24 * 3600;
                                $minutes += $difference['m'] * 30 * 24 * 3600;
                                $minutes += $difference['d'] * 24 * 3600;
                                $minutes += $difference['h'] * 3600;
                                $minutes += $difference['i'] * 60;
                                $minutes += $difference['s'];
                                echo $date;
                                ?>
                            </div>
                            <div class="entry-content contest_btns">
                                <?php
                                if (!$time->isPast()) {
                                    echo $this->Html->link('Participate now!', ['controller' => 'contests', 'action' => 'participate', 'slug' => $contest->slug], ['class' => 'contest-btn']);
                                }
                                ?>
                                <?php echo $this->Html->link('View Entries!', ['controller' => 'contests', 'action' => 'enteries', 'slug' => $contest->slug], ['class' => 'contest-btn']); ?>
                            </div>
                            <br><br>
                            <h4>Share this contest</h4>
                            <?php
                            echo $this->element('share', array(
                                'url' => $link,
                                'title' => $contest['title'],
                                'description' => $contest['title'],
                                'image' => '',
                                    )
                            );
                            ?>
                        </div>

                    </div>									
                </div>

                <div class="details-news">											
                    <div class="post">
                        <div class="post-content text-center">								
                            <div class="entry-content">
                                <?php echo $contest['description']; ?>
                            </div>
                        </div>
                    </div><!--/post--> 
                </div><!--/.section-->

                <?php if ($contest->contest_participates) { ?>
                    <div class="details-news">											
                        <div class="post">
                            <div class="entry-thumbnail">
                                <div class="row">
                                    <?php
                                    foreach ($contest->contest_participates as $image) {
                                        $linkEntry = ['controller' => 'contests', 'action' => 'entry', 'slug' => $contest['slug'], 'entry' => $image['slug']];

                                        echo '<div class="col-sm-4">';
                                        echo $this->Html->link($this->Awesome->image('ContestParticipates/image', $image['image'], ['class' => 'img-responsiv', 'type' => 'thumbnail']), $linkEntry, ['escape' => false]);
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><!--/post--> 
                    </div><!--/.section-->
                <?php } ?>

            </div><!--/.left-content-->
        </div>



    </div>
</div><!--/#site-content-->
<?php if (!empty($contest['prize'])) { ?>
    <div class="row">
        <div class="col-sm-12">								
            <div class="comments-wrapper">
                <h1 class="section-title title">Prize</h1>
                <div class="details-news">											
                    <div class="post">
                        <div class="post-content text-center">								
                            <div class="entry-content">
                                <?php echo $contest['prize']; ?>
                            </div>
                        </div>
                    </div><!--/post--> 
                </div><!--/.section-->
            </div>

        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-sm-12">								
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

<?php
echo $this->start('jsSection');

echo $this->Html->css('flipclock');
echo $this->Html->script('flipclock.min');

echo '<script type="text/javascript">
            var clock;

            $(document).ready(function () {
                var clock;

                clock = $(".clocktime").FlipClock({
                    clockFace: "DailyCounter",
                    autoStart: false,
                });
                clock.setTime(' . $minutes . ');
                clock.setCountdown(true);
                clock.start();
            });
        </script>';

$this->end();
?>

