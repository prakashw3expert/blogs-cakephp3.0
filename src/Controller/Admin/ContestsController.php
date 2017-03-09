<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class ContestsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
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

        return $this->Crud->execute();
    }

    public function edit($id) {
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }
        
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

    public function view($slug) {

        $this->Crud->action()->disable();
        $contest = $this->Contests->find('slug', ['slug' => $slug]);

        if (empty($contest)) {
            return $this->redirect(['action' => 'index']);
        }

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
            return $this->redirect(['action' => 'view', 'slug' => $slug]);
        }


        if (!empty($this->request->data) && isset($_POST['update'])) {
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            //$this->Events->geoLocation($this->request->data);
            $userEntity = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($userEntity)) {
                $this->Flash->success(__('Event has been updated successfully.'));
                return $this->redirect(['action' => 'view', 'slug' => $slug]);
            }
            $this->Flash->error(__('Unable to update your event.'));
        }
        
        $this->loadModel('ContestParticipates');
        $contain = ['Users' => ['fields' => ['Users.name', 'Users.slug','Users.id']]];
        $contain['ContestParticipatesUsers'] = ['conditions' => ['ContestParticipatesUsers.user_id' => $this->loggedInAs['id']], 'fields' => ['ContestParticipatesUsers.id', 'ContestParticipatesUsers.contest_participate_id']];
        $config = [
            'contain' => $contain,
            'order' => ['ContestParticipates.likes' => 'DESC'],
            'limit' => 60,
            'conditions' => [
                'ContestParticipates.contest_id' => $contest->id
            ]
        ];

        $entries = $this->Paginator->paginate($this->ContestParticipates, $config);


        $this->set(compact('contest', 'entries'));
        

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

}
