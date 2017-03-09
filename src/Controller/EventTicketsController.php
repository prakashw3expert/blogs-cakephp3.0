<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class EventTicketsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $this->viewBuilder()->layout('profile');
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
           // $this->paginate['conditions'] = ['EventTickets.event_id' => $this->request->data['event_id']];
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

    public function add($event_id) {
        $this->Crud->action()->disable();
        $response['status'] = 'success';
        $response['message'] = '';
        $this->request->data['event_id'] = $event_id;
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
            $response['message'] = 'Update Successfully.';
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
