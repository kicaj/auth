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
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('auth_user_groups');
        $this->setDisplayField('group');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Users');
    }

    /**
     * {@inheritDoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['group'], __d('auth', 'The group has already been registered.')));

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('group', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('group', false, __d('auth', 'This field cannot be left empty.'));

        return $validator;
    }
}
