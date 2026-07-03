<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $incrementing = false;

    protected $fillable = [
        'Id',
        'CategorieId',
        'Naam',
        'Omschrijving',
        'Merk',
        'EANcode',
        'Houdbaarheidsdatum',
        'InkoopPrijs',
        'VerkoopPrijs',
        'IsActief',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'InkoopPrijs' => 'decimal:2',
        'VerkoopPrijs' => 'decimal:2',
    ];

    public static function updatePrice(int $id, float $newPrice)
    {
        try {
            return DB::statement('CALL UpdateProductVerkoopprijs(?, ?)', [$id, $newPrice]);
        } catch (\Exception $e) {
            Log::error('Error in UpdateProductVerkoopprijs: '.$e->getMessage());

            throw $e;
        }
    }

    public static function getProductenByBehandeling(int $id): array
    {
        try {
            return DB::select('CALL GetProductenByBehandeling(?)', [$id]) ?? [];
        } catch (\Exception $e) {
            Log::error('Error in GetProductenByBehandeling: '.$e->getMessage());

            return [];
        }
    }

    public static function getProductDetail(int $id): array
    {
        try {
            return DB::select('CALL GetProductDetail(?)', [$id]) ?? [];
        } catch (\Exception $e) {
            Log::error('Error in GetProductDetail: '.$e->getMessage());

            return [];
        }
    }
}
