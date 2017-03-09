<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

class BlogsController extends AppController {

    public $draft = 0;
    public function initialize() {

        parent::initialize();

        $this->authenticateBlock('user',['myblogs','add','edit','delete']);
        $this->Auth->allow(['index', 'view']);
    }

    public function index($category = null) {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $conditions[] = ['Blogs.status' => 1];
            if (!empty($this->request->params['category'])) {
                $conditions[] = ['OR' => ['Categories.id' => $this->getCategoryAttr('id'), 'Categories.parent_id' => $this->getCategoryAttr('id')]];
            }

            if (!empty($this->request->params['tag'])) {
                $conditions[] = ['Blogs.tags like ' => "%".$this->request->params['tag'].'%'];
            }

            $this->paginate['fields'] = ['Blogs.id', 'Blogs.title', 'Blogs.slug', 'Blogs.image', 'Blogs.created', 'Blogs.status', 'Blogs.view_count', 'Categories.slug','Categories.title',
            'Categories.slug','Parent.title','Parent.slug'];
            $this->paginate['order'] = ['Blogs.id' => 'DESC'];
            $this->paginate['limit'] = 27;
            $this->paginate['contain'] = ['Categories' => ['fields' => array('Categories.title')],'Categories.Parent'];
            $this->paginate['conditions'] = $conditions;
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });
        $this->Set(['category' => $this->getCategoryAttr('title')]);
        $this->Set(['categoryData' => $this->categoryData('title')]);

        return $this->Crud->execute();
    }

    public function view() {
        if(!empty($this->request->params['category'])){
            $category = $this->request->params['category'];
        }
        if(!empty($this->request->params['parent'])){
            $parent = $this->request->params['parent'];
        }
        if(!empty($this->request->params['slug'])){
            $slug = $this->request->params['slug'];
        }
        $blog = $this->Blogs->find('slug', ['category' => $category, 'slug' => $slug]);

        $this->Set(['blog' => $blog]);
        if (empty($blog)) {
            throw new NotFoundException('404 error.');
        }

        $ipAddress = $this->request->clientIp();
        if($this->viewUpdate($blog->id, $this->loggedInAs['id'],$ipAddress)){
            $blog->view_count += 1;
        }

    }

    public function viewUpdate($blogId, $userId, $ipAddress) {
        $this->loadModel('BlogsViews');
        $session = $this->request->session();
        if($session->check('BlogView_'.$blogId)){
            return false;
        }
        $conditions = ['BlogsViews.blog_id' => $blogId];
        if ($userId) {
            $conditions[] = ['BlogsViews.user_id' => $userId];
        } else {
            $conditions[] = ['BlogsViews.ip_address' => $ipAddress];
        }
        $isLiked = $this->BlogsViews->find('all', ['conditions' => $conditions])->count();

        if ($isLiked > 0) {
            return false;
        }

        $entry = $this->BlogsViews->newEntity();
        $likedData['user_id'] = $userId;
        $likedData['blog_id'] = $blogId;
        $likedData['ip_address'] = $ipAddress;
        $likedData['created'] = date('Y-m-d H:i:s');

        $entry->user_id = $userId;
        $entry->blog_id = $blogId;
        $entry->ip_address = $ipAddress;
        $entry->created = date('Y-m-d H:i:s');

        $userEntity = $this->BlogsViews->patchEntity($entry, $likedData);

        if ($this->BlogsViews->save($userEntity)) {

            $query = $this->Blogs->query();
            $result = $query
            ->update()
            ->set(
                $query->newExpr('view_count = view_count + 1')
                )
            ->where([
                'id' => $blogId
                ])
            ->execute();

            $session->write('BlogView_'.$blogId,1);
            return true;
        }
    }

    public function myBlogs() {
        $this->viewBuilder()->layout('profile');
        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['fields'] = ['Blogs.id', 'Blogs.title','Blogs.slug', 'Blogs.image', 'Blogs.created', 'Blogs.status', 'Blogs.featured', 'Blogs.promoted','Blogs.view_count', 'Categories.id',
                'Categories.title',
                'Categories.slug',
                'Parent.title',
                'Parent.slug'];
            $this->paginate['order'] = ['Blogs.id' => 'DESC'];
            $this->paginate['contain'] = ['Categories','Categories.Parent'];
            $session = $this->request->session();
            $loggedInAs = $session->read('Auth.User');

            $this->paginate['conditions'] = ['Blogs.user_id' => $loggedInAs['id'],'Blogs.draft' => 0];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function add() {
        $this->Crud->action()->disable();
        $this->viewBuilder()->layout('profile');

        $session = $this->request->session();
        $this->loggedIn = $session->read('Auth.User');

        $draftBlog = $this->Blogs->find("all", ['conditions' => ['Blogs.user_id' => $this->loggedIn['id'], 'Blogs.draft' => 1]]);
        //print_r($draftBlog);die;
        if (!$draftBlog->count()) {
            $article = $this->Blogs->newEntity();
            $article->user_id = $this->loggedIn['id'];
            if ($this->Blogs->save($article)) {
                // The $article entity contains the id now
                $id = $article->id;
            }
        } else {
            $article = $draftBlog->first();
            $id = $article->id;
        }

        $this->redirect(['action' => 'edit', $id]);
    }

    public function edit($id) {
        $this->viewBuilder()->layout('profile');
        if (!empty($this->request->data)) {
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
        }


        $this->Crud->on('beforeSave', function(\Cake\Event\Event $event) {
            $this->draft = $event->subject()->entity->draft;
            if($event->subject()->entity->draft){
                $event->subject()->entity->draft = 0;
                $event->subject()->entity->status = 0;
            }
        });

        $this->Crud->on('beforeFind', function(\Cake\Event\Event $event) {
            $session = $this->request->session();
            $this->loggedIn = $session->read('Auth.User');
            $event->subject()->query->where(['user_id' => $this->loggedIn['id']]);
        });

        //pr($this->request->data);die;
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $categories = $this->{$this->modelClass}->Categories->find('Tree');
            $this->Set('categories', $categories);
        });
        $this->Crud->on('afterSave', function(\Cake\Event\Event $event) {

            if ($event->subject()->success) {
                $article = $event->subject()->entity;
                if($this->draft){
                    $template = 'blog-add';

                    $link = \Cake\Routing\Router::url(['controller' => 'blogs', 'action' => 'myBlogs'], true);

                    $details = substr(strip_tags($article->description),0,150);

                    $replace = array($this->loggedIn['name'], $article->title, $details,$link);

                    $this->send_mail($this->loggedIn['email'], $template, $replace);
                }
                $this->redirect(['action' => 'myBlogs']);
            }

        });

        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

    public function edit1($id) {
        $this->Crud->action()->disable();
        $this->viewBuilder()->layout('profile');
        $blog = $this->{$this->modelClass}->find('all', [
            'conditions' => [$this->modelClass . '.user_id' => $this->loggedIn['id'], $this->modelClass . '.id' => $id],
            'contain' => ['Categories']
            ]
            )->first();

        if (empty($blog)) {
            $this->redirect(['action' => 'myBlogs']);
        }

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['status'] = 0;

            unset($this->request->data['image']);
            if ($blog['draft'] == 1) {
                $this->request->data['draft'] = 0;
            }
            $userEntity = $this->Blogs->patchEntity($blog, $this->request->data);
            if ($result = $this->Blogs->save($userEntity)) {

                if ($blog['draft'] == 1) {
                    $template = 'blog-add';

                    $link = \Cake\Routing\Router::url(['controller' => 'blogs', 'action' => 'viewDetails', 'slug' => $article], true);

                    $details = substr(strip_tags($article->description),0,150);

                    $replace = array($this->loggedIn['name'], $article->title,$link, $details);

                    $this->send_mail($this->loggedIn['email'], $template, $replace);
                }
                $this->Flash->success(__('Blogs has been updated Successfully.'));
                $this->Flash->set('The user has been saved.', [
                    'element' => 'success'
                    ]);

                $this->redirect(['controller'=>'events','action' => 'myEvents']);
            }
            else {
                $this->Flash->error(__('Unable to update your blog.'));
            }
        }
        $categories = $this->{$this->modelClass}->Categories->find('Tree');
        $blog['parent_id'] = (!empty($blog['category']['parent_id'])) ? $blog['category']['parent_id'] : 0;
        $this->set(compact(['categories', 'blog']));
        $this->render('add');
    }

    public function viewDetails($slug) {
        $event = $this->Events->find('slug', ['slug' => $slug]);

        if (empty($event)) {
            return $this->redirect(['action' => 'myEvents']);
        }

        $event['start_time'] = date('h:i', strtotime($event['start_time']));
        $event['end_time'] = date('h:i', strtotime($event['end_time']));
        $event['start_date'] = date('d/m/Y', strtotime($event['start_date']));
        $event['end_date'] = date('d/m/Y', strtotime($event['end_date']));

        $session = $this->request->session();

        if ($session->check('EventImages.error')) {
            $this->Flash->set(__($session->read('EventImages.error')), [
                'params' => ['class' => 'alert alert-success alert-dismissible']
                ]);
            $session->delete('EventImages.error');
        }

        if (!empty($this->request->data) && isset($_POST['gallery'])) {
            $eventImages = TableRegistry::get('EventImages');

            //$eventImages = $eventImages->newEntity();
            $message = null;
            foreach ($this->request->data['image'] as $key => $value) {
                $data['image'] = $value;
                $data['event_id'] = $event['id'];
                $entities = $eventImages->newEntity($data, [ 'validate' => true]);
                //$entities->clean();

                if (!$result = $eventImages->save($entities)) {
                    $error = $entities->errors('image');
                    $message = $error[key($error)];
                }
            }
            if (!$message) {
                $message = 'Gallery image uploaded successfully.';
            }
            $session->write('EventImages.error', $message);
            return $this->redirect(['action' => 'viewDetails', 'slug' => $slug]);
        }


        if (!empty($this->request->data) && isset($_POST['update'])) {
            if (empty($this->request->data['image']['name'])) {
                unset($this->request->data['image']);
            }
            //$this->Events->geoLocation($this->request->data);
            $userEntity = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($userEntity)) {
                $this->Flash->success(__('Event has been updated successfully.'));
                return $this->redirect(['action' => 'view', 'slug' => $slug]);
            }
            $this->Flash->error(__('Unable to update your event.'));
        }

        $this->viewBuilder()->layout('profile');
        $countries = $this->{$this->modelClass}->Countries->find('list');
        $this->Set(['countries' => $countries, 'event' => $event]);
    }

    public function uploadImage($id) {
        $session = $this->request->session();
        $this->loggedIn = $session->read('Auth.User');


        $blog = $this->{$this->modelClass}->find('all', [
            'fields' => ['Blogs.id'],
            'conditions' => [$this->modelClass . '.user_id' => $this->loggedIn['id'], $this->modelClass . '.id' => $id],
            ]
            )->first();


        if ($this->request->is(['post', 'put'])) {
            $data['image'] = $_FILES['image'];
            //$userEntity = $this->Blogs->patchEntity($blog, $this->request->data,['validate' => 'image']);
            $userEntity = $this->Blogs->patchEntity($blog, $data, ['validate' => 'image']);
            if ($result = $this->Blogs->save($userEntity)) {

            }

        }
        echo json_encode(array('status' => true));
        exit;
    }

    public function delete($id) {

        $this->Crud->on('beforeFind', function(\Cake\Event\Event $event) {
            $event->subject()->query->where(['user_id' => $this->Auth->user('id')]);
        });
        $this->Crud->on('afterDelete', function(\Cake\Event\Event $event) {
            $this->redirect(['action' => 'myBlogs']);
        });
        return $this->Crud->execute();
    }

}
