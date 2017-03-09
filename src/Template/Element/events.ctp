<?php

$backgorundColurs = ['#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#e67e22', '#95a5a6', '#7f8c8d', '#bdc3c7', '#f39c12', '#777d47'];




foreach ($events->toArray() as $listOne) {
    $rand = rand(0, count($backgorundColurs) - 1);
    $backColour = $backgorundColurs[$rand];

    $listOne = $listOne->toArray();
    $location = array();
    $location[] = $listOne['city'];
    $location[] = $listOne['state'];
    $location = implode(',', $location);

    $link = ['controller' => 'events', 'action' => 'view', 'slug' => $listOne['slug']];

    $isImage = ($listOne['image'] && file_exists('files/Events/image/'. $listOne['image'])) ? true : false;
    ?>
    <div class="col-md-4">
        <div class="post event bg">
            <div class="eventsimg <?php echo (!$isImage) ? 'placeholder-it' : '';?>" style="background: <?php echo $backColour;?>">
                <?php 
                if($isImage){
                    echo $this->Html->link($this->Awesome->image('Events/image', $listOne['image'], ['class' => '','type' => 'large']), $link, ['escape' => false]);
                } else{

                    echo $this->Html->link($this->Awesome->createAcronym($listOne['title']), $link, ['escape' => false]);
                }
                ?>
            </div>
            <div class="event-content">
                <h3 class="entry-title"><?php echo $this->Html->link($this->Text->truncate($listOne['title'],50), $link); ?></h3>
                <ul class="meta clearfix">

                    <li class="date"><i class="icon fa fa-calendar"></i> 
                        <?php echo $this->element('event_date', ['event' => $listOne]); ?>
                    </li>
                    <li class="date"><i class="icon fa fa-clock-o"></i> 
                        <?php echo $this->element('event_time', ['event' => $listOne]); ?>
                    </li>
                    <li><i class="icon fa fa-home"></i> <?php echo $this->Html->link($listOne['venue'], ['controller' => 'events', 'action' => 'search', 'venue' => $listOne['venue']]); ?></li>
                    <li><i class="icon fa fa-map-marker"></i> <?php echo $this->Html->link($location, ['controller' => 'events', 'action' => 'search', 'city' => $listOne['city'],'state' => $listOne['state']]); ?></li>
                    <li><i class="icon fa fa-user"></i><span class="text"><?php echo $this->Html->link($listOne['organizer'], ['controller' => 'events', 'action' => 'search', 'organizer' => $listOne['organizer']]); ?></span></li>
                </ul>

            </div>
            <div class="links three clearfix">
                <ul>
                    <li>
                        <?=  $this->Html->link('View More',$link); ?>
                    </li>

                    <li>
                    <!-- <a href="#void" class="portfolio-icon pix-like-me " data-id="10">
                    <i class="icon fa fa-heart"></i><span class="like-count">41</span>
                    </a> -->
                    </li>
                    <li><i class="icon fa fa-eye"></i><?= $listOne['view_count'];?></li> 
                </ul> 
            </div></div>
    </div>
<?php } ?>

