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
        // Truncate users table to reset auto-increment IDs and avoid foreign key issues
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        User::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // 1. Seed users first (needed for foreign key constraints in createscript.sql)
        $users = [
            [
                'name' => 'Salon Eigenaar',
                'email' => 'eigenaar@kniplokettiko.nl',
                'role' => 'eigenaar',
            ],
            [
                'name' => 'Fatima El Amrani',
                'email' => 'fatima@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Sanne de Vries',
                'email' => 'sanne.devries@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Mohamed El Idrissi',
                'email' => 'mohamed.elidrissi@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Lisa van Dijk',
                'email' => 'lisa.vandijk@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Youssef Benali',
                'email' => 'youssef.benali@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Noor Bakker',
                'email' => 'noor.bakker@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Kevin Smit',
                'email' => 'kevin.smit@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Aylin Demir',
                'email' => 'aylin.demir@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Tom Verhoeven',
                'email' => 'tom.verhoeven@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Romy Jacobs',
                'email' => 'romy.jacobs@kniplokettiko.nl',
                'role' => 'medewerker',
            ],
            [
                'name' => 'Piet van Loenen',
                'email' => 'piet.van.loenen@gmail.com',
                'role' => 'klant',
            ],
            [
                'name' => 'Jan Jansen',
                'email' => 'jan.jansen@outlook.com',
                'role' => 'klant',
            ],
            [
                'name' => 'Saskia de Boer',
                'email' => 'saskia.deboer@yahoo.com',
                'role' => 'klant',
            ],
            [
                'name' => 'Ahmed Mansouri',
                'email' => 'ahmed.mansouri@icloud.com',
                'role' => 'klant',
            ],
            [
                'name' => 'Marieke van den Berg',
                'email' => 'marieke.vandenberg@ziggo.nl',
                'role' => 'klant',
            ],
            [
                'name' => 'Daan Visser',
                'email' => 'daan.visser@live.nl',
                'role' => 'klant',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => bcrypt('password'),
                ]
            );
        }

        // 2. Run createscript.sql
        $createScriptPath = database_path('createscript.sql');
        if (file_exists($createScriptPath)) {
            $sql = file_get_contents($createScriptPath);
            // Remove 'USE kapsalon_db;' statement so it runs on whatever DB is configured (e.g. testing)
            $sql = preg_replace('/^\s*USE\s+[a-zA-Z0-9_]+;\s*/i', '', $sql);
            \Illuminate\Support\Facades\DB::unprepared($sql);
        }

        // 3. Load stored procedures
        $spPath = database_path('store-procedures/OmidSP/*.sql');
        foreach (glob($spPath) as $file) {
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents($file));
        }

    }
}
