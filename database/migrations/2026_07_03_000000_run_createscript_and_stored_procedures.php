<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Seed users first so foreign key constraints in createscript.sql are satisfied
        $users = [
            ['id' => 1, 'name' => 'Salon Eigenaar', 'email' => 'eigenaar@kniplokettiko.nl', 'role' => 'eigenaar'],
            ['id' => 2, 'name' => 'Fatima El Amrani', 'email' => 'fatima@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 3, 'name' => 'Sanne de Vries', 'email' => 'sanne.devries@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 4, 'name' => 'Mohamed El Idrissi', 'email' => 'mohamed.elidrissi@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 5, 'name' => 'Lisa van Dijk', 'email' => 'lisa.vandijk@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 6, 'name' => 'Youssef Benali', 'email' => 'youssef.benali@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 7, 'name' => 'Noor Bakker', 'email' => 'noor.bakker@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 8, 'name' => 'Kevin Smit', 'email' => 'kevin.smit@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 9, 'name' => 'Aylin Demir', 'email' => 'aylin.demir@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 10, 'name' => 'Tom Verhoeven', 'email' => 'tom.verhoeven@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 11, 'name' => 'Romy Jacobs', 'email' => 'romy.jacobs@kniplokettiko.nl', 'role' => 'medewerker'],
            ['id' => 12, 'name' => 'Piet van Loenen', 'email' => 'piet.van.loenen@gmail.com', 'role' => 'klant'],
            ['id' => 13, 'name' => 'Jan Jansen', 'email' => 'jan.jansen@outlook.com', 'role' => 'klant'],
            ['id' => 14, 'name' => 'Saskia de Boer', 'email' => 'saskia.deboer@yahoo.com', 'role' => 'klant'],
            ['id' => 15, 'name' => 'Ahmed Mansouri', 'email' => 'ahmed.mansouri@icloud.com', 'role' => 'klant'],
            ['id' => 16, 'name' => 'Marieke van den Berg', 'email' => 'marieke.vandenberg@ziggo.nl', 'role' => 'klant'],
            ['id' => 17, 'name' => 'Daan Visser', 'email' => 'daan.visser@live.nl', 'role' => 'klant'],
        ];

        foreach ($users as $u) {
            DB::table('users')->insertOrIgnore([
                'id' => $u['id'],
                'name' => $u['name'],
                'email' => $u['email'],
                'role' => $u['role'],
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 1. Run database/createscript.sql
        $createscriptPath = base_path('database/createscript.sql');
        if (file_exists($createscriptPath)) {
            $sql = file_get_contents($createscriptPath);
            
            // Remove database selection/altering statements so it runs on current DB connection
            $sql = preg_replace('/^USE\s+\w+;/i', '', $sql);
            $sql = preg_replace('/^ALTER DATABASE\s+.*$/im', '', $sql);
            
            DB::unprepared($sql);
        }

        // 2. Load stored procedures from database/stored-procedure/AndreiSP/ folder
        $path = base_path("database/stored-procedure/AndreiSP/*.sql");
        $files = glob($path);
        foreach ($files as $file) {
            $procSql = file_get_contents($file);
            if (trim($procSql) === '') {
                continue;
            }

            // Strip DELIMITER statements for Laravel prepared statement execution
            $procSql = preg_replace('/^\s*DELIMITER\s+\S+\s*$/m', '', $procSql);
            $procSql = preg_replace('/END\s*\/\/\s*$/m', 'END', $procSql);
            $procSql = str_replace('//', '', $procSql);
            $procSql = trim($procSql);

            // Drop the procedure if exists
            if (preg_match('/DROP PROCEDURE IF EXISTS \w+;/i', $procSql, $dropMatches)) {
                try { DB::unprepared($dropMatches[0]); } catch (Exception $e) {}
            }

            // Create the procedure
            $createSql = preg_replace('/DROP PROCEDURE IF EXISTS \w+;/i', '', $procSql);
            try {
                DB::unprepared($createSql);
            } catch (Exception $e) {}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Simply drop the tables if rolled back
        Schema::dropIfExists('LeverancierOrder');
        Schema::dropIfExists('BehandelingPerVoorraad');
        Schema::dropIfExists('Afspraak');
        Schema::dropIfExists('KlantPerContact');
        Schema::dropIfExists('MedewerkerPerContact');
        Schema::dropIfExists('MedewerkerPerBehandeling');
        Schema::dropIfExists('Beschikbaarheid');
        Schema::dropIfExists('Klant');
        Schema::dropIfExists('Medewerker');
        Schema::dropIfExists('Voorraad');
        Schema::dropIfExists('Product');
        Schema::dropIfExists('Leverancier');
        Schema::dropIfExists('Behandeling');
        Schema::dropIfExists('Contact');
        Schema::dropIfExists('Categorie');
    }
};
