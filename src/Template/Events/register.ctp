<?php $event = $tickets[0]['event']; ?>
<!-- HEADER -->  
<section class="sub-banner newsection">
    <div class="container">
        <h2 class="entry-title clearfix"><?php echo $event['title']; ?></h2>
        <h3 class="clearfix" style="clear: both"><?php echo $event['address']; ?></h3>
        <h4 class="clearfix" style="clear: both"><?php echo $this->element('event_date', ['event' => $event]); ?></h4>

    </div>

</section>

<div class="signup-page">
    <div class="container">
        <div class="row">
            <!-- user-login -->	
            <div class="col-sm-6 col-sm-offset-3">
                <?= $this->Flash->render() ?>
                <div class="ragister-account account-login">		
                    <h1 class="section-title title"><?= __('Registration Information'); ?></h1>
                    <?php
                    echo $this->Form->create($order, [
                        'novalidate' => true,
                    ]);

                    echo $this->Form->input('name', ['label' => 'Ticket Buyer Name']);

                    echo $this->Form->input('mobile', ['label' => 'Ticket Buyer Mobile no.']);
                    echo $this->Form->input('email', ['label' => 'Ticket Buyer Email']);
                    ?>

                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <?php echo $this->Form->end(); ?>

                </div>
            </div><!-- user-login -->			
        </div><!-- row -->	
    </div><!-- container -->
</div><!-- signup-page -->