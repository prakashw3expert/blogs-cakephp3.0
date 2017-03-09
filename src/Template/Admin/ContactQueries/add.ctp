<?php

$this->extend('/Common/Admin/add');

$this->start('form');
echo $this->Form->create($contact, [
    'novalidate' => true,
    'align' => [
        'sm' => [
            'left' => 4,
            'middle' => 8,
            'right' => 12
        ],
        'md' => [
            'left' => 2,
            'middle' => 8,
            'right' => 2
        ]
    ]
]);

echo $this->Form->input('title');

echo $this->Form->input('email');



$this->end();


