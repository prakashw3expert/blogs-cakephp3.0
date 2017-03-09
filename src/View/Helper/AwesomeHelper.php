<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;


class AwesomeHelper extends Helper {

    public $helpers = ['Html','Url'];
    // initialize() hook is available since 3.2. For prior versions you can
    // override the constructor if required.

    public $boostrapFromLayout = [
    'sm' => [
    'left' => 6,
    'middle' => 6,
    'right' => 12
    ],
    'md' => [
    'left' => 4,
    'middle' => 4,
    'right' => 4
    ]
    ];

    public function initialize(array $config) {

    }
    
    /**
     * Creates a formatted IMG element.
     *
     * This method will set an empty alt attribute if one is not supplied.
     *
     * ### Usage:
     *
     * Create a regular image:
     *
     * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP'));`
     *
     * Create an image link:
     *
     * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP', 'url' => 'http://cakephp.org'));`
     *
     * ### Options:
     *
     * - `url` If provided an image link will be generated and the link will point at
     *   `$options['url']`.
     * - `fullBase` If true the src attribute will get a full address for the image file.
     * - `plugin` False value will prevent parsing path as a plugin
     *
     * @param string $path Path to the image file, relative to the app/webroot/img/ directory.
     * @param array $options Array of HTML attributes. See above for special options.
     * @return string completed img tag
     * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::image
     */
    public function image($dir, $image,  $options = array()) {
        $type = '';
        $noimages = 'no-image.png';
        $tag = true;
        
        if(!empty($options['type'])){
            $type = $options['type'];
        }
        if(!empty($options['lazy'])){
            $noimages = $options['lazy'];
        }
        if(!empty($options['default'])){
            $noimages = $options['default'];
        }
        if(isset($options['tag']) && $options['tag'] == false){
            $tag = false;
        }
        
        $image = ($type) ? $type . '-' . $image : $image;
        
        if (file_exists('files' . "/" . $dir . "/" . $image) && is_file('files' . "/" . $dir . "/" . $image)) {

            $resized =  '/files' . "/" . $dir . "/" . $image;
        } else {
            $resized = '/img/' . $noimages;
        }
        
        $resized = $this->Url->build($resized, true);
        if ($tag) {
            $resized = $this->Html->image($resized, $options);
        }
        return $resized;
    }
    
    public function getLabedStatus($status){
        if($status == 1){
            return $this->Html->tag('span','Active',['class' => 'text-success']);
        }
        if($status == 0){
            return $this->Html->tag('span','Pending',['class' => 'text-danger']);
        }
    }
    
    public function date($date, $format = 'M d, Y'){
        return date($format,  strtotime($date));
    }
    
    public function niceCount($number){
        return $number;
    }
    
    public function blogLink($blog){
        return $this->Html->link($blog['title'], ['controller' => 'blog', 'action' => 'view', 'slug' => $blog['title'], 'id' => $blog['id']]);
    }

    public function addhttp($url) {
        $url = trim($url);
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

    public function removeHttp($url){
        return str_replace(array('http://','https://','www.'), array('','',''), $url);
    }

    function createAcronym($string, $onlyCapitals = false) {
        $output = null;
        $token  = strtok($string, ' ');
        while ($token !== false) {
            $character = mb_substr($token, 0, 1);
            if ($onlyCapitals and mb_strtoupper($character) !== $character) {
                $token = strtok(' ');
                continue;
            }
            $output .= $character;
            $token = strtok(' ');
        }
        return strtoupper($output);
    }




}
