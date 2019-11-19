<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('auth_user_groups')
            ->addColumn('group', 'string', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'group',
                ]
            )
            ->create();

        $this->table('auth_user_groups_auth_users')
            ->addColumn('auth_user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('auth_user_group_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'auth_user_group_id',
                ]
            )
            ->addIndex(
                [
                    'auth_user_id',
                ]
            )
            ->create();

        $this->table('auth_users')
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('uuid', 'string', [
                'default' => null,
                'limit' => 36,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => '1',
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'email',
                ]
            )
            ->addIndex(
                [
                    'uuid',
                ]
            )
            ->create();

        $this->table('auth_user_groups_auth_users')
            ->addForeignKey(
                'auth_user_group_id',
                'auth_user_groups',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'auth_user_id',
                'auth_users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('auth_user_groups_auth_users')
            ->dropForeignKey(
                'auth_user_group_id'
            )
            ->dropForeignKey(
                'auth_user_id'
            )->save();

        $this->table('auth_user_groups')->drop()->save();
        $this->table('auth_user_groups_auth_users')->drop()->save();
        $this->table('auth_users')->drop()->save();
    }
}
