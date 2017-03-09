<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;

class ContactQueriesTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->searchManager()
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'mode' => 'or',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => [$this->aliasField('name'),$this->aliasField('email'),$this->aliasField('subject')]
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('name')
                ->requirePresence('email')
                ->requirePresence('subject')
                ->requirePresence('message')
                ->notEmpty('title', 'Please fill this field')
                ->add('title', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Title cannot be too long.'
                    ]
                ])
                ->add('email', [
                    'validFormat' => [
                        'rule' => 'email',
                        'message' => 'Email must be valid'
                    ]
        ]);

        return $validator;
    }

}
