<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Categorie extends Model
{
    /**
     * Fetch all active categories via SP_Categorie_Read.
     *
     * @return array
     */
    public function getAllCategories(): array
    {
        try {
            $results = DB::select('CALL SP_Categorie_Read()');
            Log::info('Successfully fetched categories via SP_Categorie_Read');
            return $results ?? [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return [];
        }
    }
}
