<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\Event\Event;
use ArrayObject;
use Cake\I18n\Time;

class EventTicketsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Events');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('name')
                ->notEmpty('name', __('You need to provide a ticket name.'))
                ->add('name', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Ticket Name cannot be longer than 200 characters.'
                    ]
                ])
                ->requirePresence('quantity')
                ->notEmpty('quantity', __('You need to provide ticket quantity available.'))
                ->notEmpty('type', __('You need to select a Ticket Type.'))
                ->notEmpty('price', __('You neet to enter ticket price.'))
                ->notEmpty('sale_chanel', __('You need to select a Sales channel.'))
                ->notEmpty('sale_start_date', __('You need to select sales start date.'))
                ->notEmpty('sale_end_date', __('You need to select sales end date.'))
                ->notEmpty('start_time', __('You need to select sales start time.'))
                ->notEmpty('end_time', __('You need to select sales end time.'))
                ->add('min_order_count', 'comparison', [
                    'rule' => function ($value, $context) {
                        return intval($value) <= intval($context['data']['quantity']) ;
                    },
                    'message' => 'Minimum order is not greater than quantity available.'
                ])
                ->add('max_order_count', 'comparison', [
                    'rule' => function ($value, $context) {
                        return intval($value) <= intval($context['data']['quantity']) ;
                    },
                    'message' => 'Maximum order is not greater than quantity available.'
                ])
                ->add('sale_end_date', 'validateEnds', [
                    'rule' => function ($value, $context) {
                        if (!empty($context['data']['sale_start_date']) && !empty($context['data']['sale_end_date'])) {
                            $startDate = Time::createFromFormat('d/m/Y', $context['data']['sale_start_date']);
                            $startDate = $startDate->format('Y-m-d');

                            $endDate = Time::createFromFormat('d/m/Y', $context['data']['sale_end_date']);
                            $endDate = $endDate->format('Y-m-d');
                            if (strtotime($startDate . ' ' . $context['data']['start_time']) >= strtotime($endDate . ' ' . $context['data']['end_time'])) {
                                return false;
                            }
                        }
                        return true;
                    },
                    'message' => __('Sales End date & time should be greater than sales start date & time.')
                ])
                ->notEmpty('type', __('You need to select ticket type.'))
                ->notEmpty('min_order_count', __('You need to input ticket min order count.'))
                ->notEmpty('max_order_count', __('You need to input ticket max order count.'));


        return $validator;
    }

    public function beforeSave($event, $entity, $options) {
        if ($entity->sale_start_date) {
            $date = Time::createFromFormat('d/m/Y', $entity->sale_start_date);
            $entity->sale_start_date = $date->format('Y-m-d');
            $entity->sale_start_date = $entity->sale_start_date.' '.$entity->start_time;
        }
        if ($entity->sale_end_date) {
            $date = Time::createFromFormat('d/m/Y', $entity->sale_end_date);
            $entity->sale_end_date = $date->format('Y-m-d');
            $entity->sale_end_date = $entity->sale_end_date.' '.$entity->end_time;
        }
    }

}
