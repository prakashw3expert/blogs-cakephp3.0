<?php

namespace Seo\Controller\Admin;

use Seo\Controller\Admin\AppController;

/**
 * SeoMetaTags Controller
 *
 * @property \Seo\Model\Table\SeoMetaTagsTable $SeoMetaTags
 */
class SeoMetaTagsController extends AppController
{
    /**
     * Initialize
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }
    
    public function index() {

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            //$this->paginate['fields'] = ['SeoMetaTags.*'];
            $this->paginate['order'] = ['SeoMetaTags.id' => 'DESC'];
            $this->paginate['contain'] = ['SeoUris' => ['fields' => array('SeoUris.uri')]];
        });
        $this->Crud->on('beforeRender', function(\Cake\Event\Event $event) {
            $this->request->data = $this->request->query;
        });

        return $this->Crud->execute();
    }

    /**
     * View method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoMetaTag = $this->SeoMetaTags->get($id, [
            'contain' => ['SeoUris']
        ]);
        $this->set('seoMetaTag', $seoMetaTag);
        $this->set('_serialize', ['seoMetaTag']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seoMetaTag = $this->SeoMetaTags->newEntity();
        if ($this->request->is('post')) {
            $seoMetaTag = $this->SeoMetaTags->patchEntity($seoMetaTag, $this->request->data);
            if ($this->SeoMetaTags->save($seoMetaTag)) {
                $this->Flash->success(__('The seo meta tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The seo meta tag could not be saved. Please, try again.'));
            }
        }
        $seoUris = $this->SeoMetaTags->SeoUris->find('list', ['limit' => 200]);
        $this->set(compact('seoMetaTag', 'seoUris'));
        $this->set('_serialize', ['seoMetaTag']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoMetaTag = $this->SeoMetaTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seoMetaTag = $this->SeoMetaTags->patchEntity($seoMetaTag, $this->request->data);
            if ($this->SeoMetaTags->save($seoMetaTag)) {
                $this->Flash->success(__('The seo meta tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The seo meta tag could not be saved. Please, try again.'));
            }
        }
        $seoUris = $this->SeoMetaTags->SeoUris->find('list', ['limit' => 200]);
        $this->set(compact('seoMetaTag', 'seoUris'));
        $this->set('_serialize', ['seoMetaTag']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Meta Tag id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoMetaTag = $this->SeoMetaTags->get($id);
        if ($this->SeoMetaTags->delete($seoMetaTag)) {
            $this->Flash->success(__('The seo meta tag has been deleted.'));
        } else {
            $this->Flash->error(__('The seo meta tag could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
