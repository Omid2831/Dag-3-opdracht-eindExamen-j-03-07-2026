<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
      $users = [
        [
            'name' => 'Mike Smith',
            'email' => 'mike@test.nl',
            'role' => 'admin'
        ],
        [
            'name' => 'John Doe',
            'email' => 'john@test.nl',
            'role' => 'user'
        ],
        [
            'name' => 'Jane Doe',
            'email' => 'jane@test.nl',
            'role' => 'user'
        ]
      ];

        foreach ($users as $user)
        {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => bcrypt('password')
                ]
            );
        }

    }
}
