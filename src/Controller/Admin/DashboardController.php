<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class DashboardController extends AppController {

    public function index() {
        $this->loadModel('Blogs');
        $blogs = $this->Blogs->find('all')->count();
        
        $this->loadModel('Users');
        $users = $this->Users->find('all')->count();
        
        $this->loadModel('Events');
        $events = $this->Events->find('all')->count();
        
        $this->loadModel('Orders');
        $orders = $this->Orders->find('all')->count();
        
        $this->set(compact('blogs','users','events','orders'));
        
    }

}
