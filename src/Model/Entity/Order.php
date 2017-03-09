<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Order extends Entity {

	protected function _getTickets() {
		$ticketIds = explode(',',$this->_properties['event_ticket_id']);
        $tickets  = TableRegistry::get('EventTickets');
        $result = $tickets->find('all');
        $result->where(['EventTickets.id IN ' => $ticketIds])->select(['EventTickets.id','EventTickets.name','EventTickets.price','EventTickets.type','EventTickets.quantity']);

        return $result->toArray();
    }
}
