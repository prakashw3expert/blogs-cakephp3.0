<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;


class SubscribersTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');

    }


    public function validationDefault(Validator $validator) {
        
        $validator
        ->requirePresence('email')
        ->add('email', [
            'validFormat' => [
            'rule' => 'email',
            'message' => 'E-mail must be valid'
            ]
            ]);

        
        return $validator;
    }

     // In a table class
    public function buildRules(RulesChecker $rules) {

        $rules->add(new isUnique(['email']), 'isUniqueEmail', [
            'errorField' => 'email',
            'message' => 'This email address is already registered in our subscribe list.'
        ]);

        return $rules;
    }

    

}
