<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;

class ContestParticipatesTable extends Table {

    public function initialize(array $config) {

        $this->belongsTo('Users');
        $this->belongsTo('Contests');
        $this->hasMany('ContestParticipatesUsers');

        $this->addBehavior('CounterCache', [
            'Contests' => ['enteries']
        ]);
        
        $this->addBehavior('Timestamp');
        // Add the behaviour to your table


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
                            $size = new \Imagine\Image\Box(300, 300);
                            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                            $imagine = new \Imagine\Gd\Imagine();
                            // Save that modified file to our temp file
                            $imagine->open($data['tmp_name'])
                                    ->thumbnail($size, $mode)
                                    ->save($tmpLarge);


                            // Use the Imagine library to DO THE THING
                            $size = new \Imagine\Image\Box(1000, 1000);
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
                                ->notEmpty('title', __('You sholuld provide a valid title for the picture.'))
                                ->add('title', [
                                    'maxLength' => [
                                        'rule' => ['maxLength', 100],
                                        'message' => 'Title sholuldn\'t longer than 100 characters.'
                                    ]
                                ])
                                ->requirePresence('tags')
                                ->notEmpty('tags', __('You should provide atleast 3 tags'))
                                ->add('tags', 'validationMinTags', [
                                    'rule' => function ($value, $context) {
                                        return (count(explode(',', $value)) > 2) ? true : false;
                                    },
                                    'message' => 'You should provide atleast 3 tags'
                                ])
                                ->requirePresence('description')
                                ->notEmpty('description', __('You should provide a valid description for the picture.'))
                                ->add('description', [
                                    'maxLength' => [
                                        'rule' => ['minLength', 10],
                                        'message' => 'You should provide min 10 char descripton.'
                                    ]
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

                    public function validationImage(Validator $validator) {

                        $validator->provider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class);

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

                    public function findslug($query, $options) {

                        $conditions = ['ContestParticipates.slug' => $options['slug']];
                        $contain = ['Users' => array('fields' => array('Users.name', 'Users.slug', 'Users.image')), 'Contests'];
                        if (!empty($options['user_id'])) {
                            $contain['ContestParticipatesUsers'] = ['conditions' => ['ContestParticipatesUsers.user_id' => $options['user_id']], 'fields' => ['ContestParticipatesUsers.id', 'ContestParticipatesUsers.contest_participate_id']];
                        }
                        $query = $this->find('all', [
                            'conditions' => $conditions,
                            'contain' => $contain
                                ]
                        );

                        $row = $query->first();

                        return $row;
                    }

                }
                