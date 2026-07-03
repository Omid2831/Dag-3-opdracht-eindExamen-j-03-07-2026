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
