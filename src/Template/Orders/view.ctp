<?php 
$this->Html->addCrumb('Tickets', array('controller' => 'orders','action' => 'index'));
$this->Html->addCrumb('Print Ticket', null);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
<!-- <div class="panel-heading">
<h4>Invoice</h4>
</div> -->
<div class="panel-body">
    <div class="clearfix">
        <div class="pull-left">

        </div>
        <div class="pull-right">
            <h4>Ticket # 
                <strong><?= $order->id; ?></strong>
            </h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">

            <div class="pull-left m-t-30">
                <address>
                    <strong><?= $order->name; ?></strong><br>
                    Email : <?= $order->email; ?><br>
                    Mobile : <?= $order->mobile; ?>
                </address>
            </div>
            <div class="pull-right m-t-30">
                <p><strong>Order Date: </strong> <?= $order->created; ?></p>
                <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-pink"><?php echo ($order->status) ? "Completed" : "Pending"; ?></span></p>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table m-t-30">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Event Orgnizser</th>
                            <th>Event Venue</th>
                            <th>Event Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $order->event->title; ?></td>
                            <td><?= $order->event->organizer; ?></td>
                            <td><?= $order->event->venue; ?></td>
                            <td><?= $this->element('event_date', ['event' => $order->event]);?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="m-h-50"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table m-t-30">
                    <thead>
                        <tr><th>#</th>
                            <th>Ticket</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Total</th>
                        </tr></thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            $ticket_data  = json_decode($order->ticket_data,true);
                            foreach ($order->tickets as $key => $ticket) { ?>
                            <tr>
                                <td><?= $key+1;?></td>
                                <td><?= $ticket->name;?></td>
                                <td><?= $ticket->type;?></td>
                                <td><?= $ticket_data[$ticket->id];?></td>
                                <td><?= $ticket->price;?></td>
                                <td><?= round($ticket_data[$ticket->id] * $ticket->price,2);?></td>
                            </tr>
                            <?php $total += $ticket_data[$ticket->id] * $ticket->price;?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="border-radius: 0px;">
            <div class="col-md-3 col-md-offset-9">
                <p class="text-right"><b>Sub-total:</b> <?= round($total,2);?></p>
                <!-- <p class="text-right">VAT: 12.9%</p> -->
                <hr>
                <h3 class="text-right">Rs <?= round($total,2);?></h3>
            </div>
        </div>
        <hr>
        <div class="hidden-print">
            <div class="pull-right">
                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i></a>
                
            </div>
        </div>
    </div>
</div>

</div>

</div>