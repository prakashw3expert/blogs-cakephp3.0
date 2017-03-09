<?php

namespace Settings\Controller\Admin;

use Settings\Controller\AppController;

class SettingsController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function edit($id) {
        $this->Crud->action()->view('add');
        return $this->Crud->execute();
    }

}
