<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;

class UsersTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');

        $this->addBehavior('Muffin/Slug.Slug');

        $this->belongsTo('Countries');
        $this->belongsTo('Roles');

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

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            // You can configure as many upload fields as possible,
            // where the pattern is `field` => `config`
            //
            // Keep in mind that while this plugin does not have any limits in terms of
            // number of files uploaded per request, you should keep this down in order
            // to decrease the ability of your users to block other requests.

            'image' => [
                'keepFilesOnDelete' => false,
                //'path' => 'webroot{DS}files{DS}Authors{DS}{field}{DS}',
                'thumbnails' => ['thumbnail' => 'thumbnail'],
                'transformer' => function (\Cake\Datasource\RepositoryInterface $table, \Cake\Datasource\EntityInterface $entity, $data, $field, $settings) {
            // get the extension from the file
            // there could be better ways to do this, and it will fail
            // if the file has no extension
            $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
            // Store the thumbnail in a temporary file
            $tmpThumbnail = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

            // Use the Imagine library to DO THE THING
            $size = new \Imagine\Image\Box(90, 90);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
            $imagine = new \Imagine\Gd\Imagine();
            // Save that modified file to our temp file
            $imagine->open($data['tmp_name'])
                    ->thumbnail($size, $mode)
                    ->save($tmpThumbnail);


            // Now return the original *and* the thumbnail
            $result = [
                $data['tmp_name'] => $data['name'],
                $tmpThumbnail => 'thumbnail-' . $data['name'],
            ];
            return $result;
        },
                'nameCallback' => function($data, $settings) {
            $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
            return md5(microtime() . '-' . time()) . '-' . time() . '.' . $extension;
        },
            ],
            'cover_image' => [
                'keepFilesOnDelete' => false,
                'thumbnails' => ['large' => 'large'],
                //'path' => 'webroot{DS}files{DS}Authors{DS}{field}{DS}',
                'transformer' => function (\Cake\Datasource\RepositoryInterface $table, \Cake\Datasource\EntityInterface $entity, $data, $field, $settings) {
            // get the extension from the file
            // there could be better ways to do this, and it will fail
            // if the file has no extension
            $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
            // Store the thumbnail in a temporary file
            $tmpThumbnail = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

            // Use the Imagine library to DO THE THING
            $size = new \Imagine\Image\Box(1000, 226);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
            $imagine = new \Imagine\Gd\Imagine();
            // Save that modified file to our temp file
            $imagine->open($data['tmp_name'])
                    ->thumbnail($size, $mode)
                    ->save($tmpThumbnail);


            // Now return the original *and* the thumbnail
            $result = [
                $data['tmp_name'] => $data['name'],
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

    public function beforeSave($event, $entity, $options) {
        if ($entity->dob) {
            $date = Time::createFromFormat('d/m/Y', $entity->dob);
            $entity->dob = $date->format('Y-m-d');
        }
        
    }

    public function validationDefault(Validator $validator) {
        $validator->provider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class);
        $validator
                ->requirePresence('name')
                ->notEmpty('name', 'Please fill this field')
                ->add('name', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Your name should be less than 100 characters.'
                    ]
                ])
                ->requirePresence('email')
                ->add('email', [
                    'validFormat' => [
                        'rule' => 'email',
                        'message' => 'E-mail must be valid'
                    ]
                ])
                ->requirePresence('about')
                ->add('about', [
                'maxLength' => [
                'rule' => ['maxLength', 200],
                'message' => 'About cannot be longer than 200 characters.'
                ]
                ])
                ->requirePresence('country_id')
                ->requirePresence('dob')
                ->notEmpty('dob', __('Please enter dob.'))
                ->add('dob', 'validateDob', [
                        'rule' => function ($value, $context) {
                            if (!empty($context['data']['dob'])) {
                                $dob = Time::createFromFormat('d/m/Y', $context['data']['dob']);
                                $dob = $dob->format('Y-m-d');
                                if (strtotime($dob) > strtotime(date('Y-m-d'))) {
                                    return false;
                                }
                            }
                            return true;
                        },
                        'message' => __('Please enter correct dob.')
                    ])
                ->allowEmpty('facebook_url')
                ->add('facebook_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('google_plus_url')
                ->add('google_plus_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('twitter_url')
                ->add('twitter_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('instagram_url')
                ->add('instagram_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('linkedIn_url')
                ->add('linkedIn_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('youtube_url')
                ->add('youtube_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('pinterest_url')
                ->add('pinterest_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->allowEmpty('website_url')
                ->add('website_url', 'valid', [
                    'rule' => 'url',
                    'message' => 'Please enter a valid url.'
                    ])
                ->requirePresence('gender')
                ->allowEmpty('password')
                ->allowEmpty('confirm_password')
                ->add('confirm_password', 'no-misspelling', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords are not equal',
                ])
                ->add('body', 'length', [
                    'rule' => ['minLength', 50],
                    'message' => 'Articles must have a substantial body.'
        ]);

        $validator->add('image', 'file', [
            'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
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

        $validator->add('cover_image', 'file', [
            'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
        ]);

        return $validator;
    }

    public function validationRegister($validator) {
        $validator
                ->requirePresence('name')
                ->notEmpty('name', 'Please fill this fields')
                ->add('name', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Your name should be less than 100 characters.'
                    ]
                ])
                ->requirePresence('email')
                ->add('email', [
                    'validFormat' => [
                        'rule' => 'email',
                        'message' => 'E-mail must be valid'
                    ]
                ])
                ->requirePresence('password')
                ->add('password', [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'Password need to be at least 6 characters long',
                    ]
                ])
                ->add('password', 'validateLetterNumberSpecialCharacters', [
                        'rule' => function ($value, $context) {
                            $currentPassword = $context['data']['password'];
                            $containsLetter  = preg_match('/[a-zA-Z]/',    $currentPassword);
                            $containsDigit   = preg_match('/\d/',          $currentPassword);
                            $containsSpecial = preg_match('/[^a-zA-Z\d]/', $currentPassword);
                            if($containsLetter && $containsDigit && $containsSpecial){
                                return true;
                            }
                            return false;
                        },
                        'message' => __('Please enter least one letter, number and special character.')
                    ])
                ->requirePresence('confirm_password')
                ->add('confirm_password', 'no-misspelling', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords are not equal',
                ])
                ->requirePresence('signing')
                ->notEmpty('signing', 'Please checked terms and conditions');
                //print_r($validator);die;
        return $validator;
    }
    
    public function validationForgotPassword($validator) {
        $validator
                ->requirePresence('password')
                ->add('password', [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'Password need to be at least 6 characters long',
                    ]
                ])
                ->add('password', 'validateLetterNumberSpecialCharacters', [
                        'rule' => function ($value, $context) {
                            $currentPassword = $context['data']['password'];
                            $containsLetter  = preg_match('/[a-zA-Z]/',    $currentPassword);
                            $containsDigit   = preg_match('/\d/',          $currentPassword);
                            $containsSpecial = preg_match('/[^a-zA-Z\d]/', $currentPassword);
                            if($containsLetter && $containsDigit && $containsSpecial){
                                return true;
                            }
                            return false;
                        },
                        'message' => __('Please enter least one letter, number and special character.')
                    ])
                ->requirePresence('confirm_password')
                ->add('confirm_password', 'no-misspelling', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords are not equal',
        ]);

        return $validator;
    }

    public function validationChangePassword($validator) {
        $validator
                ->requirePresence('current_password')
                 ->add('current_password', 'validateCurrentPassword', [
                        'rule' => function ($value, $context) {
                            $currentPassword = $this->get($context['data']['id'])->password;
                            $obj = new DefaultPasswordHasher;

                            if(!$obj->check($context['data']['current_password'], $currentPassword)){
                                return false;
                            }

                            return true;
                        },
                        'message' => __('Wrong current password.')
                    ])
                ->requirePresence('password')
                ->add('password', [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'Password need to be at least 6 characters long',
                    ]
                ])
                ->add('password', 'validateLetterNumberSpecialCharacters', [
                        'rule' => function ($value, $context) {
                            $currentPassword = $context['data']['password'];
                            $containsLetter  = preg_match('/[a-zA-Z]/',    $currentPassword);
                            $containsDigit   = preg_match('/\d/',          $currentPassword);
                            $containsSpecial = preg_match('/[^a-zA-Z\d]/', $currentPassword);
                            if($containsLetter && $containsDigit && $containsSpecial){
                                return true;
                            }
                            return false;
                        },
                        'message' => __('Please enter least one letter, number and special character.')
                    ])
                ->add('password', 'validateCurrentPasswordWithNewPassword', [
                        'rule' => function ($value, $context) {

                            if($context['data']['current_password'] == $context['data']['password']){
                                return false;
                            }

                            return true;
                        },
                        'message' => __('Your new password are same as current password. Enter different new password.')
                    ])
                ->requirePresence('confirm_password')
                ->add('confirm_password', 'no-misspelling', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords are not equal',
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

    public function findslug($query, $options) {
        $conditions = ['Users.slug' => $options['slug']];

        $query = $this->find('all', [
            'conditions' => $conditions,
            'fields' => [
                'Users.id',
                'Users.name',
                'Users.slug',
                'Users.designation',
                'Users.gender',
                'Users.image',
                'Users.cover_image',
                'Users.facebook_url',
                'Users.twitter_url',
                'Users.google_plus_url',
                'Users.linkedIn_url',
                'Users.youtube_url',
                'Users.pinterest_url',
                'Users.about',
            ],
                ]
        );

        $row = $query->first();
        return $row;
    }

    public function findAuthAdmin(\Cake\ORM\Query $query, array $options) {
        $query
                ->select(['id', 'name', 'slug', 'email', 'password', 'image', 'is_admin'])
                ->where(['Users.is_admin' => 1]);

        return $query;
    }

    public function findAuthAuthor(\Cake\ORM\Query $query, array $options) {
        $query
                ->select(['id', 'name', 'slug', 'email', 'password', 'image', 'is_admin'])
                ->where(['Users.is_admin' => 0, 'Users.status' => 1, 'Users.role_id' => 1]);

        return $query;
    }

    public function findAuthUser(\Cake\ORM\Query $query, array $options) {
        $query
                ->contain('Roles')
                ->select(['Users.id', 'Users.name', 'Users.slug', 'Users.email', 'Users.password', 'Users.image', 'Users.is_admin','Roles.id','Roles.name','Roles.alias'])
                ->where(['Users.is_admin' => 0, 'Users.status' => 1]);

        return $query;
    }

}
