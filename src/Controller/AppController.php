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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\Email;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    use \Crud\Controller\ControllerTrait;

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
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginAction' => [
                'plugin' => FALSE,
                'controller' => 'Users',
                'action' => 'login',
            ],
            'flash' => [
                'key' => 'auth',
                'params' => [
                    'class' => 'alert alert-success alert-dismissible'
                ]
            ],
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email'],
                    'finder' => 'authUser'
                ]
            ],
            'storage' => 'Session'
        ]);
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => [
                    'className' => 'Crud.Index',
                ],
                'search' => [
                    'className' => 'Crud.Index',
                ],
                'myEvents' => [
                    'className' => 'Crud.Index',
                ],
                'myBlogs' => [
                    'className' => 'Crud.Index',
                ],
                'add' => [
                    'className' => 'Crud.Add',
                    'messages' => [
                        'success' => [
                            'text' => '{name} has been created successfully.',
                            'params' => ['class' => 'alert alert-success alert-dismissible']
                        ],
                        'error' => [
                            'text' => 'Could not create {name}',
                            'params' => ['class' => 'alert alert-danger alert-dismissible']
                        ]
                    ],
                ],
                'edit' => [
                    'className' => 'Crud.Edit',
                    'messages' => [
                        'success' => [
                            'text' => '{name} has been updated successfully.',
                            'params' => ['class' => 'alert alert-success alert-dismissible']
                        ],
                        'error' => [
                            'text' => 'Could not updated {name}',
                            'params' => ['class' => 'alert alert-danger alert-dismissible']
                        ]
                    ],
                ],
                'delete' => [
                    'className' => 'Crud.Delete',
                    'messages' => [
                        'success' => [
                            'text' => '{name} has been deleted successfully.',
                            'params' => ['class' => 'alert alert-success alert-dismissible']
                        ],
                        'error' => [
                            'text' => 'Could not deleted {name}',
                            'params' => ['class' => 'alert alert-danger alert-dismissible']
                        ]
                    ],
                ],
                'view' => [
                    'className' => 'Crud.View',
                ],
            ]
        ]);
        
        $session = $this->request->session();
        $this->loggedInAs = $session->read('Auth.User');
       
        
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->set('modelClass', $this->modelClass);
        $categories = Configure::read('Categories');
        $nomeCategories = Configure::read('HomeCategories');

        
        $this->set(['loggedInAs' => $this->loggedInAs]);
        $this->set(['params' => $this->request->params]);
        $this->set(['title' => $this->modelClass, 'allCategories' => $categories, 'nomeCategories' => $nomeCategories]);
    }

    public function getCategoryAttr($attr) {
        if (!empty($this->request->params['category'])) {
            $category = json_decode(Configure::read('Categories')[$this->request->params['category']]);
            return $category->$attr;
        }
    }

    public function categoryData() {
        if (!empty($this->request->params['category'])) {
            $category = json_decode(Configure::read('Categories')[$this->request->params['category']]);
            return $category;
        }
    }

    public function send_mail($to, $template, $replace = NULL, $from = NULL) {
        $replace[] = '<img src="' . Configure::read('Site.Logo') . '" alt="' . Configure::read('Site.name') . '">';
        $replace[] = Configure::read('Site.copyright');
        $replace[] = Configure::read('Site.Website');

        if ($template) {
            // get email template
            $this->loadModel('EmailTemplates');
            $emailtemplate = $this->EmailTemplates->find('all', array('fields' => array('EmailTemplates.subject', 'EmailTemplates.from', 'EmailTemplates.message', 'EmailTemplates.fields'), 'conditions' => array('EmailTemplates.slug' => $template)))->first()->toArray();
            if ($emailtemplate) {
                if (!$from) {
                    $from = $emailtemplate['from'];
                }
                $find = explode(',', $emailtemplate['fields']);
                
                $sub = str_replace($find, $replace, $emailtemplate['subject']);

                $template = str_replace($find, $replace, $emailtemplate['message']);
                
                $email = new Email('mailgun');
                $email->from(array($from => Configure::read('Site.name')));
                $email->to($to);
                $email->emailFormat('html');
                $email->subject(($sub) ? $sub : $emailtemplate['subject']);

                if ($email->send($template)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function authenticateBlock($role, $actionsList) {

        $session = $this->request->session();
        $loggedInAs = $session->read('Auth.User');
        
        if ($loggedInAs['role']['alias'] == 'user') {
            $action = strtolower($this->request->params['action']);
            
            if (in_array($action, $actionsList)) {
                $this->Flash->success(__('You are not allowed to access.'));
                return $this->redirect(['controller' => 'users', 'action' => 'view']);
            }
        }
    }

}
