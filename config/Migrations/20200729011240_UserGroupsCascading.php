<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UserGroupsCascading extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('auth_user_groups_auth_users')
            ->dropForeignKey('auth_user_id')
            ->addForeignKey(
                'auth_user_id',
                'auth_users',
                'id',
                [
                    'update' => 'NO ACTION',
                    'delete' => 'CASCADE',
                ]
            )
            ->dropForeignKey('auth_user_group_id')
            ->addForeignKey(
                'auth_user_group_id',
                'auth_user_groups',
                'id',
                [
                    'update' => 'NO ACTION',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();
    }
}
