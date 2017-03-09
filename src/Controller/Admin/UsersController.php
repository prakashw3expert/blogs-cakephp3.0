<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['is_admin'] = 0;
            $this->paginate['conditions']['role_id'] = 1;
            $this->paginate['contain'] = ['Countries'];
            $this->paginate['order'] = array('Users.id DESC');
            $this->paginate['fields'] = ['Users.id', 'Users.name', 'Users.slug', 'Users.email', 'Users.gender', 'Users.dob','Users.status', 'Users.created', 'Users.is_admin', 'Users.image', 'Countries.name'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
            $user = TableRegistry::get('Users');
            $user = $user->newEntity();
            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set(['user' => $user, 'countries' => $countries]);
        });

        return $this->Crud->execute();
    }

    public function add() {
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }
        if (empty($this->request->data['cover_image']['name'])) {
            unset($this->request->data['cover_image']);
        }
        if (!empty($this->request->data)) {
            $this->request->data['role_id'] = 1;
        }
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set(['countries' => $countries, 'title' => 'Add User']);
        });

        return $this->Crud->execute();
    }

    public function view($slug) {

        $this->Crud->action()->disable();
        $user = $this->Users->find('all', [
                    'conditions' => ['Users.slug' => $slug],
                    'contain' =>
                    [
                        'Countries' => ['fields' => ['Countries.name']]
                    ]
                        ]
                )->first();

        if (empty($user)) {
            return $this->redirect(['action' => 'index']);
        }
        // pr($user);die;
        if (!empty($this->request->data)) {

            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            if (empty($this->request->data['cover_image']['name'])) {
                unset($this->request->data['cover_image']);
            }
            if (empty($this->request->data['password']) && empty($this->request->data['confirm_password'])) {
                unset($this->request->data['password']);
                unset($this->request->data['confirm_password']);
            }
// echo "<pre>";print_r($this->request->data);die;
            $userEntity = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($userEntity)) {
                //pr($userEntity);die;
                $this->Flash->success(__('User has been updated successfully.'));
                return $this->redirect(['action' => 'view', $slug]);
            }
            $this->Flash->error(__('Unable to update your profile.'));
        }
        if($user->dob){
            $user->dob = date('d/m/Y', strtotime($user->dob));    
        }
        
        $countries = $this->{$this->modelClass}->Countries->find('list');

        $this->loadModel('Events');
        $events = $this->Events->find('all', ['conditions' => ['user_id' => $user->id]]);



        $this->Set(['countries' => $countries, 'user' => $user, 'events' => $events]);


        $this->loadModel('Orders');
        $orders = $this->Orders->find('all', ['conditions' => ['Orders.user_id' => $user->id],'contain' => ['Events']]);
        

        $this->Set(['countries' => $countries, 'user' => $user, 'events' => $events, 'orders' => $orders]);

        $this->set(['user' => $user]);
    }

     public function changeStatus($id,$status) {
        $user = $this->Users->find('all', ['conditions' => ['Users.id' => $id]])->first();

        if ($user->status != 1) {
           $this->request->data['status'] = 1;
           $message = 'User has been blocked';
        }
        else{
            $this->request->data['status'] = 0;
            $message = 'User has been Unblock';
        }

            $user = $this->Users->patchEntity($user, $this->request->data, [ 'validate' => false]);
            if ($this->Users->save($user)) {
                $this->Flash->set(__($message), [
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
                return $this->redirect(['action' => 'index']);
            }
    }


    public function login() {
        //echo (new DefaultPasswordHasher)->hash('123456');die;
        if ($this->request->is('post')) {

            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'), [
                    'key' => 'auth'
                ]);
            }
        }
        $this->viewBuilder()->layout('login');
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function jsonData() {
        $query = $this->Users->find();
        $allData = $query->select([
                    'count' => $query->func()->count('id'),
                    'created' => 'DATE(created)'
                ])
                ->group('DATE(created)')
                ->where('role_id = 1');


        $result = array();
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
