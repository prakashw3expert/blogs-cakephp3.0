<?php

namespace App\Controller\Author;

use App\Controller\Author\AppController;

class BlogsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
        
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['fields'] = ['Blogs.id', 'Blogs.title', 'Blogs.image', 'Blogs.created', 'Blogs.status', 'Blogs.featured', 'Blogs.promoted'];
            $this->paginate['order'] = ['Blogs.id' => 'DESC'];
            $this->paginate['contain'] = ['Categories' => ['fields' => array('Categories.title')]];
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
            if (empty($this->request->data['parent_id'])) {
                $this->request->data['parent_id'] = 0;
            }
            $this->request->data['user_id'] = $this->loggedIn['id'];
            
        }
       
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->Categories->find('Tree');
            $this->Set('categories', $categories);
        });
        if (empty($this->request->data)) {
            $this->request->data['featured'] = 0;
            $this->request->data['promoted'] = 0;
        }
        return $this->Crud->execute();
    }

    public function edit($id) {
        if (!empty($this->request->data)) {
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            
        }
        //pr($this->request->data);die;
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->Categories->find('Tree');
            $this->Set('categories', $categories);
        });
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }
    
    public function jsonData() {
        $query = $this->Blogs->find();
        $allData = $query->select([
                    'count' => $query->func()->count('id'),
                    'created' => 'DATE(created)'
                ])
                ->group('DATE(created)')
                ->where('status = 1');


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
