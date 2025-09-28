<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $hasher = new DefaultPasswordHasher();

        $data = [
            [
                'email' => 'admin@example.com',
                'password' => $hasher->hash('1234'), // contraseña admin
                'role' => 'admin',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'email' => 'josh_estudiante@example.com',
                'password' => $hasher->hash('123'), // contraseña estudiante
                'role' => 'estudiante',
                'active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
