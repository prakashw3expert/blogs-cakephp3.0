<?php

namespace App\Controller;

use App\Controller\AppController;

class AuthorsController extends AppController {

    public $modelClass = 'Users';

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
        $this->Auth->allow(['index','view']);
    }

    public function index() {
        
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['is_admin'] = 0;
            $this->paginate['conditions']['role_id'] = 2;
            $this->paginate['order'] = array('Users.blog_count DESC');
            $this->paginate['fields'] = ['Users.id', 'Users.name', 'Users.image', 'Users.cover_image', 'Users.facebook_url', 'Users.twitter_url', 'Users.google_plus_url', 'Users.linkedIn_url', 'Users.youtube_url','Users.pinterest_url','Users.designation','Users.slug'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function view($slug) {
        $user = $this->Users->find('slug', ['slug' => $slug]);
        //pr($user);die;
        if (empty($user)) {
            throw new NotFoundException('404 error.');
        }
        $this->loadModel('Blogs');

        $conditions[] = ['Blogs.status' => 1,'Blogs.user_id' => $user['id']];
        
        $this->paginate['fields'] = ['Blogs.id', 'Blogs.title', 'Blogs.slug', 'Blogs.image', 'Blogs.created', 'Blogs.status', 'Blogs.view_count', 'Categories.slug'];
        $this->paginate['order'] = ['Blogs.id' => 'DESC'];
        $this->paginate['limit'] = 27;
        $this->paginate['contain'] = ['Categories' => ['fields' => array('Categories.title')]];
        $this->paginate['conditions'] = $conditions;
        
        $blogs = $this->paginate($this->Blogs);
        
        $this->Set(['user' => $user,'blogs' => $blogs]);
    }

    

}
