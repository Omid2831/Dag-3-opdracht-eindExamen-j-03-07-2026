<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class Product extends Model
{
    /**
     * Fetch all products, optionally filtered by category.
     *
     * @param int|null $categoryId
     * @return array
     */
    public function getAllProducts(?int $categoryId = null): array
    {
        try {
            $results = DB::select('CALL SP_Product_Read(?, ?)', [null, $categoryId]);
            Log::info('Successfully fetched products via SP_Product_Read');
            return $results ?? [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch products: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch a single product by its ID.
     *
     * @param int $id
     * @return object
     */
    public function getProductById(int $id): object
    {
        try {
            $results = DB::select('CALL SP_Product_Read(?, ?)', [$id, null]);
            Log::info("Successfully fetched product ID {$id} via SP_Product_Read");
            return $results[0] ?? (object)[];
        } catch (\Exception $e) {
            Log::error("Failed to fetch product ID {$id}: " . $e->getMessage());
            return (object)[];
        }
    }

    /**
     * Update product expiration date.
     *
     * @param int $id
     * @param string $houdbaarheidsdatum
     * @return bool
     */
    public function updateProductExpiration(int $id, string $houdbaarheidsdatum): bool
    {
        try {
            DB::statement('CALL SP_Product_Update(?, ?)', [$id, $houdbaarheidsdatum]);
            Log::info("Successfully updated product ID {$id} via SP_Product_Update");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to update product ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Paginate an array of items manually.
     *
     * @param array $items
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(array $items, int $perPage = 4): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = collect($items);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();

        $paginated = new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return $paginated->withQueryString();
    }
}
