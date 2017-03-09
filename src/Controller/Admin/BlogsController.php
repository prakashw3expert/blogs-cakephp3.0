<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class BlogsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
        
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['fields'] = ['Blogs.id', 'Blogs.title', 'Blogs.image', 'Blogs.created', 'Blogs.status', 'Blogs.featured', 'Blogs.promoted', 'Blogs.view_count'];
            $this->paginate['order'] = ['Blogs.id' => 'DESC'];
            $this->paginate['contain'] = ['Categories' => ['fields' => array('Categories.title')],'Users' => ['fields' => ['id','name','slug']]];
            $this->paginate['conditions'] = ['Blogs.draft' => 0];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
            $categories = $this->{$this->modelClass}->Categories->find('Tree');
            $this->Set('categories', $categories);
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
            $this->request->data['draft'] = 0;
        }
       
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->Categories->find('Tree');
            $this->Set('categories', $categories);
        });
        if (empty($this->request->data)) {
            $this->request->data['featured'] = 0;
            $this->request->data['promoted'] = 0;
            $this->request->data['draft'] = 0;
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

    public function chaneStatus(){
         $status = true;
        if($this->request->is('post')){
            $id = $this->request->data['id'];
            $value = $this->request->data['value'];
            $query = $this->Blogs->find();
            $query->select(['Blogs.id','Blogs.title','Blogs.slug','Blogs.id','Users.name','Users.email','Blogs.description','Blogs.status']);
            $query->contain(['Users']);
            $query->group(['Users.id']);
            $event = $query->where(['Blogs.id' => $id]);//,'Events.status' => $value
            if($event->count() > 0 ){
                $event = $event->first();
                $entry = $this->Blogs->newEntity();
                $statusData['status'] = $value;
                $statusData['id'] = $id;
                $statusEntity = $this->Blogs->patchEntity($entry, $statusData,['validate' => false]);
                $updated = $this->Blogs->save($statusEntity);

                if ($updated && $value == 1 && !empty($event['user'])) {
                    /// Send email notification to event owner for notify event activation.
                    $status = true;

                    $template = 'blog-approved';

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
