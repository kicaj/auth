<?php
namespace Auth\Model\Table;

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
    }

    /**
     * {@inheritDoc}
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email'], __d('admin', 'The e-mail address has already been registered.')));

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
            ->allowEmptyString('email', __d('admin', 'Address e-mail is required.'))
            ->email('email', true, __d('admin', 'Address e-mail is incorrect.'));

        $validator
            ->requirePresence('password', 'create', __d('admin', 'Password is required.'))
            ->allowEmptyString('password', __d('admin', 'Password cannot be empty.'));

        $validator
            ->requirePresence('password_confirm', 'create', __d('admin', 'Confirm password is required.'))
            ->allowEmptyString('password_confirm', __d('admin', 'Confirm password cannot be empty.'))
            ->add('password_confirm', [
                'compare' => [
                    'rule' => ['compareWith', 'password'],
                    'message' => __d('admin', 'Passwords are not identical.'),
                ],
            ]);

        return $validator;
    }
}
