<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;


class EventsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index', 'view', 'search']);
        $this->Crud->addListener('Crud.Search');
    }

    public function index($category = null) {
        $this->viewBuilder()->layout('event');
        $cities = $this->Events->find('cities');
        // print_r($cities);die;
        $this->set(['cities' => $cities]);
    }

    public function search() {
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['status'] = 1;
            $this->paginate['contain'] = ['Countries'];
            $this->paginate['order'] = ['(IF(DATE(Events.start_date) < now(), true, false))' => 'ASC','Events.start_date' => 'DESC','Events.created' => 'DESC'];

//            $this->paginate['fields'] = ['Users.id', 'Users.first_name', 'Users.last_name', 'Users.slug', 'Users.email', 'Users.created', 'Users.age', 'Users.gender', 'Users.muslim_since', 'Users.image', 'Countries.name'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
            $this->viewBuilder()->layout('event');

            $cities = $this->Events->find('cities');
            $this->set(['cities' => $cities]);
        });

        return $this->Crud->execute();
    }

    public function view($slug) {
        $event = $this->Events->find('details', ['slug' => $slug]);
        $this->Set(['event' => $event]);
        if (empty($event)) {
            throw new NotFoundException('404 error.');
        }
        $this->viewBuilder()->layout('event');
    }

    public function myEvents() {
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $session = $this->request->session();
            $loggedInAs = $session->read('Auth.User');
            $this->paginate['conditions'] = ['Events.user_id' => $loggedInAs['id']];
            $this->paginate['order'] = ['Events.id' => 'DESC'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        $this->viewBuilder()->layout('profile');
        return $this->Crud->execute();
        $this->render('/Admin/Events/index');
    }

    public function add() {
        //pr($this->request->data);die;
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }
        $session = $this->request->session();
        $loggedInAs = $session->read('Auth.User');
        $this->request->data['user_id'] = $loggedInAs['id'];
        $this->request->data['status'] = 0;

         $this->Crud->on('afterSave', function(\Cake\Event\Event $event) {
            $session = $this->request->session();
            $loggedInAs = $session->read('Auth.User');
            if ($event->subject()->created) {
                //Send Notification to user via email 
                $article = $event->subject()->entity;
                $template = 'event-add';

                $link = \Cake\Routing\Router::url(['controller' => 'events', 'action' => 'myEvents'], true);

                $details = substr(strip_tags($article->description),0,150);

                $replace = array($loggedInAs['name'], $article->title, $details,$link);
                
                $this->send_mail($loggedInAs['email'], $template, $replace);

                //Send Notification to admin via email
                $template = 'admin-email-for-event-post';

                $admin = Configure::read('Site.email');
            
                $details = substr(strip_tags($article->description),0,150);

                $replace = array($admin, $article->title, $details);
                
                $this->send_mail($admin, $template, $replace);

                $this->Flash->success(__('Your event has been posted successfully, but it will take 24-40 hrs to make it live.'));
                return $this->redirect(['action' => 'myEvents']);

            }
        });

        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set('countries', $countries);
        });
        $this->viewBuilder()->layout('profile');
        return $this->Crud->execute();
    }

    public function viewDetails($slug) {
        $event = $this->Events->find('slug', ['slug' => $slug]);
        if (empty($event)) {
            return $this->redirect(['action' => 'myEvents']);
        }

        $event['start_time'] = date('h:i', strtotime($event['start_time']));
        $event['end_time'] = date('h:i', strtotime($event['end_time']));
        $event['start_date'] = date('d/m/Y', strtotime($event['start_date']));
        $event['end_date'] = date('d/m/Y', strtotime($event['end_date']));

        $session = $this->request->session();

        if ($session->check('EventImages.error')) {
            $this->Flash->set(__($session->read('EventImages.error')), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
            ]);
            $session->delete('EventImages.error');
        }

        $galleryAction = $this->request->query('tab');

        if (!empty($this->request->data) && isset($_POST['gallery'])) {

            $eventImages = TableRegistry::get('EventImages');

            //$eventImages = $eventImages->newEntity();
            $message = null;
            foreach ($this->request->data['image'] as $key => $value) {
                $data['image'] = $value;
                $data['event_id'] = $event['id'];
                $entities = $eventImages->newEntity($data, [ 'validate' => true]);
                //$entities->clean();

                if (!$result = $eventImages->save($entities)) {
                    $error = $entities->errors('image');
                    $message = $error[key($error)];
                }
            }
            if (!$message) {
                $message = 'Gallery image uploaded successfully.';
            }
            $session->write('EventImages.error', $message);
            return $this->redirect(['action' => 'viewDetails', 'slug' => $slug,'tab' => 'gallery']);
        }


        if (!empty($this->request->data) && isset($_POST['update'])) {
            $galleryAction = null;
            //print_r($this->request->data);die;
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            //$this->Events->geoLocation($this->request->data);
            $userEntity = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($userEntity)) {
                $this->Flash->success(__('Event has been updated successfully.'));
                return $this->redirect(['action' => 'viewDetails', 'slug' => $slug,'tab' => 'settings']);
            }
            $this->Flash->error(__('Unable to update your event.'));
        }

        $this->loadModel('Orders');
        $orders = $this->Orders->find('all', [
                    'conditions' => ['Orders.event_id' => $event->id],
                    'contain' => ['Users']
                        ]
                )->toArray();

        $this->viewBuilder()->layout('profile');
        $countries = $this->{$this->modelClass}->Countries->find('list');
        $this->Set(['countries' => $countries, 'event' => $event, 'orders' => $orders,'galleryAction' => $galleryAction]);
    }

    public function deleteImg($id) {
        $entity = $this->Events->EventImages->get($id);
        $result = $this->Events->EventImages->delete($entity);
        if ($result) {
            $this->Flash->success(__('Gallery image has been removed successfully.'));
        } else {
            $this->Flash->error(__('Unable to remove image.'));
        }

        return $this->redirect($this->referer());
    }

    public function register() {
        $this->viewBuilder()->layout('event');
        $ticketsList = [];
        $tickets = $this->request->session()->read('ticketData');
        if (!$tickets) {
            return $this->redirect($this->refefer());
        }

        $this->loadModel('EventTickets');
        $this->loadModel('Orders');

        $order = $this->Orders->newEntity();

        $totalQuantity = 0;
        
        foreach ($tickets as $ticketId => $quatity) {
            $totalQuantity += $quatity;
            $ticket = $this->EventTickets->find()
                    ->where([
                        'EventTickets.id' => $ticketId,
                        'EventTickets.sale_start_date <= now()',
                        'EventTickets.sale_end_date >= now()',
                    ])
                    ->contain(['Events' => ['fields' => ['id', 'title', 'slug', 'image', 'start_date', 'end_date', 'start_time', 'end_time', 'address','organizer','venue']]])
                    ->first();



            if (empty($ticket)) {
                $this->Flash->error(__('Ticket has been removed or sales end'));
                return $this->redirect($this->referer());
            }

    

            $remaingTickets = $ticket->quantity - $ticket->booked;
            if ($remaingTickets < $quatity) {
                $this->Flash->error(__('Min ticket(s) per order is ' . $ticket->min_order_count . ' and max tickets is ' . $ticket->max_order_count));
                return $this->redirect($this->referer());
            }

            if ($quatity < $ticket->min_order_count || $quatity > $ticket->max_order_count) {
                $this->Flash->error(__($remaingTickets . ' ticket(s) is remaining.'));
                return $this->redirect($this->referer());
            }
            $ticketsList[] = $ticket;
        }

        if ($this->request->is(['Post'])) {
            $ticketIds = Hash::combine($ticketsList, '{n}.id', '{n}.id');
            
            $order = $this->Orders->newEntity($this->request->data());
            $order->user_id = $this->loggedInAs['id'];
            $order->event_id = $ticketsList[0]['event']['id'];
            $order->event_ticket_id = implode(',', $ticketIds);
            $order->amount = 0;
            $order->status = 1;
            $order->ticket_data = json_encode($tickets);
            $order->quantity = $totalQuantity;
            if ($this->Orders->save($order)) {

                $template = 'event-ticket';

                $replace = array(
                    $this->request->data['name'],
                    $ticketsList[0]->event->title,
                    'Free',
                    'Free',
                    date('d/M/Y'),
                    $order['id'],
                    count($ticketsList),
                    $ticketsList[0]->event->organizer,
                    $ticketsList[0]->event->end_date,
                    $ticketsList[0]->event->start_date.' - '.$ticketsList[0]->event->end_date,
                );
                
                $this->send_mail($this->request->data['email'], $template, $replace);

                $this->Flash->success(__('Your ticket has been booked. E-ticket has been sent to your email address.'));
                return $this->redirect(['controller' => 'events','action' => 'view','slug' => $ticketsList[0]['event']['slug']]);
            }
        }

        $this->set(['tickets' => $ticketsList, 'order' => $order]);
    }

}
