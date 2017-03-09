<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class EventTicketsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Auth->allow(['index','add','delete','get']);
    }

    public function index() {
        $this->viewBuilder()->layout(false);
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions'] = ['EventTickets.event_id' => $this->request->data['event_id']];
            $this->paginate['order'] = ['EventTickets.id' => 'DESC'];
        });
        return $this->Crud->execute();
    }

    public function get() {

        $eventTickets = $this->EventTickets->findById($this->request->data['ticket_id'])->first()->toArray();
        if ($eventTickets['sale_start_date']) {
            $eventTickets['sale_start_date'] = date('d/m/Y', strtotime($eventTickets['sale_start_date']));
            $eventTickets['sale_end_date'] = date('d/m/Y', strtotime($eventTickets['sale_end_date']));
            $eventTickets['start_time'] = date('h:i:s', strtotime($eventTickets['sale_start_date']));
            $eventTickets['end_time'] = date('h:i:s', strtotime($eventTickets['sale_end_date']));
        }
        echo json_encode($eventTickets);
        die;
    }

    public function add($event_id, $ticketId = null) {
        $this->Crud->action()->disable();
        $response['status'] = 'success';
        $response['message'] = '';
        $this->request->data['event_id'] = $event_id;
        if(strtolower($this->request->data['type']) == 'free'){
            $this->request->data['price'] = 0;
        }
        unset($this->request->data['id']);
        
        if($ticketId){
            $this->request->data['id'] = $ticketId;
        }
        //pr($this->request->data);die;
        $eventTickets = TableRegistry::get('EventTickets');
        $entities = $eventTickets->newEntity($this->request->data, [ 'validate' => true]);
        
        if (!$result = $eventTickets->save($entities)) {
            $errors = $entities->errors();
            $errorsList = array();
            foreach ($errors as $error) {
                $errorsList[] = $error[key($error)];
            }
            $response['message'] = implode('<br/>', $errorsList);
            $response['status'] = 'error';
        } else {
            $response['message'] = (!$ticketId) ? 'Ticket created successfully.' : 'Ticket updated successfully.';
        }
        echo json_encode($response);
        exit;
    }

    public function delete($id) {
        $response['status'] = 'error';
        $response['message'] = 'Could not deleted.';
        $this->Crud->action()->disable();
        $entity = $this->EventTickets->get($id);
        
        if ($this->EventTickets->delete($entity)) {
            $response['status'] = 'success';
            $response['message'] = 'Deleted Successfully.';
        }
        
        echo json_encode($response);
        exit;
    }

}
