<?php

$this->extend('/Common/Admin/add');

$this->start('form');
echo $this->Form->create($setting, [
    'novalidate' => true,
    'align' => $this->Awesome->boostrapFromLayout
]);

echo $this->Form->input('key');
echo $this->Form->input('value');

$this->end();

