<?php
$this->Html->addCrumb('Contests', ['action' => 'index']);

$this->Html->addCrumb($contest->title, null);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="m-t-0 header-title"><b><?php echo $contest->title; ?></b></h4>


                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo $this->Awesome->image('Contests/image', $contest['image'], ['class' => 'img-responsive']); ?>


                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-md-offset-1">

                    <p class="text-muted m-b-30 font-13">
                        <?php echo $contest->title; ?>
                    </p>



                </div>
            </div>
        </div>
    </div>
</div> <!-- end row -->

<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default hover-effect">
                    <div class="panel-heading p-0">
                        <div class="pro-widget-img"></div>
                    </div>
                    <div class="panel-body">
                        <div class="clearfix col-lg-6 col-md-6 col-sm-6">
                            <h4 class="m-t-0 m-b-5">Adhamdannaway</h4>
                            <p class="c-gray f-16 align-center">Photographer</p>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-6 p-t-20">
                            <div class="col-xs-4">
                                <div class="text-center m-b-5">
                                    <i class="mdi md-comment"></i>
                                </div>
                                <div class="text-center">
                                    1568
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="text-center m-b-5">
                                    <i class="mdi md-thumb-up text-success"></i>
                                </div>
                                <div class="text-center">
                                    866
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="text-center m-b-5">
                                    <i class="mdi md-favorite text-danger"></i>
                                </div>
                                <div class="text-center">
                                    254
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>