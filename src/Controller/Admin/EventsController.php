<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class EventsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            //$this->paginate['fields'] = ['Events.id', 'Blogs.title', 'Blogs.created', 'Blogs.status'];
            $this->paginate['order'] = ['Events.id' => 'DESC'];
            $this->paginate['contain'] = ['Users'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function add() {
        //pr($this->request->data);die;
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }

        $this->request->data['user_id'] = $this->loggedIn['id'];

        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set('countries', $countries);
        });

        return $this->Crud->execute();
    }

    public function edit($id) {
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }
        //pr($this->request->data);die;
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {

            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set('countries', $countries);
            $event->subject()->entity['start_time'] = date('h:i', strtotime($event->subject()->entity['start_time']));
            $event->subject()->entity['end_time'] = date('h:i', strtotime($event->subject()->entity['end_time']));
            $event->subject()->entity['start_date'] = date('d/m/Y', strtotime($event->subject()->entity['start_date']));
            $event->subject()->entity['end_date'] = date('d/m/Y', strtotime($event->subject()->entity['end_date']));
        });
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

    public function view($slug) {
        $this->Crud->action()->disable();
        $event = $this->Events->find('slug', ['slug' => $slug]);

        if (empty($event)) {
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Orders');
        $orders = $this->Orders->find('all', [
                    'conditions' => ['Orders.event_id' => $event->id],
                    'contain' => ['Users']
                        ]
                )->toArray();

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
            return $this->redirect(['action' => 'view', 'slug' => $slug,'tab' => 'gallery']);
        }


        if (!empty($this->request->data) && isset($_POST['update'])) {
            $galleryAction = null;
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            //$this->Events->geoLocation($this->request->data);
            
            $userEntity = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($userEntity)) {
                $this->Flash->success(__('Event has been updated successfully.'));
                return $this->redirect(['action' => 'view', 'slug' => $slug,'tab' => 'settings']);
            }
            $this->Flash->error(__('Unable to update your event.'));
        }

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

        return $this->redirect($this->referer(['?' => ['tab' => 'gallery']]));
    }

    public function jsonData() {
        $query = $this->Events->find();
        $allData = $query->select([
                    'count' => $query->func()->count('id'),
                    'created' => 'DATE(created)'
                ])
                ->group('DATE(created)')
                ->where('status = 1');



        foreach ($allData as $data) {
            $result[] = array(
                'date' => date('Y-m-d', strtotime($data['created'])),
                'value' => $data['count']
            );
        }

        echo json_encode($result);
        exit;
    }

    public function chaneStatus(){
         $status = true;
        if($this->request->is('post')){
            $id = $this->request->data['id'];
            $value = $this->request->data['value'];
            $query = $this->Events->find();
            $query->select(['Events.id','Events.title','Events.slug','Events.id','start_date','end_date','Users.name','Users.email','Events.description']);
            $query->contain(['Users']);
            $query->group(['Users.id']);
            $event = $query->where(['Events.id' => $id]);//,'Events.status' => $value
            if($event->count() > 0 ){
                $event = $event->first();
                $entry = $this->Events->newEntity();
                $statusData['status'] = $value;
                $statusData['id'] = $id;
                $statusEntity = $this->Events->patchEntity($entry, $statusData,['validate' => false]);
                $updated = $this->Events->save($statusEntity);

                if ($updated && $value == 1 && !empty($event['user'])) {
                    /// Send email notification to event owner for notify event activation.
                    $status = true;

                    $template = 'event-approved';

                    $link = \Cake\Routing\Router::url(['prefix' => false,'controller' => 'events', 'action' => 'view','slug' => $event->slug], true);

                    $details = substr(strip_tags($event->description),0,150);

                    $replace = array($event['user']['name'], $event->title, $details,$link);
                   
                    $this->send_mail($event['user']['email'], $template, $replace);

                }
                elseif ($updated ) {
                    $status = true;
                }
                else{

                   $status = false; 
                }
            } 
        }
        $this->set(['success' => $status]);

    }

}
