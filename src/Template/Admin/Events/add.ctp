<?php
$this->Html->addCrumb($title, ['action' => 'index']);
if ($event->id) {
    $this->Html->addCrumb('Edit Event', null);
} else {
    $this->Html->addCrumb('Add Event', null);
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Event Details</b></h4>
            <div class="row">
                <div class="col-lg-9 col-lg-offset-1 col-md-12">
                    <div class="p-20">
                    <?php echo $this->element('event_add'); ?>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
