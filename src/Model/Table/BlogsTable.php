<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;
use Cake\Utility\Hash;

class BlogsTable extends Table {

    public function initialize(array $config) {
        $this->belongsTo('Categories');
        $this->belongsTo('Users');

        $this->addBehavior('CounterCache', [
            'Users' => ['blog_count']
        ]);

        $this->addBehavior('Timestamp');
        // Add the behaviour to your table
        $this->addBehavior('Search.Search');

        // Setup search filter using search manager
        $this->searchManager()
                ->value('category_id')
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'mode' => 'or',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => [$this->aliasField('title')]
        ]);

        $this->addBehavior('Muffin/Slug.Slug');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            // You can configure as many upload fields as possible,
            // where the pattern is `field` => `config`
            //
            // Keep in mind that while this plugin does not have any limits in terms of
            // number of files uploaded per request, you should keep this down in order
            // to decrease the ability of your users to block other requests.

            'image' => [
                'keepFilesOnDelete' => false,
                'thumbnails' => ['thumbnail' => 'thumbnail', 'large' => 'large'],
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
            $size = new \Imagine\Image\Box(950, 800);
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
        $validator
                ->requirePresence('title')
                ->requirePresence('category_id')
                ->add('title', [
                    'maxLength' => [
                        'rule' => ['maxLength', 100],
                        'message' => 'Title cannot be too longer than 100 characters.'
                    ]
                ])
                ->requirePresence('description')
                ->add('description', [
                    'minLength' => [
                        'rule' => ['minLength', 10],
                        'last' => true,
                        'message' => 'Description must have a mininum 10 characters.'
                    ],
                ])
                ->allowEmpty('meta_title')
                ->add('meta_title', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Title cannot be too longer than 150 characters.'
                    ]
                ])
                ->allowEmpty('meta_keyword')
                ->add('meta_keyword', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Keyword cannot be too longer than 150 characters.'
                    ]
                ])
                ->allowEmpty('meta_description')
                ->add('meta_description', [
                    'maxLength' => [
                        'rule' => ['maxLength', 150],
                        'message' => 'Meta Description cannot be too longer than 150 characters.'
                    ]
        ]);


        $validator->add('image', 'file', [
            'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
            'on' => function ($context) {
        return !empty($context['data']['image']);
    }
        ]);

        $validator->add('file', 'fileUnderPhpSizeLimit', [
            'rule' => 'isUnderPhpSizeLimit',
            'message' => 'This file is too large',
            'provider' => 'upload'
        ]);

        $validator->add('file', 'fileUnderFormSizeLimit', [
            'rule' => 'isUnderFormSizeLimit',
            'message' => 'This file is too large',
            'provider' => 'upload'
        ]);
        $validator->add('file', 'fileCompletedUpload', [
            'rule' => 'isCompletedUpload',
            'message' => 'This file could not be uploaded completely',
            'provider' => 'upload'
        ]);
        return $validator;
    }

    public function validationImage(Validator $validator) {

        $validator->add('image', 'file', [
            'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
            'on' => function ($context) {
        return !empty($context['data']['image']);
    }
        ]);

        $validator->add('file', 'fileUnderPhpSizeLimit', [
            'rule' => 'isUnderPhpSizeLimit',
            'message' => 'This file is too large',
            'provider' => 'upload'
        ]);

        $validator->add('file', 'fileUnderFormSizeLimit', [
            'rule' => 'isUnderFormSizeLimit',
            'message' => 'This file is too large',
            'provider' => 'upload'
        ]);
        $validator->add('file', 'fileCompletedUpload', [
            'rule' => 'isCompletedUpload',
            'message' => 'This file could not be uploaded completely',
            'provider' => 'upload'
        ]);
        return $validator;
    }

//    // In a table class
//    public function buildRules(RulesChecker $rules) {
//
//        $rules->add(new isUnique(['email']), 'isUniqueEmail', [
//            'errorField' => 'email',
//            'message' => 'This is already used.'
//        ]);
//
//        $validator->add('file', 'fileSuccessfulWrite', [
//            'rule' => 'isSuccessfulWrite',
//            'message' => 'This upload failed',
//            'provider' => 'upload'
//        ]);
//
//        $validator->add('file', 'fileBelowMaxSize', [
//            'rule' => ['isBelowMaxSize', 2048],
//            'message' => 'This file is too large',
//            'provider' => 'upload'
//        ]);
//
//        return $rules;
//    }


    public function findfeatured($query, $options) {
        $conditions = ['Blogs.status' => 1, 'Blogs.featured' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];
        $result = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Categories','Categories.Parent'],
            'fields' => ['Blogs.id',
                'Blogs.category_id',
                'Blogs.title',
                'Blogs.image',
                'Blogs.view_count',
                'Blogs.comment_count',
                'Blogs.created',
                'Categories.id',
                'Categories.title',
                'Blogs.slug',
                'Categories.slug',
                'Parent.slug',
                'Categories.tag',
            ],
            'order' => 'Blogs.id DESC',
            'limit' => 3,
                ]
        );
        
        return $result;
    }

    public function findpromoted($query, $options) {
        $conditions = ['Blogs.status' => 1, 'Blogs.promoted' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];
        if (!empty($options['rendered'])) {
            $conditions[] = ['Blogs.id NOT IN' => $options['rendered']];
        }
        return $this->find('all', [
                    'conditions' => $conditions,
                    'contain' => ['Categories','Categories.Parent'],
                    'fields' => ['Blogs.id',
                        'Blogs.category_id',
                        'Blogs.title',
                        'Blogs.image',
                        'Blogs.view_count',
                        'Blogs.comment_count',
                        'Blogs.created',
                        'Categories.id',
                        'Categories.title',
                        'Blogs.slug',
                        'Categories.slug',
                        'Parent.slug',
                        'Categories.tag',
                    ],
                    'order' => 'rand()',
                    'limit' => 1,
                        ]
        );
    }

    public function findupdated($query, $options) {
        $conditions = ['Blogs.status' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];
        if (!empty($options['rendered'])) {
            $conditions[] = ['Blogs.id NOT IN' => $options['rendered']];
        }
        return $this->find('all', [
                    'conditions' => $conditions,
                    'contain' => ['Categories','Categories.Parent'],
                    'fields' => ['Blogs.id',
                        'Blogs.category_id',
                        'Blogs.title',
                        'Blogs.image',
                        'Blogs.view_count',
                        'Blogs.comment_count',
                        'Blogs.created',
                        'Categories.id',
                        'Categories.title',
                        'Blogs.slug',
                        'Categories.slug',
                        'Categories.tag',
                        'Parent.slug',
                    ],
                    'order' => 'Blogs.id desc',
                    'limit' => 3,
                        ]
        );
    }

    public function findpopular($query, $options) {
        $conditions = ['Blogs.status' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];
        if (!empty($options['rendered'])) {
            $conditions[] = ['Blogs.id NOT IN' => $options['rendered']];
        }
        return $this->find('all', [
                    'conditions' => $conditions,
                    'contain' => ['Categories','Categories.Parent'],
                    'fields' => ['Blogs.id',
                        'Blogs.category_id',
                        'Blogs.title',
                        'Blogs.image',
                        'Blogs.view_count',
                        'Blogs.comment_count',
                        'Blogs.created',
                        'Categories.id',
                        'Categories.title',
                        'Blogs.slug',
                        'Categories.slug',
                        'Parent.slug',
                    ],
                    'order' => 'Blogs.id desc',
                    'limit' => 10,
                        ]
        );
    }

    public function findcategoryBlogs($query, $options) {
        $conditions = ['Blogs.status' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];

        if (!empty($options['rendered'])) {
            $conditions[] = ['Blogs.id NOT IN' => $options['rendered']];
        }
        if (!empty($options['category'])) {
            $conditions[] = ['OR' => [
                    'Categories.id' => $options['category'],
                    'Categories.parent_id' => $options['category']
                ]
            ];
        }
        $blogs = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Categories','Categories.Parent'],
            'fields' => ['Blogs.id',
                'Blogs.category_id',
                'Blogs.title',
                'Blogs.image',
                'Blogs.view_count',
                'Blogs.comment_count',
                'Blogs.description',
                'Blogs.created',
                'Blogs.slug',
                'Categories.slug',
                'Parent.slug',
                'Categories.tag',
            ],
            'limit' => $options['records'],
                ]
        );
        return $blogs;
    }

    public function findslug($query, $options) {
        $conditions = ['Categories.slug' => $options['category'], 'Blogs.slug' => $options['slug'], 'Blogs.status' => 1,'Categories.title IS NOT NULL','Categories.status' => 1];

        $query = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Categories', 'Users','Categories.Parent'],
            'fields' => [
                'Blogs.id',
                'Blogs.slug',
                'Blogs.category_id',
                'Blogs.title',
                'Blogs.image',
                'Blogs.tags',
                'Blogs.description',
                'Blogs.view_count',
                'Blogs.comment_count',
                'Blogs.created',
                'Blogs.meta_title',
                'Blogs.meta_keyword',
                'Blogs.meta_description',
                'Users.name',
                'Users.slug',
                'Categories.id',
                'Categories.title',
                'Categories.slug',
                'Parent.title',
                'Parent.slug',
            ],
                ]
        );

        $row = $query->first();
        return $row;
    }

    public function findUserBlog($query, $options) {
        pr($query);
        die;
    }

}
