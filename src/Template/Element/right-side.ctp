<div id="sitebar">
 <div class="widget follow-us">
    <h1 class="section-title title">Follow Us</h1>
    <ul class="list-inline social-icons">
        <li><a href="https://www.facebook.com/PlanetJaipur/" target="_blank"><i class="fa fa-facebook"></i></a></li>
        <li><a href=" https://www.instagram.com/planetjaipur/" target="_blank"><i class="fa fa-instagram"></i></a></li>
        <li><a href="https://twitter.com/PlanetJaipur" target="_blank"><i class="fa fa-twitter"></i></a></li>
        
        <li><a href="https://in.pinterest.com/planetjaipur/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
        <!-- <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
        <!-- <li><a href="#"><i class="fa fa-linkedin"></i></a></li> -->
        <li><a href="https://www.youtube.com/channel/UCokF6pvspeDPf4Kh4_SEKUg" target="_blank"><i class="fa fa-youtube"></i></a></li>
    </ul>
</div>

<style type="text/css">
    ul.list-inline.social-icons li {
        margin-bottom: 15px;
    }
    .social-icons a .fa-instagram {
        background-color: #5B6CB2;
    }
    .social-icons a .fa-pinterest {
        background-color: #EE2C34;
    }
</style>
<!-- /#widget-->

<div class="widget">
    <div class="add">
        <?= $this->element('ads',['type' => 'Sidebar.First']);?>
    </div>
</div><!--/#widget-->

<?php echo $this->cell('Blog::popular', [], ['cachse' => true]);?>

<div class="widget">
    <div class="add">
        <?= $this->element('ads',['type' => 'Sidebar.Second']);?>
    </div>
</div><!--/#widget-->

</div>
