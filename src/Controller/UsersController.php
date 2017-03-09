<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['add', 'activate', 'forgot', 'resetPassword','resendActivation','subscribe']);
        $this->Crud->addListener('Crud.Search');
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['conditions']['is_admin'] = 0;
            $this->paginate['conditions']['role_id'] = 1;
            $this->paginate['contain'] = ['Countries'];
            $this->paginate['fields'] = ['Users.id', 'Users.name', 'Users.slug', 'Users.email', 'Users.gender', 'Users.dob', 'Users.created', 'Users.is_admin', 'Users.image', 'Countries.name'];
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

        $this->Crud->action()->disable();
        $this->viewBuilder()->layout('home');
        $user = $this->Users->newEntity();
        if ($this->request->is('Post')) {

            // if($this->request->data['signing'] == 0)
            //     $this->request->data['signing'] = '';
            $continue = true;
            if(empty($this->request->data['signing'])){
                $continue = false;
                $this->Flash->set(__('Please tick Terms and Conditions'), [
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                    ]);
            }
            $userEntity = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'register']);
           // $userEntity->role_id = 1;

            if ($continue && $result = $this->Users->save($userEntity)) {
                $userId = $result->id;
                //Send Notification to admin via email
                $to = $this->request->data['email'];
                $template = 'Account-activation';
                $activationCode = md5(microtime() . $userId);
                $now = Time::now();
                $now->modify('+3 days');
                $userEntity->token = $activationCode;
                $userEntity->token_expiry = $now;
                $this->Users->save($userEntity);

                $link = \Cake\Routing\Router::url(['controller' => 'users', 'action' => 'activate', 'code' => $activationCode], true);
                $replace = array($this->request->data['name'], $link);
                $this->send_mail($to, $template, $replace);



                // Send thank you mail to contacting person
                $resendLink = \Cake\Routing\Router::url(['controller' => 'users','action' => 'resendActivation','slug' => $userEntity->slug,'code' => $activationCode],true);
                $resendLink = ' <a href="'.$resendLink.'">'.__('Resend confirmation mail again').'</a>';

                $this->Flash->set(__('RegisterSuccess'). $resendLink, [
                    'params' => [
                    'escape' => false,
                    'class' => 'alert alert-success alert-dismissible'],
                    ['escape' => false]
                    ]);

                return $this->redirect(['action' => 'add']);
            } 

            
        }
        $this->Set(['title_for_layout' => 'Create An Account', 'user' => $user]);
    }

    public function resendActivation($slug, $token){

        $query = $this->Users->find();
        $query = $query->where(['Users.slug' => $slug,'Users.token' => $token]);

        if ($query->count() === 0 ){
            return $this->redirect(array('action' => 'login'));
        }

        $user = $query->first();
        $userId = $user->id;
        $activationCode = md5(microtime() . $user->id);

        $to = $user->email;
        $template = 'Account-activation';
        $activationCode = md5(microtime() . $userId);
        $now = Time::now();
        $now->modify('+3 days');
        $user->token = $activationCode;
        $user->token_expiry = $now;

        $link = \Cake\Routing\Router::url(['controller' => 'users', 'action' => 'activate', 'code' => $activationCode], true);

        if($this->Users->save($user)){

            $replace = array($user->name, $link);
            $this->send_mail($to, $template, $replace);

                 //. $resendLink
            $this->Flash->set(__('Please check your e-mail inbox as your  e-mail confirmation has just been resend.'), [
                'params' => [
                'escape' => false,
                'class' => 'alert alert-success alert-dismissible'],
                ['escape' => false]
                ]);
        }



        return $this->redirect(array('action' => 'login'));

    }

    public function view() {
        $session = $this->request->session();
        $loggedInAs = $session->read('Auth.User');
        $this->viewBuilder()->layout('profile');
        $errors = array();
        $this->Crud->action()->disable();
        $user = $this->Users->find('all', [
            'conditions' => ['Users.id' => $loggedInAs['id']],
            'contain' =>
            [
            'Countries' => ['fields' => ['Countries.name']],
            'Roles'
            ]
            ]
            )->first();
        //print_r($user->name);die;
        if (empty($user)) {
            return $this->redirect(['action' => 'index']);
        }

        $isEdit = 0;
        if (!empty($this->request->data)) {
            $this->request->data['email'] = $user->email;

            $isEdit = 1;

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
            if (empty($this->request->data['password']) && empty($this->request->data['confirm_password'])) {
                unset($this->request->data['password']);
                unset($this->request->data['confirm_password']);
            }
            $user = $this->Users->patchEntity($user, $this->request->data);

            if ($result = $this->Users->save($user)) {

                $uerData = [
                'id' => $result['id'],
                'name' => $result['name'],
                'slug' => $result['slug'],
                'email' => $result['email'],
                'image' => $result['image'],
                'role' => ['id' => $result['role']['id'],'name' => $result['role']['name'],'alias' => $result['role']['alias']],
                ];

                $session->write('Auth.User', $uerData);
                $this->Flash->success(__('User has been updated successfully.'));
                return $this->redirect(['action' => 'view']);
            } else{

                $errors = $user->errors();
                if(!empty($errors['dob']['validateDob'])){
                    $this->Flash->error(__($errors['dob']['validateDob']));
                }
                else{
                    $this->Flash->error(__('Unable to update your profile.'));
                }

                
            }
            
        }
        if ($user->dob) {
            $user->dob = date('d/m/Y', strtotime($user->dob));
        }
        $countries = $this->{$this->modelClass}->Countries->find('list');



        $this->Set(['countries' => $countries, 'user' => $user]);

        $this->set(['user' => $user,'errors' => $errors,'isEdit' => $isEdit]);
    }

    public function login() {
        //echo (new DefaultPasswordHasher)->hash('123456');die;
        $this->viewBuilder()->layout('home');
        $session = $this->request->session();
        if($session->check('Auth.User')){
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        if ($this->request->is('post')) {

            $result = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]])->first();
            if($result && $result->token){

                 // Send thank you mail to contacting person
                $resendLink = \Cake\Routing\Router::url(['controller' => 'users','action' => 'resendActivation','slug' => $result->slug,'code' => $result->token],true);
                $resendLink = ' <a href="'.$resendLink.'">'.__('resend confirmation mail again').'</a>';


                return $this->Flash->error(__('Your account is not activated. We have already sent you a confirmation mail please verify your email id or '.$resendLink), ['params' => ['escape' => false],
                    'key' => 'auth'
                    ]);

            }
            else if($result){
               $user = $this->Auth->identify();
               if($user['role']['id'] == 2) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl(array('controller' => 'users', 'action' => 'view')));
            }
            elseif($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl(['controller' => 'events','action' => 'my_events']));
            } else {
                return $this->Flash->error(__('Email or password is incorrect'), [
                    'key' => 'auth'
                    ]);
            }
        }
        else{
            $this->Flash->error(__('Invalid email address.'), [
                'key' => 'auth'
                ]);
        }
    }
    
}

public function logout() {
    return $this->redirect($this->Auth->logout());
}

public function activate($token) {
    $user = $this->Users->find('all', ['conditions' => ['Users.token' => $token]])->first();

    if ($user) {
        $updateData = $this->Users->newEntity();
        $updateData->status = 1;
        $updateData->id = $user->id;
        $updateData->token = null;
        $updateData->token_expiry = null;
        if ($data = $this->Users->save($updateData)) {
            $this->Flash->set(__('ConfirmationAccount'), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
        }
    } else {
        $this->Flash->set(__('InvalidActCode'), [
            'params' => ['class' => 'alert alert-danger alert-dismissible']
            ]);
    }

    $this->redirect(['action' => 'login']);
}

public function forgot() {
    if ($this->request->is('post')) {

        if (empty($this->request->data['email'])) {
            $this->Flash->set(__('Enter your registered email address.'), [
                'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]);
            return $this->redirect(['action' => 'forgot']);
        }
        $user = $this->Users->find('all', ['conditions' => ['Users.email' => $this->request->data['email']]])->first();

        if (empty($user['id'])) {
         $this->Flash->set(__('EmailDBCheck'), [
            'params' => ['class' => 'alert alert-danger alert-dismissible']
            ]);
         return $this->redirect(array('controller' => 'users', 'action' => 'forgot'));
     } else {
        if (count($user) > 0) {
            $to = $user['email'];
            $template = 'Account-activation';
            $activationCode = md5(microtime() . $user['id']);
            $now = Time::now();
            $now->modify('+3 days');
            $user->token = $activationCode;
            $user->token_expiry = $now;
            $this->Users->save($user);
            $link = \Cake\Routing\Router::url(['controller' => 'users', 'action' => 'resetPassword', 'code' => $activationCode], true);
            $replace = array($user['name'], $link);
            $this->send_mail($to, $template, $replace);

            $this->Flash->set(__('PasswordEmail'), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
        } else {
            $this->Flash->set(__('CommonError'), [
                'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]);
        }
    }
    return $this->redirect(['action' => 'login']);
}
$this->viewBuilder()->layout('home');
}

public function resetPassword($token) {
    $user = $this->Users->find('all', ['conditions' => ['Users.token' => $token]])->first();

    if (!$user) {
        $this->Flash->set(__('CommonError'), [
            'params' => ['class' => 'alert alert-danger alert-dismissible']
            ]);
        return $this->redirect(['action' => 'login']);
    }

    if ($this->request->is(['post', 'put'])) {

        $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'forgotPassword']);
        $user->token = null;
        $user->token_expiry = null;

        if ($this->Users->save($user)) {
            $this->Flash->set(__('PasswordReset'), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
            return $this->redirect(['action' => 'login']);
        }
    } else{
        unset($user->password);
    }

    $this->set(['user' => $user]);
    $this->viewBuilder()->layout('home');
}

public function chagePassword() {
    $user = $this->Users->find('all', ['conditions' => ['Users.id' => $this->loggedInAs['id']]])->first();

    if (!$user) {
        $this->Flash->set(__('CommonError'), [
            'params' => ['class' => 'alert alert-danger alert-dismissible']
            ]);
        return $this->redirect(['action' => 'view']);
    }
    $this->viewBuilder()->layout('profile');
    if ($this->request->is(['post', 'put'])) {

        $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'changePassword']);
        if ($this->Users->save($user)) {
            $this->Flash->set(__('Your password has been changed successfully.'), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
            return $this->redirect(['action' => 'chagePassword']);
        }
    }

    $this->set(['user' => $user]);

}

public function subscribe(){
    $this->loadModel('Subscribers');

    $data = $this->Subscribers->newEntity();
    if ($this->request->is('Post')) {
        $dataEntity = $this->Subscribers->patchEntity($data, $this->request->data);

        if ($this->Subscribers->save($dataEntity)) {
            $status = true;
            $message  = 'You have subscribe successfully for our latest blog, events and news.';
        }
        else{
            $status = false;
            $errors = $dataEntity->errors();
            foreach ($errors['email'] as $key => $value) {
                $message  = $value;
            }
            
        } 


    }
    echo json_encode(array(
        'status' => $status,
        'message' => $message
    ));
    die;
}

}
