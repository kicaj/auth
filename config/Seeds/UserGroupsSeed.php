<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * User groups seed.
 */
class UserGroupsSeed extends AbstractSeed
{
    /**
     * Run method.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'group' => 'admin',
                'name' => 'Administrator',
                'created' => '2020-01-16 22:53:33',
                'modified' => '2020-02-17 17:10:47',
            ],
        ];

        $this
            ->table('auth_user_groups')
            ->insert($data)
            ->save();
    }
}
