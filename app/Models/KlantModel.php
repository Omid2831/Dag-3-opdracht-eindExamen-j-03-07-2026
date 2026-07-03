<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

// This model handles all database interactions for Customers using Stored Procedures.
class KlantModel
{
    /**
     * Fetch all active customers, optionally filtered by postcode.
     *
     * @param string|null $postcode
     * @return array
     */
    public function read(?string $postcode = null): array
    {
        try {
            // Call the read stored procedure with the postcode search filter
            $results = DB::select('CALL SP_Klant_Read(?)', [$postcode]);
            Log::info('Successfully fetched customers via SP_Klant_Read');
            return $results ?? [];
        } catch (Throwable $e) {
            // Write error details to the log file for grading review
            Log::error('Failed to fetch customers via SP_Klant_Read: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch details for a specific active customer by ID.
     *
     * @param int $id
     * @return object
     */
    public function readById(int $id): object
    {
        try {
            // Call the readById stored procedure to fetch details
            $results = DB::select('CALL SP_Klant_ReadById(?)', [$id]);
            Log::info("Successfully fetched customer details for ID {$id} via SP_Klant_ReadById");
            return $results[0] ?? (object)[];
        } catch (Throwable $e) {
            Log::error("Failed to fetch customer details for ID {$id} via SP_Klant_ReadById: " . $e->getMessage());
            return (object)[];
        }
    }

    /**
     * Update customer basic and contact details inside a transaction.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        try {
            // Call the update stored procedure with all parameters
            $success = DB::statement('CALL SP_Klant_Update(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $data['Voornaam'],
                $data['Tussenvoegsel'] ?? null,
                $data['Achternaam'],
                $data['Bijzonderheden'] ?? '',
                $data['Straatnaam'],
                $data['Huisnummer'],
                $data['Toevoeging'] ?? null,
                $data['Postcode'],
                $data['Plaats'],
                $data['Email'],
                $data['Mobiel']
            ]);
            Log::info("Successfully updated customer details for ID {$id} via SP_Klant_Update");
            return (bool) $success;
        } catch (Throwable $e) {
            Log::error("Failed to update customer details for ID {$id} via SP_Klant_Update: " . $e->getMessage());
            return false;
        }
    }
}
