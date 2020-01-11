<?php
namespace Auth\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class UsersTable extends Table
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('auth_users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('UserGroups', [
            'className' => 'Auth.UserGroups',
            'targetForeignKey' => 'auth_user_group_id',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules
            ->add($rules->isUnique(['email'], __d('auth', 'The e-mail address has already been registered.')));

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('email', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('email', __d('auth', 'This field cannot be left empty.'))
            ->email('email', __d('auth', 'This value is incorrect.'));

        $validator
            ->requirePresence('password', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('password', __d('auth', 'This field cannot be left empty.'), 'update');

        $validator
            ->requirePresence('password_confirm', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('password_confirm', __d('auth', 'This field cannot be left empty.'), 'update')
            ->add('password_confirm', [
                'compare' => [
                    'rule' => ['compareWith', 'password'],
                    'message' => __d('auth', 'These passwords are not the same.'),
                ],
            ]);

        return $validator;
    }

    /**
     * Forgotten password validation.
     *
     * @param Validator $validator Validations.
     */
    public function validationForgot(Validator $validator)
    {
        $validator
            ->requirePresence('email', 'create', __d('auth', 'This field is required.'))
            ->allowEmptyString('email', __d('auth', 'This field cannot be left empty.'))
            ->email('email', __d('auth', 'This value is incorrect.'));

        return $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave(Event $event, EntityInterface $entity, $options)
    {
        if ($entity->isNew()) {
            $entity->uuid = Text::uuid();
        }
    }

    /**
     * Auth finder method.
     *
     * @param Query $query Query params.
     * @param array $options Additional options.
     */
    public function findAuth(Query $query, array $options)
    {
        return $query->where([
            'Users.status' => 1,
        ])->contain([
            'UserGroups' => function ($user_groups) {
                return $user_groups->select([
                    'group',
                    'name',
                ]);
            },
        ]);
    }
}
