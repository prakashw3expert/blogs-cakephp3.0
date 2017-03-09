<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;


class ContactQueriesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
       
    }
    
    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['order'] = ['ContactQueries.id' => 'DESC'];
            
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }
   

}
