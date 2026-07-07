<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Producten extends Model
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

    public static function updatePrice(int $id, float $newPrice): object
    {
        try {
            DB::statement('CALL UpdateProductVerkoopprijs(?, ?)', [$id, $newPrice]);

            $result = new \stdClass;
            $result->success = 1;
            $result->message = 'De prijs van het product is succesvol gewijzigd.';

            return $result;
        } catch (\Exception $e) {
            Log::error('Error in UpdateProductVerkoopprijs: '.$e->getMessage());

            $result = new \stdClass;
            $result->success = 0;

            $message = $e->getMessage();
            if (strpos($message, 'SQLSTATE[45000]:') !== false) {
                $parts = explode('SQLSTATE[45000]:', $message);
                $msg = trim($parts[1]);
                if (strpos($msg, ' (Connection:') !== false) {
                    $msgParts = explode(' (Connection:', $msg);
                    $msg = trim($msgParts[0]);
                }
                // Strip custom database error prefixes like "<<Unknown error>>: 1644" or "1644"
                $msg = preg_replace('/^(<<Unknown error>>:\s*)?\d+\s*/i', '', $msg);
                $message = $msg;
            }

            $result->message = $message;

            return $result;
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
