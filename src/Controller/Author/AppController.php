<?php

namespace App\Controller\Author;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController {

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
        $this->Auth->__set('sessionKey', 'Auth.Auther');

        $this->Auth->config([
            'loginRedirect' => [
                'controller' => 'blogs',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ],
            'storage' => [
                'className' => 'Session',
                'key' => 'Auth.Author',
            ],
            'authenticate' => [
                'Form' => ['finder' => 'authAuthor']
            ]
        ]);
        
        $this->Crud->mapAction('publishAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'status',
            'value' => 1,
            'messages' => [
                'success' => [
                    'text' => 'Bulk publish successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk publish.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('removePublishdAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'status',
            'value' => 0,
            'messages' => [
                'success' => [
                    'text' => 'Bulk un publish successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk un publish.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('featuredAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'featured',
            'value' => 1,
            'messages' => [
                'success' => [
                    'text' => 'Bulk featured successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk featured.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('removeFeaturedAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'featured',
            'value' => 0,
            'messages' => [
                'success' => [
                    'text' => 'Bulk remove featured successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk remove featured.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('promotedAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'promoted',
            'value' => 1,
            'messages' => [
                'success' => [
                    'text' => 'Bulk promoted successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk promoted.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('removePromotedAll', [
            'className' => 'Crud.Bulk/SetValue',
            'field' => 'promoted',
            'value' => 0,
            'messages' => [
                'success' => [
                    'text' => 'Bulk remove promoted successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk remove promoted.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->Crud->mapAction('deleteAll', [
            'className' => 'Crud.Bulk/Delete',
            'messages' => [
                'success' => [
                    'text' => 'Bulk delete successfully completed.',
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ],
                'error' => [
                    'text' => 'Could not complete bulk delete.',
                    'params' => ['class' => 'alert alert-danger alert-dismissible']
                ]
            ],
        ]);
        
        $this->loggedIn = $this->_getSession();
    }

    public function beforeRender(Event $event) {
        
        $session = $this->request->session();
        $loggedInAs = $session->read('Auth.Admin');
        $this->set(['title' => $this->modelClass]);
        $this->set(['status' => [1=>'Yes','0' => 'No']]);
        $this->set(['loggedInAs' => $loggedInAs]);
        $this->set(['params' => $this->request->params]);
        $this->set(['loggedIn' => $this->loggedIn]);
        parent::beforeRender($event);
    }
    
    private function _getSession(){
        return $this->request->session()->read('Auth.Auther');
    }

}
