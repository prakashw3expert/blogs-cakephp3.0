<?php

$this->extend('/Common/Admin/add');
$this->Html->addCrumb($title, ['action' => 'index']);
if ($page->id) {
    $this->Html->addCrumb('Edit Page', null);
} else {
    $this->Html->addCrumb('Add Page', null);
}

$this->start('form');
echo $this->Form->create($page, [
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

echo $this->Form->input('description', ['id' => 'editor','style'=>'height:300px;']);

echo $this->Form->input('meta_title', []);
echo $this->Form->input('meta_keyword', []);
echo $this->Form->input('meta_description', []);


//echo $this->Form->button('Add');

$this->end();


