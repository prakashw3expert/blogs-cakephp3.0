<?php

?>
<script>
var contest = <?php echo json_encode(['slug' => $contest->slug,'ContestParticipates' => $ContestParticipates]); ?>;
</script>
<div id="site-content" class="site-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="left-content">
                <div class="details-news">											
                    <div class="post">
                        <div class="entry-header">
                            <div class="entry-thumbnail">
                                <?php //echo $this->Awesome->image('Contests/image', $contest['image'], ['class' => 'img-responsive', 'type' => 'large']); ?>
                            </div>
                        </div>
                        <div class="post-content text-center">	
                            <h2 class="entry-title">
                                <?php echo $this->Html->link($contest['title'], ['controller' => 'contests', 'action' => 'view', 'slug' => $contest['ttile']]); ?>
                            </h2>
                            <div class="entry-content">
                                <?php echo $contest['description']; ?>
                            </div>
                        </div>
                    </div><!--/post--> 
                </div><!--/.section-->
            </div><!--/.left-content-->
        </div>
    </div>
</div><!--/#site-content-->


<div class="signup-page" ng-controller="contestParticipateController" ng-cloak>
    <div class="container">
        <div class="row">
            <!-- user-login -->	
            <?php
            echo $this->Form->create($ContestParticipates, [
                'novalidate' => true,
                'type' => 'file',
                'id' => 'newEntryForm'
            ]);
            ?>
            <div class="col-sm-6 col-sm-offset-3">
                <?= $this->Flash->render() ?>
                <div class="ragister-account account-login">		
                    <?php
                    echo $this->Form->input('title');
                    echo $this->Form->hidden('isImageRemoved',['ng-model' => 'isImageRemoved']);

                    echo $this->Form->input('tags', ['label' => 'Tags (comma separate)', 'placeholder' => 'eg: building,jaipur,world Min 3 tags', 'type' => 'text']);

                    //echo $this->Form->input('catetory_id');
                    ?>
                    <?php $imageError = $this->Form->error('image'); ?>
                    <aside  class="clearfix imagePreview" ng-show="isImageUploade">
                        <div class="widget clearfix m-b-10">
                            <?php echo $this->Awesome->image('ContestParticipates/image', $ContestParticipates['image'], ['class' => 'featured-image']); ?>
                            <h5><a href="javascipt:void(0)" ng-click="removeUploadImage()" class="pull-right">Remove</a></h5>
                        </div>
                    </aside>
                    
                    <aside  ng-show="!isImageUploade" id="aside" class="clearfix no-border-bottom upload-picture <?php echo ($imageError) ? 'error' : ''; ?>">
                        <?php echo $this->Form->file('image',['onchange' => 'angular.element(this).scope().previewImage(this)','id' => 'participate_image']); ?>
                        <div class="widget clearfix m-b-10">
                            <div class="eventform-con clearfix text-center">
                                <h1><i class="fa fa-cloud-upload" aria-hidden="true"></i></h1>
                                <h2>Drag and Drop to upload </h2>
                                <h5>or click to browse from computer  </h5>
                            </div>
                        </div>

                    </aside>
                    <?php echo $imageError; ?>
                    <?php
                    echo $this->Form->input('description', ['class' => 'textarea']);
                    ?>

                    <label class="" for="signing">
                        By submitting, you agree to the <?php echo $this->Html->link('Terms of Service',['controller' => 'pages','action' => 'view', 'term-and-conditions'],['target' => '_blank']);?>.
                    </label>	
                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </div>
            </div><!-- user-login -->	
            <?php echo $this->Form->end(); ?>
        </div><!-- row -->	
    </div><!-- container -->
</div><!-- signup-page -->
