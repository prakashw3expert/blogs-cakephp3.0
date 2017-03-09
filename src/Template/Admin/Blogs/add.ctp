<?php

$this->extend('/Common/Admin/add');
$this->Html->addCrumb($title, ['action' => 'index']);
if ($blog->id) {
    $this->Html->addCrumb('Edit Blog', null);
} else {
    $this->Html->addCrumb('Add Blog', null);
}
$this->start('form');
echo $this->Form->create($blog, [
    'novalidate' => true,
    'type' => 'file',
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

echo $this->Form->input('category_id', ['options' => $categories, 'label' => 'Category', 'class' => 'select2', 'empty' => 'Select Category']);
echo $this->Form->input('title');
// Password
echo $this->Form->input('tags', ['data-role' => 'tagsinput', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Add Tags']);
// Day, month, year, hour, minute, meridian

$image = '<div class="thumbnail" style="width:200px;">' . $this->Awesome->image($modelClass . '/image', $blog['image'], ['class' => 'img-responsive clearfix']) . '
                                                                                                                
                                                                                                        </div>';
echo $this->Form->input('image', [
    'templates' => ['file' => $image . '<input type="file" name="{{name}}"{{attrs}}>'],
    'class' => 'filestyle', 'data-buttontext' => 'Select file', 'data-buttonname' => 'btn-white', 'type' => 'file']);
// Textarea
echo $this->Form->input('description', ['id' => 'editor', 'style' => 'height:300px;']);

echo $this->Form->input('meta_title', []);
echo $this->Form->input('meta_keyword', []);
echo $this->Form->input('meta_description', []);



echo $this->Form->input('status', [
    'options' => $status,
    'class' => 'selectpicker',
    'data-style' => 'btn-white',
    'label' => 'Published',
]);

echo $this->Form->input('featured', [
    'options' => $status,
    'class' => 'selectpicker',
    'data-style' => 'btn-white',
    'label' => 'Featured'
]);

// echo $this->Form->input('promoted', [
//     'options' => $status,
//     'class' => 'selectpicker',
//     'data-style' => 'btn-white',
//     'label' => 'Promoted'
// ]);
?>





<?php

//echo $this->Form->input('promoted',['class' => 'checkbox-primary','templates' => [
//    'inputContainer' => '<div class="checkbox">{{content}}</div>',
//    'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
//    'formGroup' => '{{input}}{{label}}',
//    ]]);
//echo $this->Form->button('Add');

$this->end();

