<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\ORM\Query;
use Symfony\Component\Yaml\Yaml;
use Cake\Core\Configure;
use Cake\Event\Event;

class CategoriesTable extends Table {

    public function initialize(array $config) {

        $this->settingsPath = ROOT . DS . 'config' . DS . 'categories.yml';

        $this->hasMany('ChildCategories', [
            'foreignKey' => 'parent_id',
            'className' => 'Categories',
            ]);

        $this->belongsTo('Parent', [
            'foreignKey' => 'parent_id',
            'className' => 'Categories',
            ]);

        $this->addBehavior('CounterCache', [
            'ChildCategories' => ['child_count']
            ]);
        $this->addBehavior('Muffin/Slug.Slug');

        $this->addBehavior('Tree');
        $this->addBehavior('Timestamp');
        // Add the behaviour to your table
        $this->addBehavior('Search.Search');
        // Setup search filter using search manager
        $this->searchManager()
        ->add('q', 'Search.Like', [
            'before' => true,
            'after' => true,
            'mode' => 'or',
            'comparison' => 'LIKE',
            'wildcardAny' => '*',
            'wildcardOne' => '?',
            'field' => [$this->aliasField('title')]
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
        $validator
        ->requirePresence('title')
        ->add('title', [
            'maxLength' => [
            'rule' => ['maxLength', 200],
            'message' => 'Title cannot be too longer than 200 characters.'
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

            // In a table class
    public function buildRules(RulesChecker $rules) {

        $rules->add(new isUnique(['title']), 'isUniqueTitle', [
            'errorField' => 'title',
            'message' => 'This is already used.'
            ]);

        return $rules;
    }

    public function findParent(Query $query, array $options) {
        return $this->find('list')->where(['parent_id' => 0, 'status' => 1]);
    }

    public function findTree(Query $query, array $options) {
        return $this->find('treeList', ['spacer' => '--', 'escape' => false])->where(['status' => 1]);
    }

    public function findMenus(Query $query, array $options) {
        return $this->find('all', [
            'order' => ['Categories.order' => 'ASC'],
            'conditions' => ['Categories.parent_id' => 0, 'Categories.status' => 1, 'Categories.in_menu' => 1],
            'fields' => ['Categories.id', 'Categories.title', 'Categories.slug', 'Categories.in_menu', 'Categories.image'],
            'contain' => ['ChildCategories' => [
            'conditions' => ['ChildCategories.status' => 1, 'ChildCategories.in_menu' => 1],
            'fields' => ['ChildCategories.id', 'ChildCategories.title', 'ChildCategories.slug', 'ChildCategories.image', 'ChildCategories.parent_id']]
            ]
            ]);
    }

            /**
             * beforeSave callback
             */
            public function beforeSave() {
                $this->connection()->driver()->autoQuoting(true);
            }

            /**
             * afterSave callback
             */
            public function afterSave() {
                $this->updateJson();
            }

            /**
             * afterDelete callback
             *
             * @return void
             */
            public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options) {
                die('here');
                $this->updateJson();
            }

            /**
             * Find list and save yaml dump in app/Config/settings.yml file.
             * Data required in bootstrap.
             *
             * @return void
             */
            public function updateJson() {
                $menus = $this->find('Menus');
                
                $all = $this->find('all', [
                    'fields' => ['Categories.id', 'Categories.slug', 'Categories.title', 'Categories.status', 'Categories.on_home','Categories.parent_id','Parent.slug','Parent.title','Parent.status'],
                     'order' => ['Categories.order' => 'ASC'],
                     'contain' => ['Parent']
                    ]
                    );
                

                $categories = array();
                if ($menus->count() > 0) {

                    foreach (collection($menus)->toArray() as $category) {
                        $categories['Menus.' . $category['slug']] = json_encode($category);
                    }
                }

                if ($all->count() > 0) {
                    foreach (collection($all)->toArray() as $category) {
                        if ($category['status'] == 1 && $category['on_home'] == 1) {
                            $categories['HomeCategories.' . $category['slug']] = json_encode($category);
                        }
                        $categories['Categories.' . $category['slug']] = json_encode($category);
                    }
                }
                $categories = Yaml::dump($categories);
                file_put_contents($this->settingsPath, $categories);

                Configure::load('categories', 'categories');
            }

        }
        