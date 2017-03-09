<?php
$this->Html->addCrumb('Blogs', ['controller' => 'blogs', 'action' => 'index']);
$this->Html->addCrumb('Add Blog', null);
?>
<script type="text/javascript">
    var blog = <?php echo json_encode($blog); ?>;
</script>
<div class="row" ng-controller="blogController">
    <?=
    $this->Form->create($blog, [
        'novalidate' => true,
        'type' => 'file',
        'id' => 'createBlog',
        //'ng-submit' => 'createBlog($event)'
    ]);
    ?>
    <div class="col-lg-8">
        <div class="card-box">

            <?php
            echo $this->Form->input('title', ['label' => false, 'placeholder' => 'Write your blog heading', 'class' => 'blog_heading']);

            echo $this->Form->input('description', ['label' => false, 'id' => 'summernotePJ', 'style' => 'height:500px;']);
            ?>

        </div>

        <div class="card-box">
            <h4 class = "m-t-0 m-b-30 header-title"><b>Tags</b></h4>

            <?php echo $this->Form->input('tags', ['data-role' => 'tagsinput', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Write Tags here', 'label' => false]); ?>

            <span class="help-inline">Hit enter to separate tags after written.</span>

        </div>

    </div>
    <style>
        .thumbnail{width: 100%; overflow: hidden;background: #e9eef1;}
        .thumbnail img{height: 200px;}
        .blog_heading{height: 50px; font-size: 18px;}
        .dd-handle{cursor: default}
        .custom-dd .dd-list .dd-item .dd-handle{padding: 8px 10px;}
        .dd-handle i {
            position: absolute;
            font-size: 18px;
            margin-top: 3px;
            margin-right: 10px;
            font-weight: bold;
        }
        span.item-text {
            margin-left: 22px;
        }
        note-editor.note-frame .note-placeholder {
            padding: 10px;
            font-size: 18px;
        }
        .thumbnail{margin-bottom: 0px;}
        .thumbnail:hover{background: #d8e0e6}
        .bootstrap-filestyle.input-group{
            width: 100%;
            opacity: 0;
            position: absolute;}
        .group-span-filestyle  label{
            width: 100%;
            height: 200px;
            margin-top: -200px;
            opacity: 0;
        }
/*        #featured {
            width: 305px;
            height: 200px;
            position: absolute;
            top: 94px;
            opacity: 0;
            cursor: pointer;
        }*/
    </style>
    <div class="col-lg-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Featured Image</h3>
                <span class="help-box">Click on image to update image.</span>
            </div>
            <div class="panel-body">

                <?php
                $image = '<div class="thumbnail">' . $this->Awesome->image($modelClass . '/image', $blog['image'], ['class' => 'img-responsive clearfix featured-image', 'default' => 'blog-upload.svg']);
                echo $image;

                echo $this->Form->file('image', [
                    'label' => false,
                    'id' => 'featured',
                    'class' => 'hide',
                    'onchange' => 'angular.element(this).scope().uploadImage(this)'
                ]);
                echo '</div>';

                $this->Form->input('image', [
                    'label' => false,
                    'templates' => ['file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                    'id' => 'featured',
                    'type' => 'file']);
                ?>

            </div>
        </div>

        <div class="panel  panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Category</h3>
            </div>
            <div class="panel-body">


                <?php
                echo $this->Form->error('category_id');
                ?>
                <div class="card-box1" style="height:340px; overflow: auto;padding-right: 5px;">

                    <?php echo $this->cell('Menus::categories', [], ['cache' => false]); ?>					
                </div>
            </div>
        </div>
        <?php
        echo $this->Form->input('category_id', ['ng-model' => 'Blogs.category_id', 'type' => 'text', 'style' => 'display:none', 'label' => false, 'error' => false]);
        echo $this->Form->input('parent_id', ['ng-model' => 'Blogs.parent_id', 'type' => 'text', 'style' => 'display:none', 'label' => false]);
        ?>

        <div ng-if="!Blogs.category_id && validationError" class="alert alert-danger">Please select category.</div>
        <button type="submit" class="btn btn-block btn-md btn-success waves-effect waves-light">Publish</button>
        
        
        <?php echo $this->Html->link('Cancel',['action' => 'myBlogs'],['class' => 'btn btn-block btn-md btn-default waves-effect waves-light']);?>
        
        

    </div>

    <?= $this->Form->end();
    ?>
</div>


