<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;

class ContestsTable extends Table {

    public function initialize(array $config) {

        $this->belongsTo('Users');
        $this->hasMany('ContestParticipates');

        $this->addBehavior('Timestamp');
        // Add the behaviour to your table
//        $this->addBehavior('CounterCache', [
//            'Users' => ['event_count']
//        ]);

        $this->addBehavior('Muffin/Slug.Slug', [
            'update' => true
        ]);

        // Setup search filter using search manager
        // Add the behaviour to your table
        $this->addBehavior('Search.Search');
        // Setup search filter using search manager
        $this->searchManager()
                ->value('city')
                ->add('keyword', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'mode' => 'or',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => [$this->aliasField('title'), $this->aliasField('organizer'), $this->aliasField('venue'), $this->aliasField('address'), $this->aliasField('pincode')]
                ])->add('date', 'Search.Callback', [
            'callback' => function ($query, $args, $filter) {
                pr($query);
                die;
                return $q->where(['Events.start_date >= ' => $args['date']]);
            }]);

                $this->addBehavior('Josegonzalez/Upload.Upload', [
                    // You can configure as many upload fields as possible,
                    // where the pattern is `field` => `config`
                    //
            // Keep in mind that while this plugin does not have any limits in terms of
                    // number of files uploaded per request, you should keep this down in order
                    // to decrease the ability of your users to block other requests.

                    'image' => [
                        'keepFilesOnDelete' => false,
                        //'path' => 'webroot{DS}files{DS}{model}{DS}{field-value:unique_id}{DS}',
                        'transformer' => function (\Cake\Datasource\RepositoryInterface $table, \Cake\Datasource\EntityInterface $entity, $data, $field, $settings) {
                            // get the extension from the file
                            // there could be better ways to do this, and it will fail
                            // if the file has no extension
                            $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                            // Store the thumbnail in a temporary file
                            $tmpLarge = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                            $tmpThumbnail = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                            // Use the Imagine library to DO THE THING
                            $size = new \Imagine\Image\Box(260, 150);
                            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                            $imagine = new \Imagine\Gd\Imagine();
                            // Save that modified file to our temp file
                            $imagine->open($data['tmp_name'])
                                    ->thumbnail($size, $mode)
                                    ->save($tmpLarge);


                            // Use the Imagine library to DO THE THING
                            $size = new \Imagine\Image\Box(850, 490);
                            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                            $imagine = new \Imagine\Gd\Imagine();
                            // Save that modified file to our temp file
                            $imagine->open($data['tmp_name'])
                                    ->thumbnail($size, $mode)
                                    ->save($tmpThumbnail);

                            // Now return the original *and* the thumbnail
                            $result = [
                                $data['tmp_name'] => $data['name'],
                                $tmpLarge => 'thumbnail-' . $data['name'],
                                $tmpThumbnail => 'large-' . $data['name'],
                            ];
                            return $result;
                        },
                                'nameCallback' => function($data, $settings) {
                            $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                            return md5(microtime() . '-' . time()) . '-' . time() . '.' . $extension;
                        },
                            ]
                        ]);
                    }

                    public function validationDefault(Validator $validator) {

                        $validator->provider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class);

                        $validator
                                ->requirePresence('title')
                                ->notEmpty('title', __('You need to provide a title.'))
                                ->add('title', [
                                    'maxLength' => [
                                        'rule' => ['maxLength', 100],
                                        'message' => 'Title cannot be longer than 200 characters.'
                                    ]
                                ])
                                ->notEmpty('expiry', __('You should enter ended date.'))
                                ->add('expiry', 'validateEnds', [
                                    'rule' => function ($value, $context) {


                                        if (!empty($context['data']['expiry'])) {
                                            $expiry = Time::createFromFormat('d/m/Y', $context['data']['expiry']);
                                            $expiry = $expiry->format('Y-m-d');

                                           
                                            if (strtotime($expiry) < strtotime(date('Y-m-d'))) {
                                                return false;
                                            }
                                        }
                                        return true;
                                    },
                                    'message' => __('Ended date should future date.')
                        ]);


                        $validator->add('image', 'file', [
                            'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
                            'on' => function ($context) {
                        return !empty($context['data']['image']);
                    }
                        ]);

                        $validator->add('image', 'fileUnderPhpSizeLimit', [
                            'rule' => 'isUnderPhpSizeLimit',
                            'message' => 'This file is too large',
                            'provider' => 'upload'
                        ]);

                        $validator->add('image', 'fileUnderFormSizeLimit', [
                            'rule' => 'isUnderFormSizeLimit',
                            'message' => 'This file is too large',
                            'provider' => 'upload'
                        ]);
                        $validator->add('image', 'fileCompletedUpload', [
                            'rule' => 'isCompletedUpload',
                            'message' => 'This file could not be uploaded completely',
                            'provider' => 'upload'
                        ]);
                        return $validator;
                    }

                    public function beforeSave($event, $entity, $options) {
                        if ($entity->expiry) {
                            $date = Time::createFromFormat('d/m/Y', $entity->expiry);
                            $entity->expiry = $date->format('Y-m-d');
                        }
                    }

                    public function findslug($query, $options) {
                        $conditions = ['Contests.slug' => $options['slug']];

                        $query = $this->find('all', [
                            'conditions' => $conditions,
                            'contain' => [
                                'ContestParticipates' => [
                                    'fields' => [
                                        'ContestParticipates.id',
                                        'ContestParticipates.contest_id',
                                        'ContestParticipates.likes',
                                        'ContestParticipates.image',
                                        'ContestParticipates.slug',
                                        'ContestParticipates.title',
                                    ],
                                    'sort' => ['ContestParticipates.likes' => 'DESC'],
                                    'conditions' => function ($e, $query) {
                                $query->limit(3);
                                return [];
                            }
                                ]
                            ]
                                ]
                        );

                        $row = $query->first();
                        return $row;
                    }

                }
                