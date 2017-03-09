<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\Event\Event;
use ArrayObject;

class EventImagesTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'image' => [
            'keepFilesOnDelete' => false,
            'transformer' => function (\Cake\Datasource\RepositoryInterface $table, \Cake\Datasource\EntityInterface $entity, $data, $field, $settings) {
                $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    // Store the thumbnail in a temporary file
                $tmpThumbnail = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                $tmpLarge = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    // Use the Imagine library to DO THE THING

                $size = new \Imagine\Image\Box(60, 60);
                $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                $imagine = new \Imagine\Gd\Imagine();
                    // Save that modified file to our temp file
                $imagine->open($data['tmp_name'])
                ->thumbnail($size, $mode)
                ->save($tmpThumbnail);


                    // Use the Imagine library to DO THE THING
                $size = new \Imagine\Image\Box(600, 600);
                $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                $imagine = new \Imagine\Gd\Imagine();
            // Save that modified file to our temp file
                $imagine->open($data['tmp_name'])
                ->thumbnail($size, $mode)
                ->save($tmpLarge);

                    // Now return the original *and* the thumbnail
                $result = [
                $tmpLarge => $data['name'],
                $tmpThumbnail => 'thumbnail-' . $data['name'],
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
        $validator->provider('image', \Josegonzalez\Upload\Validation\ImageValidation::class);
        $validator->requirePresence('image')
            ->notEmpty('image', __('Please upload image.'));
        $validator->add('image', 'file', [
           'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
           'message' => 'Uploaded file should be a png, gif, jpg image.',
           ]);

        // $validator->add('image', 'fileBelowMaxWidth', [
        //     'rule' => ['isBelowMaxWidth', 1000],
        //     'message' => 'This image should not be wider than 1000px',
        //     'provider' => 'image'
        //     ]);

        // $validator->add('image', 'fileBelowMaxHeight', [
        //     'rule' => ['isBelowMaxHeight', 1000],
        //     'message' => 'This image should not be higher than 1000px',
        //     'provider' => 'image'
        //     ]);

        $validator->add('image', 'fileBelowMinWidth', [
            'rule' => ['isAboveMinWidth', 600],
            'message' => 'This image should not be narrow than 600px',
            'provider' => 'image'
            ]);

        $validator->add('image', 'fileBelowMinHeight', [
            'rule' => ['isAboveMinHeight', 600],
            'message' => 'This image should not be smaller than 600px',
            'provider' => 'image'
            ]);


        return $validator;
    }

}
