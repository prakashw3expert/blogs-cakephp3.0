<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;

class OrdersTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');
        $this->belongsTo('Events');
        $this->belongsTo('EventTickets');

        // Add the behaviour to your table
        $this->addBehavior('Search.Search');
        // Setup search filter using search manager
        $this->searchManager()
                ->value('country_id')
                ->value('gender')
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'mode' => 'or',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => [$this->aliasField('name'), $this->aliasField('email')]
        ]);
    }

    public function validationDefault(Validator $validator) {

        $validator
                ->requirePresence('name')
                ->notEmpty('name', __('You need to provide name.'))
                ->add('name', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Name cannot be longer than 100 characters.'
                    ]
                ])
                ->requirePresence('mobile')
                ->notEmpty('mobile', __('You need to provide mobile number.'))
                ->add('mobile', [
                    'maxLength' => [
                        'rule' => ['maxLength', 15],
                        'message' => 'Nobile cannot be longer than 15 characters.'
                    ]
                ])
                // ->add('mobile', 'validFormat',[
                // 'rule' => array('custom', '/^([0-9])$/i'),
                // 'message' => 'Please enter a valid mobile number.'
                // ])
                ->requirePresence('email')
                ->add('email', [
                    'validFormat' => [
                        'rule' => 'email',
                        'message' => 'Please enter a valid email address.'
                    ]
        ]);


        return $validator;
    }

}
