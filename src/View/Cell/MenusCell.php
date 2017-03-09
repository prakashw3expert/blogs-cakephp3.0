<?php

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Core\Configure;

class MenusCell extends Cell {

    public function display() {
        $menus = Configure::read('Menus');
        $this->set('menus', $menus);
    }

    public function footer() {
        $menus = Configure::read('Menus');
        $this->set('menus', $menus);
    }
    
    public function categories() {
        $menus = Configure::read('Menus');
        $this->set('menus', $menus);
    }

}
