<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

class AjaxController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['same']);
    }

    public function saveimage() {

        $this->loadModel('Attachments');

        $entity = $this->Attachments->newEntity();
        $dataEntity = $this->Attachments->patchEntity($entity, $this->request->data);

        $response = array('status' => false);
        if ($data = $this->Attachments->save($dataEntity)) {
            
            $response['url'] = $this->request->webroot . 'uploads/' . $dataEntity['image'];
            $response['file'] = $dataEntity['image'];
            $response['status'] = true;
        }

        echo json_encode($response);
        exit;
    }

}
