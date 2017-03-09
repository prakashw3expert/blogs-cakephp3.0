<?php

$this->extend('/Common/Admin/add');

$this->start('form');
echo $this->Form->create($user, [
    'novalidate' => true,
    'align' => $this->Awesome->boostrapFromLayout
]);

 echo $this->Form->input('first_name');
// Password
echo $this->Form->input('last_name');
// Day, month, year, hour, minute, meridian
echo $this->Form->input('email');
// Textarea

//echo $this->Form->button('Add');

$this->end();


