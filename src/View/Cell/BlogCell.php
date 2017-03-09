<?php

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;

class BlogCell extends Cell {

    public function featured() {
        $this->loadModel('Blogs');
        //Featured Blogs
        $featured = $this->Blogs->find('featured')->toArray();

        // Add in mark as render to avoid duplicate rendering home page
        $this->updateRendered($featured, 'featured');

        $this->set('blogs', $featured);
    }

    public function promoted() {
        $this->loadModel('Blogs');

        $rendered = $this->getRendered(['featured']);

        $blogs = $this->Blogs->find('promoted', ['rendered' => $rendered])->toArray();

        // Add in mark as render to avoid duplicate rendering home page
        $this->updateRendered($blogs, 'promoted');


        if (!empty($blogs)) {
            $blogs = $blogs[0];
        }
        $this->set('blog', $blogs);
    }

    public function updated() {
        $this->loadModel('Blogs');

        $rendered = $this->getRendered(['featured', 'promoted']);
        $blogs = $this->Blogs->find('updated', ['rendered' => $rendered])->toArray();

        // Add in mark as render to avoid duplicate rendering home page
        $this->updateRendered($blogs, 'updated');

        $this->set('blogs', $blogs);
    }

    public function updateRendered($blogs, $type) {
        $blogIds = array();
        if (!empty($blogs)) {
            $blogIds = Hash::combine($blogs, '{n}.id', '{n}.id');
        }
        $session = $this->request->session();
        $session->write('HomeRendered.' . $type, $blogIds);
    }

    public function getRendered($types) {
        $session = $this->request->session();
        $rendered = array();
        foreach ($types as $type) {
            if ($session->check('HomeRendered.' . $type)) {
                $rendered = array_merge($rendered, $session->read('HomeRendered.' . $type));
            }
        }
        return array_unique($rendered);
    }

    public function blogsByCategory($category, $limit, $block, $notIn = array()) {
        $this->loadModel('Blogs');
        if (empty($notIn)) {
            $rendered = $this->getRendered(['featured', 'promoted', 'updated']);
        } else {
            $rendered = $notIn;
        }

        $blogs = $this->Blogs->find('categoryBlogs', [
                    'rendered' => $rendered,
                    'category' => $category['id'],
                    'records' => $limit,
                    'rendered' => $rendered
                ])->toArray();

        $this->set(['blogs' => $blogs, 'category' => $category, 'block' => $block]);
    }

    public function popular() {
        $this->loadModel('Blogs');

        $rendered = $this->getRendered(['featured', 'promoted', 'updated']);
        $blogs = $this->Blogs->find('popular', ['rendered' => $rendered])->toArray();

        // Add in mark as render to avoid duplicate rendering home page
        $this->updateRendered($blogs, 'popular');

        $this->set('blogs', $blogs);
    }

    public function magzines($limit, $notIn = null) {
        $this->loadModel('Magazines');

        $rendered = $notIn;


        $magazines = $this->Magazines->find('all', [
                    'conditions' => ['id !=' => $rendered ],
                    'limit' => 9,
                ])->toArray();

        $this->set(['magazines' => $magazines]);
    }

}
