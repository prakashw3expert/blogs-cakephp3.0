<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\I18n\Time;

class EventsTable extends Table {

    public function initialize(array $config) {
        $this->belongsTo('Countries');

        $this->belongsTo('Users');

        $this->hasMany('EventImages');
        $this->hasMany('EventTickets');
        $this->addBehavior('Timestamp');
        // Add the behaviour to your table
        $this->addBehavior('CounterCache', [
            'Users' => ['event_count']
            ]);

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
            'field' => [$this->aliasField('title'), $this->aliasField('slug'),$this->aliasField('organizer'), $this->aliasField('venue'), $this->aliasField('address'), $this->aliasField('pincode')]
            ])->add('date', 'Search.Callback', [
            'callback' => function ($query, $args, $filter) {
                $date = Time::createFromFormat('d/m/Y', $args['date']);
                $date = $date->format('Y-m-d');
                return $query->where(['DATE(Events.start_date) >= ' => $date]);
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
            ->notEmpty('start_date', __('You need to select start date.'))
            ->notEmpty('end_date', __('You need to select end date.'))
            ->notEmpty('start_time', __('You need to select start time.'))
            ->notEmpty('end_time', __('You need to select end time.'))
            ->add('end_date', 'validateEnds', [
                'rule' => function ($value, $context) {


                    if (!empty($context['data']['start_date']) && !empty($context['data']['end_date'])) {
                        $startDate = Time::createFromFormat('d/m/Y', $context['data']['start_date']);
                        $startDate = $startDate->format('Y-m-d');

                        $endDate = Time::createFromFormat('d/m/Y', $context['data']['end_date']);
                        $endDate = $endDate->format('Y-m-d');
                        if (strtotime($startDate . ' ' . $context['data']['start_time']) > strtotime($endDate . ' ' . $context['data']['end_time'])) {
                            return false;
                        }
                    }
                    return true;
                },
                'message' => __('End date & time should be greater than start date & time.')
                ])
            ->notEmpty('venue', __('You need to provide venue.'))
            ->notEmpty('address', __('You need to provide address.'))
            ->notEmpty('city', __('You need to provide city.'))
            ->notEmpty('state', __('You need to provide state.'))
            ->notEmpty('pincode', __('You need to provide zip / postal code.'))
            ->notEmpty('country_id', __('You need to select country.'))
            ->requirePresence('description')

            ->notEmpty('organizer', __('You need to provide organizer name.'))
            ->notEmpty('organizer_details', __('You need to provide organizer details.'))
            ->add('organizer_details', [
                    'maxLength' => [
                        'rule' => ['maxLength', 200],
                        'message' => 'Your organizer details should be less than 200 characters.'
                    ]
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
            ->add('linkedIn_url', 'valid', [
                'rule' => 'url',
                'message' => 'Please enter a valid url.'
                ])
            ->allowEmpty('youtube_url')
            ->add('youtube_url', 'valid', [
                'rule' => 'url',
                'message' => 'Please enter a valid url.'
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
            if ($entity->start_date) {
                $date = Time::createFromFormat('d/m/Y', $entity->start_date);
                $entity->start_date = $date->format('Y-m-d');
            }
            if ($entity->end_date) {
                $date = Time::createFromFormat('d/m/Y', $entity->end_date);
                $entity->end_date = $date->format('Y-m-d');
            }

            $geoLocation = $this->geoLocation($entity);
            if ($geoLocation) {

                $entity->lat = $geoLocation->lat;
                $entity->lng = $geoLocation->lng;
            }
        }

        public function findslug($query, $options) {
            $conditions = ['Events.slug' => $options['slug']];

            $query = $this->find('all', [
                'conditions' => $conditions,
                'contain' => ['Countries', 'EventImages', 'EventTickets', 'Users'],
                'fieldss' => [
                'Events.id',
                'Events.slug',
                'Events.category_id',
                'Events.title',
                'Events.image',
                'Events.tags',
                'Events.description',
                'Events.view_count',
                'Events.comment_count',
                'Events.created',
                'Events.name',
                'Events.slug',
                'Categories.id',
                'Categories.title',
                'Categories.slug',
                ],
                ]
                );

            $row = $query->first();
            return $row;
        }

        public function finddetails($query, $options) {
            $conditions = ['Events.slug' => $options['slug']];

            $query = $this->find('all', [
                'conditions' => $conditions,
                'contain' => ['Countries', 'EventImages', 'EventTickets' => [
                'conditions' => [
                'EventTickets.sale_start_date <= now()',
                'EventTickets.sale_end_date >= now()',
                //'start_time <=' => date('H:i:s'),
                //'end_time >=' => date('H:i:s')
                ]
                ], 'Users'],
                'fieldss' => [
                'Events.id',
                'Events.slug',
                'Events.category_id',
                'Events.title',
                'Events.image',
                'Events.tags',
                'Events.description',
                'Events.view_count',
                'Events.comment_count',
                'Events.created',
                'Events.name',
                'Events.slug',
                'Categories.id',
                'Categories.title',
                'Categories.slug',
                ],
                ]
                );

            $row = $query->first();
            return $row;
        }

        public function findcities($query, $options) {
            $conditions = ['Events.status' => 1];

            $result = $this->find('list', [
                'conditions' => $conditions,
                'keyField' => 'city',
                'valueField' => 'city'
                ]
                )->toArray();


            return $result;
        }

        public function geoLocation($entity) {
            $address = $entity['address'];
            
            if (!empty($entity['address2'])) {
                $address .= ' ' . $entity['address2'];
            }
            $address = $address . ' ' . $entity['city'] . ' ' . $entity['state'] . '-' . $entity['pincode'];
            $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . urlencode($address);
            $resp_json = $this->curl_file_get_contents($url);
            $result = json_decode($resp_json);

            $output = array();
            if ($result->status == 'OK' && !empty($result->results[0])) {
                return $result->results[0]->geometry->location;
            }
            return null;
        }

        public function curl_file_get_contents($URL) {
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $URL);
            $contents = curl_exec($c);
            curl_close($c);

            if ($contents)
                return $contents;
            else
                return FALSE;
        }

    }
