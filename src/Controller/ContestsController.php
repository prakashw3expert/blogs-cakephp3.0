<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ContestsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->Crud->addListener('Crud.Search');
        $this->Auth->allow(['index', 'view', 'enteries', 'entry']);
    }

    public function index() {
        $this->viewBuilder()->layout('event');
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            //$this->paginate['fields'] = ['Events.id', 'Blogs.title', 'Blogs.created', 'Blogs.status'];
            $this->paginate['order'] = ['Events.id' => 'DESC'];
            $this->paginate['contain'] = ['Users',
                'ContestParticipates' => [
                    'fields' => [
                        'ContestParticipates.id',
                        'ContestParticipates.contest_id',
                        'ContestParticipates.likes',
                        'ContestParticipates.image'
                    ],
                    'sort' => ['ContestParticipates.likes' => 'DESC'],
                    'conditions' => function ($e, $query) {
                $query->limit(3);
                return [];
            }
                ]
            ];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function add() {
        //pr($this->request->data);die;
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }

        $this->request->data['user_id'] = $this->loggedInAs['id'];

        return $this->Crud->execute();
    }

    public function edit($id) {
        if (empty($this->request->data['image']['name'])) {
            unset($this->request->data['image']);
        }

        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

    public function view($slug) {

        $this->Crud->action()->disable();
        $contest = $this->Contests->find('slug', ['slug' => $slug]);

        if (empty($contest)) {
            return $this->redirect(['action' => 'index']);
        }

        $this->Set([ 'contest' => $contest]);
    }

    public function enteries($slug) {
        $this->viewBuilder()->layout('event');
        $contest = $this->Contests->find('slug', ['slug' => $slug]);

        if (empty($contest)) {
            return $this->redirect(['action' => 'index']);
        }
        $this->loadModel('ContestParticipates');
        $contain = ['Contests' => ['fields' => ['title', 'slug']]];
        $contain['ContestParticipatesUsers'] = ['conditions' => ['ContestParticipatesUsers.user_id' => $this->loggedInAs['id']], 'fields' => ['ContestParticipatesUsers.id', 'ContestParticipatesUsers.contest_participate_id']];
        $config = [
            'contain' => $contain,
            'conditions' => [
                'ContestParticipates.contest_id' => $contest->id
            ]
        ];

        $entries = $this->Paginator->paginate($this->ContestParticipates, $config);

//pr($entries);die;
        $this->set(compact('contest', 'entries'));
    }

    public function entry($slug, $entry) {
        $this->viewBuilder()->layout('event');
        $this->loadModel('ContestParticipates');
        $contestEntry = $this->ContestParticipates->find('slug', ['slug' => $entry, 'user_id' => $this->loggedInAs['id']]);

        if (empty($contestEntry)) {
            return $this->redirect(['action' => 'index']);
        }


        $this->set(compact(['contestEntry']));
    }

    public function participate($slug) {
        $this->viewBuilder()->layout('home');
        $contest = $this->Contests->find('slug', ['slug' => $slug]);
        $this->loadModel('ContestParticipates');

        $ContestParticipates = $this->ContestParticipates->find('all', [
                    'conditions' => [
                        'ContestParticipates.user_id' => $this->loggedInAs['id'],
                        'ContestParticipates.contest_id' => $contest->id],
                        ]
                )->first();

        if (!$ContestParticipates) {
            $ContestParticipates = $this->ContestParticipates->newEntity();
            $ContestParticipates->user_id = $this->loggedInAs['id'];
            $ContestParticipates->contest_id = $contest->id;
        } else {
            if ($ContestParticipates->title != 'default') {
                $this->Flash->set(__('You can participate  one time.'), [
                    'params' => ['class' => 'alert alert-info alert-dismissible']
                ]);
                return $this->redirect(['controller' => 'contests', 'action' => 'entry', 'slug' => $contest->slug, 'entry' => $ContestParticipates->slug]);
            }
        }
        $time = $contest->expiry;
        if ($time->isPast()) {
            $this->Flash->set(__('This contest has been ended.'), [
                'params' => ['class' => 'alert alert-info alert-dismissible']
            ]);
            return $this->redirect(['controller' => 'contests', 'action' => 'entry', 'slug' => $contest->slug, 'entry' => $ContestParticipates->slug]);
        }

        if ($this->request->is(['Post', 'Put'])) {

            if ($ContestParticipates->image && !$this->request->data('isImageRemoved')) {
                unset($this->request->data['image']);
            } else {
                $ContestParticipates->image = null;
            }
            
            $entries = $this->ContestParticipates->patchEntity($ContestParticipates, $this->request->data);
            $entries->contest_id = $contest->id;
            $entries->user_id = $this->loggedInAs['id'];

            if ($result = $this->ContestParticipates->save($entries)) {


                $this->Flash->set(__('Your picture has been submitted successfully.'), [
                    'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);

                return $this->redirect(['controller' => 'contests', 'action' => 'entry', 'slug' => $contest->slug, 'entry' => $entries->slug]);
            }
        } else {
            if ($ContestParticipates->title == 'default') {
                $ContestParticipates->title = '';
            }
        }

        $this->Set(['title_for_layout' => 'Create An Account', 'contest' => $contest, 'ContestParticipates' => $ContestParticipates]);
    }

    public function upload($slug) {
        if ($this->request->is(['post', 'ajax'])) {

            unset($this->request->data['title']);

            $contest = $this->Contests->find('slug', ['slug' => $slug]);
            $this->loadModel('ContestParticipates');

            $entry = $this->ContestParticipates->find('all', [
                        'fields' => ['ContestParticipates.id'],
                        'conditions' => [
                            'ContestParticipates.user_id' => $this->loggedInAs['id'],
                            'ContestParticipates.contest_id' => $contest->id],
                            ]
                    )->first();
            if (!$entry) {
                $entry = $this->ContestParticipates->newEntity();
                $entry->user_id = $this->loggedInAs['id'];
                $entry->contest_id = $contest->id;
            }

            $data['image'] = $this->request->data('image');
            $data['title'] = $this->request->data('title');
            if (!$this->request->data('title')) {
                $data['title'] = 'default';
            }

            $userEntity = $this->ContestParticipates->patchEntity($entry, $data, ['validate' => 'image']);
            if (!$result = $this->ContestParticipates->save($userEntity)) {
                echo json_encode(array('error' => $result));
                exit;
            }
        }
        echo json_encode(array('status' => true));
        exit;
    }

    public function like($slug, $entry) {
        $this->loadModel('ContestParticipates');
        $contestEntry = $this->ContestParticipates->find('slug', ['slug' => $entry]);

        if (empty($contestEntry)) {
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('ContestParticipatesUsers');
        $isLiked = $this->ContestParticipatesUsers->find('all', ['conditions' => ['ContestParticipatesUsers.user_id' => $this->loggedInAs['id'], 'ContestParticipatesUsers.contest_id' => $contestEntry->contest_id]])->count();

        if ($isLiked > 0) {
            $this->Flash->set(__('You can like one entry in one Contests.'), [
                'params' => ['class' => 'alert alert-info alert-dismissible']
            ]);
            return $this->redirect($this->referer());
        }

        $entry = $this->ContestParticipatesUsers->newEntity();
        $likedData['user_id'] = $this->loggedInAs['id'];
        $likedData['contest_id'] = $contestEntry->contest->id;
        $likedData['contest_participate_id'] = $contestEntry->id;

        $entry->user_id = $this->loggedInAs['id'];
        $entry->contest_id = $contestEntry->contest->id;
        $entry->contest_participate_id = $contestEntry->id;

        $userEntity = $this->ContestParticipatesUsers->patchEntity($entry, $likedData);

        if ($this->ContestParticipatesUsers->save($userEntity)) {

            $query = $this->ContestParticipates->query();
            $result = $query
                    ->update()
                    ->set(
                            $query->newExpr('likes = likes + 1')
                    )
                    ->where([
                        'id' => $contestEntry->id
                    ])
                    ->execute();
            $this->Flash->set(__('You have liked successfully.'), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
            ]);
        }
        return $this->redirect($this->referer());
    }

}
