<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\I18n\Time;

class User extends Entity {

    protected $_accessible = [
        'name' => true,
        'image' => true,
        'email' => true,
        'password' => true,
        'age' => true,
        'dob' => true,
        'gender' => true,
        'country_id' => true,
        'avatar_id' => true,
        'slug' => true,
        'is_admin' => true,
        'role_id' => true,
        'status' => true,
        'cover_image' => true,
        'country_id' => true,
        'facebook_id' => true,
        'google_id' => true,
        'twitter_id' => true,
        'google_email' => true,
        'facebook_email' => true,
        'twitter_name' => true,
        'is_admin' => true,
        'facebook_url' => true,
        'instagram_url' => true,
        'google_plus_url' => true,
        'linkedIn_url' => true,
        'youtube_url' => true,
        'pinterest_url' => true,
        'website_url' => true,
        'event_count' => true,
        'blog_count' => true,
        'about' => true,
        'designation' => true,
    ];

    protected function _setPassword($password) {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    protected function _getAge() {
        if (!empty($this->_properties['dob'])) {
            $dob = new Time($this->_properties['dob']);
            $today = new Time('today');
            return $dob->diff($today)->y;
        }
        return null;
    }

    protected function _getGenders() {
        return ['M' => 'Male', 'F' => 'Female'];
    }

    protected function _getAgeList() {
        $age = [];
        for ($ageStart = 1; $ageStart <= 100; $ageStart++) {
            $age[$ageStart] = ($ageStart == 1) ? $ageStart . ' Year' : $ageStart . ' Years';
        }
        return $age;
    }

}
