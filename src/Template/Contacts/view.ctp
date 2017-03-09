<?php
$this->assign('title', $contacts['title']);

$title = $contacts['title'];

$description = $this->Text->truncate(strip_tags($contacts['title']), 150, ['exact' => false]);

$meta = null;

$meta .= $this->Html->meta('description', $description);


$this->assign('meta', $meta);

$this->layout = 'fullpage';
?>

<div class="contact-us contact-page-two">
    <div class="message-box">
        <h1 class="section-title title">Drop Your Message</h1>
        <?= $this->Flash->render('contact') ?>
        <?php
        echo $this->Form->create($message, [
            'novalidate' => true,
            'type' => 'file',
            'id' => 'comment-form',
        ]);
        ?>
        <div class="row">
            <div class="col-sm-4">
                <?= $this->Form->input('name',['class' => 'form-control'])?>
            </div>
            <div class="col-sm-4">
                <?= $this->Form->input('email',['class' => 'form-control'])?>
            </div>
            <div class="col-sm-4">
                <?= $this->Form->input('subject',['class' => 'form-control'])?>
            </div>
            <div class="col-sm-12">
                <?= $this->Form->input('message',['class' => 'form-control','id' => 'comment','rows' => 5])?>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Send </button>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div><!-- contact-us -->