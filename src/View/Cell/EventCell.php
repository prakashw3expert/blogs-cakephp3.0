<?php

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;


class EventCell extends Cell {

    public function upcoming() {
        $this->loadModel('Events');
        $events = $this->Events->find('all', [
            'conditions' => ['Events.status' => 1, 'Events.start_date >' => date('Y-m-d'),],
            'limit' => 27,
            'order' => 'Events.start_date ASC,Events.created ASC'
            ]);
        $this->set('events', $events);
    }

    public function all() {
        $this->loadModel('Events');
        //$this->Events->virtualFields['is_passed'] = "IF(DATE(Event.start_date) < now(), true, false)";
        $events = $this->Events->find('all', [
            'conditions' => ['Events.status' => 1],
            'limit' => 27,
            'order' => '(IF(DATE(Events.start_date) < now(), true, false)) ASC,Events.start_date DESC,Events.created DESC'
            ]);
        $this->set('events', $events);
    }

    public function today() {
        $this->loadModel('Events');
        
        $events = $this->Events->find('all', [
            'conditions' => [
                'Events.status' => 1,
                'Events.start_date <= ' => date('Y-m-d'),
                'Events.end_date >= ' => date('Y-m-d'),
            ],
             'limit' => 27,
             'order' => 'Events.start_date ASC,Events.created ASC',
             ]);
        $this->set('events', $events);
    }

    public function userEvents($user_id) {
        $this->loadModel('Events');
        
        $events = $this->Events->find('all', [
            'conditions' => ['Events.status' => 1,'Events.user_id' => $user_id],
            'limit' => 100,
            'order' => '(IF(DATE(Events.start_date) < now(), true, false)) ASC,Events.start_date DESC,Events.created DESC'
            ]);
        $this->set('events', $events);
    }


    public function ticketsCount($event_id) {
        $this->loadModel('EventTickets');
        $tickets = $this->EventTickets->find('all')->where('event_id=' . $event_id)->count();
        $this->set('tickets', $tickets);
    }
    
    public function bookingsCount($event_id) {
        $this->loadModel('Orders');
        $bookings = $this->Orders->find('all')->where('event_id=' . $event_id)->count();
        $this->set('bookings', $bookings);
    }
    
    public function ticketName($ticketIds) {
        $this->loadModel('EventTickets');
        $tickets = $this->EventTickets->find('all')->where('id IN (' . $ticketIds.')')->toArray();
        
        $this->set('tickets', $tickets);
    }

    public function viewEvent($eventId, $userId) {
        $ipAddress = $this->request->clientIp();
        $this->loadModel('EventsViews');
        $session = $this->request->session();
        if($session->check('EventView_'.$eventId)){
            return false;
        }
        $conditions = ['EventsViews.event_id' => $eventId];
        if ($userId) {
            $conditions[] = ['EventsViews.user_id' => $userId];
        } else {
            $conditions[] = ['EventsViews.ip_address' => $ipAddress];
        }
        $isLiked = $this->EventsViews->find('all', ['conditions' => $conditions])->count();

        if ($isLiked > 0) {
            return false;
        }

        $entry = $this->EventsViews->newEntity();
        $likedData['user_id'] = $userId;
        $likedData['event_id'] = $eventId;
        $likedData['ip_address'] = $ipAddress;
        $likedData['created'] = date('Y-m-d H:i:s');

        $entry->user_id = $userId;
        $entry->eventId = $eventId;
        $entry->ip_address = $ipAddress;
        $entry->created = date('Y-m-d H:i:s');

        $userEntity = $this->EventsViews->patchEntity($entry, $likedData);

        if ($this->EventsViews->save($userEntity)) {
            $this->loadModel('Events');
            $query = $this->Events->query();
            $result = $query
            ->update()
            ->set(
                $query->newExpr('view_count = view_count + 1')
                )
            ->where([
                'id' => $eventId
                ])
            ->execute();
            
            $session->write('EventView_'.$eventId,1);
            return true;
        }
        return false;
    }

}
