<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class MagazinesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Crud->addListener('Crud.Search');
        $this->Auth->allow(['index', 'view1']);
    }

    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            //$this->paginate['fields'] = ['Events.id', 'Blogs.title', 'Blogs.created', 'Blogs.status'];
            $this->paginate['order'] = ['Events.id' => 'DESC'];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    public function view($slug) {
        $magazine = $this->{$this->modelClass}->find('slug', ['slug' => $slug]);
        $this->Set(['magazine' => $magazine]);
        if (empty($magazine)) {
            throw new NotFoundException('404 error.');
        }
    }

    public function download($slug) {


        $magazine = $this->{$this->modelClass}->find('slug', ['slug' => $slug]);

        $this->Set(['magazine' => $magazine]);
        if (empty($magazine)) {
            throw new NotFoundException('404 error.');
        }

         $query = $this->{$this->modelClass}->query();
            $result = $query
                    ->update()
                    ->set(
                            $query->newExpr('download_count = download_count + 1')
                    )
                    ->where([
                        'id' => $magazine->id
                    ])
                    ->execute();


        $file_path = WWW_ROOT . 'files' . DS . 'Magazines' . DS . 'pdf_file' . DS . $magazine['pdf_file'];
        $this->response->file($file_path, array(
            'download' => true,
            'name' => $magazine['title'],
        ));
        return $this->response;
    }

    public function deleteImg($id) {
        $entity = $this->Events->EventImages->get($id);
        $result = $this->Events->EventImages->delete($entity);
        if ($result) {
            $this->Flash->success(__('Gallery image has been removed successfully.'));
        } else {
            $this->Flash->error(__('Unable to remove image.'));
        }

        return $this->redirect($this->referer());
    }

    public function jsonData() {
        $query = $this->Events->find();
        $allData = $query->select([
                    'count' => $query->func()->count('id'),
                    'created' => 'DATE(created)'
                ])
                ->group('DATE(created)')
                ->where('status = 1');



        foreach ($allData as $data) {
            $result[] = array(
                'date' => date('Y-m-d', strtotime($data['created'])),
                'value' => $data['count']
            );
        }

        echo json_encode($result);
        exit;
    }

}
