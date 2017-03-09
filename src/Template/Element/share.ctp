<div class="share-area m-t-15"  url="<?php echo $url; ?>">
    <!--<h2>Share</h2>-->
    <ul class="list-inline social-icons rrssb-buttons">
        <!--        <li class="count"  ng-show="SocialShare.sharedCount" ng-cloak>{{SocialShare.sharedCount}} 
                    <span  ng-show="SocialShare.sharedCount == 1">SHARE</span>
                    <span ng-show="SocialShare.sharedCount > 1">SHARES</span>
                </li>-->
                <!--<li class="share-sep" ng-show="SocialShare.sharedCount"><img src="<?php echo $this->request->webroot; ?>img/img/bg-count.jpg" alt=""></li>-->         



        <li class="rrssb-facebook share-fb">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" class="SocialPopup">
                <?php echo $this->Html->image('facebook.png', ['width' => 30]); ?>
            </a>
        </li>
        <?php $imaeOnTwitter = (isset($image)) ? " | " . $image : ""; ?>
        <li class="rrssb-twitter share-tw">
            <a href="https://twitter.com/intent/tweet?text=<?php echo $title . ':' . $url; ?>" class="SocialPopup">
                <?php echo $this->Html->image('twitter.png', ['width' => 30]); ?>
            </a>
        </li>
        <li class="rrssb-googleplus share-gplus">
            <a href="https://plus.google.com/share?url=<?php echo $title . ':' . $url; ?>" class="SocialPopup">
                <?php echo $this->Html->image('google-plus.png', ['width' => 30]); ?>
            </a>
        </li>
        <li class="rrssb-linkedin share-linked ">
            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url . '&title=' . $title . "&summary=" . $description; ?>" class="SocialPopup">
                <?php echo $this->Html->image('linkedin.png', ['width' => 30]); ?>
            </a>
        </li>         

        <li class="rrssb-pinterest share-pinterest">
            <a href="http://pinterest.com/pin/create/button/?url=<?php echo $url . '&description=' . $description . "&media=" . $image; ?>" class="SocialPopup">
                <?php echo $this->Html->image('pinterest.png', ['width' => 30]); ?>
            </a>
        </li>

    </ul>
</div>