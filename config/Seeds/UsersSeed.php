<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'email' => 'admin@slicesofcake.org',
                'password' => (new DefaultPasswordHasher())->hash('51ic30fC4k3'),
                'created' => '2020-01-19 21:57:46',
                'modified' => '2020-02-15 16:00:37',
            ],
        ];

        $this
            ->table('auth_users')
            ->insert($data)
            ->save();
    }
}
