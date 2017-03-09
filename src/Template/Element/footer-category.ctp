<?php


$link = $this->Html->link($category['title'], ['controller' => 'blogs', 'action' => 'index', 'category' => $slug]);
$class = '';
if ($key > 3) {
    $class = 'extra-category hide';
}

echo $this->Html->tag('li', $link, ['class' => $class]);
