<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;

class ContactsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Slug.Slug');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('title')
                ->notEmpty('title', 'Please fill this field')
                ->add('title', [
                    'minLength' => [
                        'rule' => ['minLength', 2],
                        'last' => true,
                        'message' => 'Comments must have a substantial body.'
                    ],
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Title cannot be too long.'
                    ]
                ])
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
            'message' => 'This is already used.'
        ]);


        return $rules;
    }

    public function findslug($query, $slug) {
        $result = $this->find('all', ['conditions' => ['Pages.slug' => $slug['slug']]]);
        if ($result->count() > 0) {
            return $result->first()->toArray();
        }
        return null;
    }

}
