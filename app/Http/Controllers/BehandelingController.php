<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BehandelingController extends Controller
{
    protected $behandelingModel;

    public function __construct(Behandeling $behandelingModel)
    {
        $this->behandelingModel = $behandelingModel;
    }

    public function index(Request $request): View
    {
        $results = $this->behandelingModel->getAllBehandelingen() ?? [];
        $collection = collect($results);

        // I use a filter for soort if it's provided in the request
        if ($request->filled('soort')) {
            $collection = $collection->where('Soort', $request->soort)->values();
        }

        // Paginate the collection manually
        $perPage = 4;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection->forPage($currentPage, $perPage);

        $behandelingen = new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.behandelingen',
            [
                'behandelingen' => $behandelingen,
            ]);
    }

    public function getProductenByBehandeling($id)
    {
        $producten = $this->behandelingModel::getProductenByBehandeling($id) ?? [];

        return view('behandelingen.behandelingen-producten',
            [
                'producten' => $producten,
            ]);
    }

    public function show($id)
    {
        $producten = $this->behandelingModel::GetProductDetail($id) ?? [];

        return view('behandelingen.show',
            [
                'producten' => $producten,
            ]);

    }

    public function edit($id)
    {
        $producten = $this->behandelingModel::GetProductDetail($id) ?? [];

        return view('behandelingen.edit',
            [
                'producten' => $producten,
            ]);

    }

    public function update(Request $request)
{
    $request->validate(['product_id' => 'required', 'verkoopprijs' => 'required|numeric']);

    $result = Product::updatePrice($request->product_id, $request->verkoopprijs);

    // Controleer of result een object is (dus geen false/bool)
    if (is_object($result) && isset($result->success) && $result->success == 1) {
        return redirect()->back()->with('success', $result->message);
    }

    // Fallback voor als het resultaat leeg is of success 0 is
    $errorMessage = (is_object($result)) ? $result->message : 'Er is een fout opgetreden in de database.';
    
    return redirect()->back()
                     ->withErrors(['verkoopprijs' => $errorMessage])
                     ->withInput();
}
}
