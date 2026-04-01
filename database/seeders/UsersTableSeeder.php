<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed users based on PT IKE organizational roles.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'IKE Administrator',
                'email' => 'admin@ike.co.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Fajar Pratama - Project Manager',
                'email' => 'pm@ike.co.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Nadia Putri - HSE Officer',
                'email' => 'hse@ike.co.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Bima Saputra - Warehouse Lead',
                'email' => 'warehouse@ike.co.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Rizky Ananda - Field Engineer',
                'email' => 'engineer@ike.co.id',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
