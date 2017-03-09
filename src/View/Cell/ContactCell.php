<?php

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

class ContactCell extends Cell {

    public function display($date) {
        $articles = TableRegistry::get('ContactQueries');
//         date('Y-m-d',  strtotime('+8 DAYS'))
        $query = $articles->find()
                ->where(['DATE(created) >=' => date('Y-m-d', strtotime($date)), 'DATE(created) <=' => date('Y-m-d')]);
        $count = $query->count();
        $this->set('count', $count);
    }

}
