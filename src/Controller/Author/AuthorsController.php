<?php

namespace App\Controller\Author;

use App\Controller\Author\AppController;
use Cake\Auth\DefaultPasswordHasher;

class AuthorsController extends AppController {

    public $modelClass = 'Users';

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['is_admin'] = 0;
            $this->paginate['conditions']['role_id'] = 2;
            $this->paginate['order'] = array('Users.id DESC');
            $this->paginate['fields'] = ['Users.id', 'Users.name', 'Users.email', 'Users.created', 'Users.is_admin', 'Users.slug', 'Users.image','Users.blog_count'];
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
        }
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

}
