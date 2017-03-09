<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class EventTicket extends Entity {

	protected function _getBooked() {
		$ticketId = $this->_properties['id'];
        $orders  = TableRegistry::get('Orders');
        $orders = $orders->find('all');
        $orders->select(['booked' => $orders->func()->sum('quantity')]);
        $orders->where(['FIND_IN_SET(\''. $ticketId .'\',Orders.event_ticket_id)']);

        $orders = $orders->first();
       
        return ($orders->booked) ? $orders->booked : 0;
    }
}
