<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * User groups and users seed.
 */
class UserGroupsUsersSeed extends AbstractSeed
{
    /**
     * Return seeds dependencies.
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'UsersSeed',
            'UserGroupsSeed',
        ];
    }
    
    /**
     * Run method.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'auth_user_id' => 1,
                'auth_user_group_id' => 1,
            ],
        ];

        $this
            ->table('auth_user_groups_auth_users')
            ->insert($data)
            ->save();
    }
}
