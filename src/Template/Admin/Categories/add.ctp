<?php
$this->Html->addCrumb($title, ['action' => 'index']);
if ($category->id) {
    $this->Html->addCrumb('Edit Category', null);
} else {
    $this->Html->addCrumb('Add Category', null);
}


$this->extend('/Common/Admin/add');

$this->start('form');
echo $this->Form->create($category, [
    'novalidate' => true,
    'type' => 'file',
    'align' => $this->Awesome->boostrapFromLayout
]);


echo $this->Form->input('parent_id',['options' => $categories,'label' => 'Parent Category','class' => 'select2','empty' => 'Add New Parent Category']);
echo $this->Form->input('title');
// Password
// Day, month, year, hour, minute, meridian

$image = '<div class="thumbnail" style="width:200px;">'.$this->Awesome->image($modelClass.'/image',$category['image'],['class' => 'img-responsive clearfix']).'
                                                                                                                
                                                                                                        </div>';
//echo $this->Form->input('image', [
//    'templates' => ['file' => $image.'<input type="file" name="{{name}}"{{attrs}}>'],
//    'class' => 'filestyle', 'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
// Textarea
echo $this->Form->input('status', ['options' => $status, 'class' => 'selectpicker']);


//echo $this->Form->input('promoted',['class' => 'checkbox-primary','templates' => [
//    'inputContainer' => '<div class="checkbox">{{content}}</div>',
//    'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
//    'formGroup' => '{{input}}{{label}}',
//    ]]);
//echo $this->Form->button('Add');

$this->end();

