<?php

$this->extend('/Common/Admin/add');
$this->Html->addCrumb($title, ['action' => 'index']);
if ($author->id) {
    $this->Html->addCrumb('Edit Author', null);
} else {
    $this->Html->addCrumb('Add Author', null);
}

$this->start('form');

echo $this->Form->create($author, [
    'novalidate' => true,
    'type' => 'file',
    'align' => $this->Awesome->boostrapFromLayout
]);

echo $this->Form->input('name');

// Password
echo $this->Form->input('email');

echo $this->Form->input('designation');

echo $this->Form->input('country_id', ['empty' => 'Select Country', 'class' => 'form-control select2','default' => Cake\Core\Configure::read('default.country')]);
echo $this->Form->input('dob', ['class' => 'form-control datepicker', 'type' => 'text']);
echo $this->Form->input('gender', ['empty' => 'Select', 'class' => 'select2', 'options' => $author->genders]);


$image = null;
if (!empty($author['image'])) {
    $image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image('Users/image', $author['image'], ['class' => 'img-responsive clearfix']) . '
                                                                                                                
                                                                                                        </div>';
}
echo $this->Form->input('image', [
    'templates' => ['file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
    'class' => 'filestyle',
    'label' => 'Profile Image',
    'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);

$image = null;
if (!empty($author['cover_image'])) {
$image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image('Users/cover_image', $author['cover_image'], ['class' => 'img-responsive clearfix']) . '
                                                                                                                
                                                                                                        </div>';
}
echo $this->Form->input('cover_image', [
    'templates' => ['file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
    'class' => 'filestyle',
    'label' => 'Cover Image',
    'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);

echo $this->Form->input('about');

echo $this->Form->input('facebook_url');
echo $this->Form->input('instagram_url');
echo $this->Form->input('google_plus_url');
echo $this->Form->input('linkedIn_url');
echo $this->Form->input('youtube_url');
echo $this->Form->input('pinterest_url');

// Textarea
echo $this->Form->input('password');
echo $this->Form->input('confirm_password',['type' => 'password']);

//echo $this->Form->button('Add');

$this->end();

