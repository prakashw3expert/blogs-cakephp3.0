<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;

class PagesTable extends Table {

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
                ->requirePresence('description')
                ->add('description', 'length', [
                    'rule' => ['minLength', 50],
                    'message' => 'Articles must have a substantial body.'
                ])
                ->add('meta_keyword', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Title cannot be too longer than 150 characters.'
                    ]
                ])
                ->add('meta_keyword', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Keyword cannot be too longer than 150 characters.'
                    ]
                ])
                ->add('meta_description', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Description cannot be too longer than 150 characters.'
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
