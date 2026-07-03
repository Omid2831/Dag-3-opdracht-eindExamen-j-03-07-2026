<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

// Dit model regelt alle database interactie voor Klanten via de Stored Procedures
class KlantModel
{
    /**
     * Haal alle actieve klanten op, eventueel gefilterd op postcode
     *
     * @param string|null $postcode
     * @return array
     */
    public function read(?string $postcode = null): array
    {
        try {
            // We roepen hier de read stored procedure aan met de optionele postcode filter
            $results = DB::select('CALL SP_Klant_Read(?)', [$postcode]);
            Log::info('Successfully fetched customers via SP_Klant_Read');
            return $results ?? [];
        } catch (Throwable $e) {
            // Foutmelding wegschrijven naar logbestand voor debugging tijdens examen
            Log::error('Failed to fetch customers via SP_Klant_Read: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal de details op van één specifieke actieve klant op basis van Id
     *
     * @param int $id
     * @return object
     */
    public function readById(int $id): object
    {
        try {
            // Roep de readById stored procedure aan om de details van de klant op te halen
            $results = DB::select('CALL SP_Klant_ReadById(?)', [$id]);
            Log::info("Successfully fetched customer details for ID {$id} via SP_Klant_ReadById");
            return $results[0] ?? (object)[];
        } catch (Throwable $e) {
            Log::error("Failed to fetch customer details for ID {$id} via SP_Klant_ReadById: " . $e->getMessage());
            return (object)[];
        }
    }

    /**
     * Werk de basis- en contactgegevens van de klant bij in een transactie
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        try {
            // Update stored procedure aanroepen met alle verplichte en optionele parameters
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
