<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Afspraak extends Model
{
    /**
     * Get all active appointments via stored procedure.
     */
    public function getAll(): array
    {
        return DB::select('CALL GetAllAfspraken()');
    }

    /**
     * Get detailed appointment data by ID including rowsets for active employees and treatments.
     */
    public function getDetailsById(int $id): array
    {
        $pdo = DB::connection()->getPdo();
        $stmt = $pdo->prepare('CALL GetAfspraakById(?)');
        $stmt->execute([$id]);

        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $afspraak = ! empty($results) ? $results[0] : null;

        $stmt->nextRowset();
        $medewerkers = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $stmt->nextRowset();
        $behandelingen = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $stmt->closeCursor();

        return [$afspraak, $medewerkers, $behandelingen];
    }

    /**
     * Update an appointment via stored procedure.
     */
    public function updateViaProcedure(
        int $id,
        int $medewerkerId,
        int $behandelingId,
        string $datum,
        string $starttijd,
        string $status
    ): void {
        DB::update('CALL UpdateAfspraak(?, ?, ?, ?, ?, ?)', [
            $id,
            $medewerkerId,
            $behandelingId,
            $datum,
            $starttijd,
            $status,
        ]);
    }

    /**
     * Get existing active appointments for a medewerker on a date to check for overlaps.
     */
    public function getExistingAppointmentsForCollision(int $medewerkerId, string $datum, int $excludeAfspraakId): array
    {
        return DB::select('CALL GetExistingAppointmentsForCollision(?, ?, ?)', [
            $medewerkerId,
            $datum,
            $excludeAfspraakId,
        ]);
    }

    /**
     * Get the duration in minutes for a specific treatment.
     */
    public function getTreatmentDuration(int $behandelingId): int
    {
        $result = DB::select('SELECT Duurminuten FROM Behandeling WHERE Id = ? LIMIT 1', [$behandelingId]);

        return ! empty($result) ? (int) $result[0]->Duurminuten : 30;
    }
}
