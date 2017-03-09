<?php
$this->Html->addCrumb($title, ['action' => 'index']);
if ($contest->id) {
    $this->Html->addCrumb('Edit Contest', null);
} else {
    $this->Html->addCrumb('Add Contest', null);
}
?>
<div class="row" ng-controller="eventsController">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Contest Details</b></h4>

            <div class="row">
                <div class="col-lg-9">

                    <div class="p-20">
                        <?php
                        echo $this->Form->create($contest, [
                            'novalidate' => true,
                            'type' => 'file',
                            'class' => 'form-horizontal google_map1'
                        ]);
                        ?>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Title <span>*</span></label>
                            <?php
                            echo $this->Form->input('title', [
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                ]
                            ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">Ended Date <span>*</span></label>
                            <?php
                            echo $this->Form->input('expiry', [
                                'label' => false,
                                'type' => 'text',
                                'class' => 'datepicker',
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                ]
                            ]);
                            ?>
                        </div>



                        <div class="form-group">
                            <label class="col-lg-4 control-label">Image</label>
                            <?php
                            $image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image($modelClass . '/image', $contest['image'], ['class' => 'img-responsive clearfix']) . '
                                                                                                                
                                                                                                        </div>';
                            echo $this->Form->input('image', [
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-5 mt10 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
                                    'file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
                                'label' => false,
                                'class' => 'filestyle', 'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Details <span>*</span></label>
                            <?php
                            echo $this->Form->input('description', [
                                'templates' => [
                                    'inputContainer' => '<div class="col-lg-8 mt10 {{type}}{{required}}">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-lg-8 input {{type}}{{required}} error">{{content}}{{error}}</div>',
                                ],
                                'label' => false,
                                'class' => 'summernote']);
                            ?>
                        </div>

                        <div class="form-group m-b-0">
                            <div class="col-sm-offset-4 col-sm-9 m-t-15">
                                <?php
                                $submitBtn = $this->Form->button('Save', array('class' => 'btn btn-success'));
                                $caneclBtn = $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn btn-default m-l-5'));
                                echo $submitBtn;
                                echo $caneclBtn;
                                ?>
                            </div>
                        </div>


                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
