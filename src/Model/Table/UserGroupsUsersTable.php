<?php
namespace Auth\Model\Table;

use Cake\ORM\Table;

class UserGroupsUsersTable extends Table
{

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('auth_user_groups_auth_users');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Users');
        $this->belongsToMany('UserGroups');
    }
}
