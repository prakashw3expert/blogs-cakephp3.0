<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class OrdersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Auth->allow(['orderStart']);
    }

    public function index() {

        $this->viewBuilder()->layout('profile');
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $session = $this->request->session();
            $loggedInAs = $session->read('Auth.User');
            // $this->paginate['conditions'] = ['Orders.user_id' => $loggedInAs['id']];
            $this->paginate['order'] = ['EventTickets.id' => 'DESC'];
            $this->paginate['contain'] = [
            'Events' => ['fields' => ['Events.id', 'Events.title', 'Events.slug', 'Events.venue', 'Events.city','Events.start_date','Events.end_date','Events.start_time','Events.end_time','Events.organizer']],
            'EventTickets' => ['fields' => ['name', 'sale_start_date', 'sale_end_date', 'start_time', 'end_time']]];
        });
        return $this->Crud->execute();
    }

    public function view($id) {
        
        $this->viewBuilder()->layout('profile');
        $this->Crud->action()->disable();
        $session = $this->request->session();
        $loggedInAs = $session->read('Auth.User');

        $order = $this->Orders->find()->where(['Orders.id' => $id,
            //'Orders.user_id' => $loggedInAs['id']
            ])
        ->contain([
            'Events' => ['fields' => ['Events.id', 'Events.title', 'Events.slug', 'Events.venue', 'Events.city','Events.start_date','Events.end_date','Events.start_time','Events.end_time','Events.organizer']],
            ])->first();

        $this->set(['order' => $order]);
        
    }

    public function orderStart() {

        if ($this->request->is('Post')) {
            $this->loadModel('Orders');
            $this->loadModel('EventTickets');
            $response['status'] = false;
            foreach ($this->request->data['ticketList'] as $ticketId => $quatity) {
                if(!$quatity){
                    unset($this->request->data['ticketList'][$ticketId]);
                    
                    continue;
                }
                $ticket = $this->EventTickets->find()
                ->where([
                    'id' => $ticketId,
                    'sale_start_date <= now()',
                    'sale_end_date >= now()',
                    ])
                ->first();



                if (empty($ticket)) {
                    $response['message'] = 'Ticket has been removed or sales end';
                    echo json_encode($response);
                    exit;
                }

                $booked = $this->Orders->find()
                ->where(['event_ticket_id' => $ticketId])
                ->count();

                $remaingTickets = $ticket->quantity - $booked;
                if ($remaingTickets < $quatity) {
                    $response['message'] = $remaingTickets . ' ticket(s) is remaining.';
                    echo json_encode($response);
                    exit;
                }

                if ($quatity < $ticket->min_order_count || $quatity > $ticket->max_order_count) {
                    $response['message'] = 'Min ticket(s) per order ' . $ticket->min_order_count . ' and max tickets per order is ' . $ticket->max_order_count;
                    echo json_encode($response);
                    exit;
                }
            }
        }

        $ticketData = $this->request->data['ticketList'];

        $this->request->session()->write('ticketData',$ticketData);


        $response['status'] = true;

        $response['message'] = 'Redirecting on confirm page....';
        $response['redirect'] = \Cake\Routing\Router::url(['controller' => 'events','action' => 'register'],true);

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
