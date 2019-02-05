<?php
namespace Auth\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserGroupsTable extends Table
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('auth_user_groups');
        $this->setDisplayField('group');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addAssociations([
            'belongsToMany' => [
                'Users',
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['group'], __d('auth', 'The group has already been registered.')));

        return $rules;
    }

    /**
     * Default validation
     *
     * @param Validator $validator Validations
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('group', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('group', false, __d('auth', 'This field cannot be left empty.'));

        return $validator;
    }
}
