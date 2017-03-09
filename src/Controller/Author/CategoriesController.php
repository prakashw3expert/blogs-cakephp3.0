<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class CategoriesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
    }

    public function index($parentId = null) {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $parent_id = 0;
            if (!empty($this->request->params['pass'][0])) {
                $parent_id = $this->request->params['pass'][0];
            }
            $this->paginate['conditions'] = ['Categories.parent_id' => $parent_id];

            $this->set('parent_id', $parent_id);
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function add() {
        if (empty($this->request->data['parent_id'])) {
                $this->request->data['parent_id'] = 0;
            }
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
        $this->Crud->on('beforeSave', function(\Cake\Event\Event $event) {
            
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->find('parent');
            $this->Set('categories', $categories);
        });

        return $this->Crud->execute();
    }

    public function edit($id) {
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->find('parent');
            $this->Set('categories', $categories);
        });
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

}
