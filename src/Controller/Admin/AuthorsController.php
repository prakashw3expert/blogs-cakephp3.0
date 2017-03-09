<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Auth\DefaultPasswordHasher;

class AuthorsController extends AppController {

    public $modelClass = 'Users';

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
        
    }
    
    public function beforeRender(\Cake\Event\Event $event) {
        parent::beforeRender($event);
         $this->set('title', 'Authors');
        
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['is_admin'] = 0;
            $this->paginate['conditions']['role_id'] = 2;
            $this->paginate['order'] = array('Users.id DESC');
            $this->paginate['fields'] = ['Users.id', 'Users.name', 'Users.email', 'Users.created', 'Users.is_admin', 'Users.slug', 'Users.image','Users.blog_count','Users.status'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
           
        });

        return $this->Crud->execute();
    }

    public function add() {
        if (!empty($this->request->data)) {
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            if (empty($this->request->data['cover_image']['name'])) {
                unset($this->request->data['cover_image']);
            }
            $this->request->data['is_admin'] = 0;
            $this->request->data['role_id'] = 2;
            $this->request->data['status'] = 1;
        }
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $countries = $this->{$this->modelClass}->Countries->find('list');
            $this->Set(['countries' => $countries, 'title' => 'Add User']);
        });
        return $this->Crud->execute();
    }

    public function edit($id) {
        if (!empty($this->request->data)) {
            //pr($this->request->data);die;
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            if (empty($this->request->data['cover_image']['name'])) {
                unset($this->request->data['cover_image']);
            }
            if (empty($this->request->data['password']) || empty($this->request->data['confirm_password'])) {
                unset($this->request->data['password']);
                unset($this->request->data['confirm_password']);
            }
//            pr($this->request->data);die;
        }
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data['password'] = '';
        });
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

    public function view($slug) {
        $this->Crud->action()->disable();
        $user = $this->Users->find('all', [
                    'conditions' => ['Users.slug' => $slug,'Users.role_id' => 2],
                    'contain' =>
                    [
                        'Countries' => ['fields' => ['Countries.name']]
                    ]
                        ]
                )->first();

        if (empty($user)) {
            return $this->redirect(['action' => 'index']);
        }
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
            
            $userEntity = $this->Users->patchEntity($user, $this->request->data, ['validate'=>false]);
            if ($this->Users->save($userEntity)) {
                $this->Flash->success(__('Author has been updated successfully.'));
                return $this->redirect(['action' => 'view', $slug]);
            }
            $this->Flash->error(__('Unable to update your profile.'));
        }
        $user->dob = date('d/m/Y', strtotime($user->dob));
        $countries = $this->{$this->modelClass}->Countries->find('list');

        $this->loadModel('Blogs');
        $blogs = $this->Blogs->find('all', ['conditions' => ['user_id' => $user->id],'contain' => ['Categories' => ['fields' => array('Categories.title')]]]);

        $this->loadModel('Events');
        $events = $this->Events->find('all', ['conditions' => ['user_id' => $user->id]]);
        
        $this->Set(['countries' => $countries, 'user' => $user, 'blogs' => $blogs, 'events' => $events]);

        $this->set(['user' => $user]);
    }

}
