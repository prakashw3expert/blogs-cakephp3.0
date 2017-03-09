<?php

namespace Settings\Model\Table;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Symfony\Component\Yaml\Yaml;

/**
 * Setting
 *
 * @category Model
 * @package  Croogo.Settings.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class SettingsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        parent::initialize($config);
        $this->settingsPath = ROOT . DS . 'config' . DS . 'settings.yml';
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('key')
                ->notEmpty('name', 'Please fill this field')
                ->add('key', [
                    'minLength' => [
                        'rule' => ['minLength', 3],
                        'last' => true,
                        'message' => __('Enter mininum 3 chars.')
                    ],
                    'maxLength' => [
                        'rule' => ['maxLength', 250],
                        'message' => 'Comments cannot be too long.'
                    ]
                ])
                ->requirePresence('value')
                ->add('body', 'length', [
                    'rule' => ['minLength', 50],
                    'message' => 'Articles must have a substantial body.'
        ]);
        return $validator;
    }

    // In a table class
    public function buildRules(RulesChecker $rules) {
        // Add a rule that is applied for create and update operations
        //$rules->add($rules->isUnique(['email']));
        $rules->add(new isUnique(['key']), 'isUniqueKey', [
            'errorField' => 'key',
            'message' => 'This is already used.'
        ]);


        return $rules;
    }

    /**
     * beforeSave callback
     */
    public function beforeSave() {
        $this->connection()->driver()->autoQuoting(true);
    }

    /**
     * afterSave callback
     */
    public function afterSaveCommit() {
        $this->updateJson();
    }

    public function afterSave() {
        $this->updateJson();
    }

    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete() {
        $this->updateJson();
    }

    /**
     * Find list and save yaml dump in app/Config/settings.yml file.
     * Data required in bootstrap.
     *
     * @return void
     */
    public function updateJson() {
        $settings = $this->find('all', array(
            'fields' => array(
                'key',
                'value',
            ),
            'order' => array(
                'Settings.key' => 'ASC',
            ),
        ));

        $settings = array_combine(
                collection($settings)->extract('key')->toArray(), collection($settings)->extract('value')->toArray()
        );
        
        $settings = Yaml::dump($settings);
        file_put_contents($this->settingsPath, $settings);

        Configure::load('settings', 'settings');
    }

}
