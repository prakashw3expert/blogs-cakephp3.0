<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ContactsController extends AppController {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['display', 'view']);
    }

    public function view($slug) {

        $contacts = $this->Contacts->find('all', ['conditions' => ['slug' => $slug]]);
        if ($contacts->count() > 0) {
            $contacts = $contacts->first()->toArray();
        }
        if (empty($contacts)) {
            throw new NotFoundException('404 error.');
        }

        $contactRequests = TableRegistry::get('ContactQueries');
        $message = $contactRequests->newEntity();
        
        if (!empty($this->request->data)) {
            //pr($this->request->data);die;
            $this->request->data['contact_id'] = $contacts['id'];
            
            $message = $contactRequests->newEntity($this->request->data());
            if ($contactRequests->save($message)) {
                
                //Send Notification to admin via email
                $to = $contacts['email'];
                $template = 'contact-request-admin-amail';
                $replace = $this->request->data;
                $this->send_mail($to, $template, $replace);
                
                
                // Send thank you mail to contacting person
                $to = $this->request->data['email'];
                $template = 'contact-request-user-replay';
                
                $userData[] = $this->request->data['name'];
                $this->send_mail($to, $template, $userData);
                
                $this->Flash->set(__('Successfully Submitted. Someone will be in touch with you shortly.'),[
                    'key' => 'contact',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
                
                $this->redirect(['controller' => 'contacts','action' => 'view',$slug]);
            }
        }
        $this->set(compact('contacts','message'));
    }

}
