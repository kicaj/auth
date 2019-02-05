<?php
namespace Auth\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('auth_users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addAssociations([
            'belongsToMany' => [
                'UserGroups' => [
                    'className' => 'Auth.UserGroups',
                    'targetForeignKey' => 'auth_user_group_id',
                ],
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email'], __d('auth', 'The e-mail address has already been registered.')));

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
            ->requirePresence('email', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('email', false, __d('auth', 'This field cannot be left empty.'))
            ->email('email', true, __d('auth', 'This value is incorrect.'));

        $validator
            ->requirePresence('password', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('password', false, __d('auth', 'This field cannot be left empty.'));

        $validator
            ->requirePresence('password_confirm', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('password_confirm', false, __d('auth', 'This field cannot be left empty.'))
            ->add('password_confirm', [
                'compare' => [
                    'rule' => ['compareWith', 'password'],
                    'message' => __d('auth', 'These passwords are not the same.'),
                ],
            ]);

        return $validator;
    }

    /**
     * Forgotten password validation
     *
     * @param Validator $validator Validations
     */
    public function validationForgot(Validator $validator)
    {
        $validator
            ->requirePresence('email', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('email', false, __d('auth', 'This field cannot be left empty.'))
            ->email('email', true, __d('auth', 'This value is incorrect.'));

        return $validator;
    }

    /**
     * Auth finder method.
     *
     * @param Query $query Query params
     * @param array $options Additional options
     */
    public function findAuth(Query $query, array $options)
    {
        return $query->where()->contain([
            'UserGroups' => function ($user_groups) {
                return $user_groups->select([
                    'group',
                    'name',
                ]);
            },
        ]);
    }
}
