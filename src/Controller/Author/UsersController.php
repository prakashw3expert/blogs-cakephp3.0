<?php

namespace App\Controller\Author;

use App\Controller\Author\AppController;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
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
        $this->render('/Admin/Users/login');
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    

}
