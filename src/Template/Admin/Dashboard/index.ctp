<!-- Page-Title -->
<script src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/amcharts.js"></script>
<script src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/serial.js"></script>
<script src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/themes/light.js"></script>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/plugins/export/export.js"></script>

<script src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/plugins/dataloader/dataloader.min.js"></script>

<script src="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/charts.js"></script>

<link  type="text/css" href="<?php echo $this->request->webroot; ?>assets/plugins/amcharts/amcharts/plugins/export/export.css" rel="stylesheet">
<script type="text/javascript">
    PsCharts.adminDashbaord();

</script>


<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box fadeInDown animated">
            <div class="bg-icon bg-icon-info pull-left">
                <i class="ion-android-social text-info"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $this->Awesome->niceCount($users); ?></b></h3>
                <p class="text-muted">Total Users</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-pink pull-left">
                <i class="md  md-event-available text-pink"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $this->Awesome->niceCount($events); ?></b></h3>
                <p class="text-muted">Total Events</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-purple pull-left">
                <i class="md md-equalizer text-purple"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $this->Awesome->niceCount($orders); ?></b></h3>
                <p class="text-muted">Orders</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="fa fa-pencil text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $this->Awesome->niceCount($blogs); ?></b></h3>
                <p class="text-muted">Total Blogs</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="text-dark header-title m-t-0">Users Analytics</h4>
            <div id="totalUsers" style="height: 500px;"></div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="text-dark header-title m-t-0">Blog Analytics</h4>
            <div id="totalBlogs" style="height: 500px;"></div>
        </div>
    </div>
</div>
<!-- end row -->


<div class="row">

    
    
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="text-dark header-title m-t-0">Sales Analytics</h4>
            <div id="order_history" style="height: 500px;"></div>
        </div>
    </div>
    
    <!-- col -->

    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="text-dark header-title m-t-0">Events Analytics</h4>
            <div id="totalEvents" style="height: 500px;"></div>
        </div>
    </div>



</div>
<!-- end row -->
