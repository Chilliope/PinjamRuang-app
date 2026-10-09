<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'fullname' => 'Admin Pinjam Ruang',
                'email' => 'admin@pinjamruang.test',
                'role' => 'admin',
                'password' => 'password'
            ],
            [
                'fullname' => 'Staff Pinjam Ruang',
                'email' => 'staff@pinjamruang.test',
                'role' => 'staff',
                'password' => 'password'
            ],
            [
                'fullname' => 'Class Representative Pinjam Ruang',
                'email' => 'classrep@pinjamruang.test',
                'role' => 'class_representative',
                'password' => 'password'
            ],
        ];

        foreach($users as $user) {
            User::create([
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => $user['password']
            ]);
        }
    }
}
