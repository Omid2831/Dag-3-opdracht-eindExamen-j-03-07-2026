<?php

namespace App\Http\Controllers;

use App\Models\Behandeling;
use Illuminate\Http\Request;

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
        $query = $this->behandelingModel
            ->newQuery()
            ->withCount('behandelingPerVoorraad as aantal_producten');

        if ($request->filled('soort')) {
            $query->where('Naam', $request->soort);
        }

        $behandelingen = $query->paginate(4)->withQueryString();

        return view('admin.behandelingen', compact('behandelingen'));
    }
}
