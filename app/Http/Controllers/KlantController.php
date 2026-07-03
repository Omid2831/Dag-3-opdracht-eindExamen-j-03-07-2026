<?php

namespace App\Http\Controllers;

use App\Models\KlantModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KlantController extends Controller
{
    /**
     * @var KlantModel
     */
    protected $klantModel;

    /**
     * KlantController constructor.
     *
     * @param KlantModel $klantModel
     */
    public function __construct(KlantModel $klantModel)
    {
        // Model injectie via constructor
        $this->klantModel = $klantModel;
    }

    /**
     * Display a listing of active customers, optionally filtered by postcode.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Zoekterm voor postcode ophalen uit het GET-request
        $postcode = $request->input('postcode');
        $klanten = $this->klantModel->read($postcode);

        // Omdat we stored procedures gebruiken doen we handmatige paginering (4 per pagina)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 4;
        $col = collect($klanten);
        $items = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $paginated = new LengthAwarePaginator(
            $items,
            $col->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query()
            ]
        );

        return view('klant.index', [
            'klanten' => $paginated,
            'postcode' => $postcode
        ]);
    }

    /**
     * Display details of a single customer.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id)
    {
        // Haal klant details op via de readById methode in het model
        $klant = $this->klantModel->readById($id);

        if (empty((array)$klant)) {
            return redirect()
                ->route('klant.index')
                ->with('error', 'Klant niet gevonden.');
        }

        return view('klant.show', compact('klant'));
    }

    /**
     * Show the form for editing customer details.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        // Details ophalen om het wijzigingsformulier vooraf in te vullen
        $klant = $this->klantModel->readById($id);

        if (empty((array)$klant)) {
            return redirect()
                ->route('klant.index')
                ->with('error', 'Klant niet gevonden.');
        }

        return view('klant.edit', compact('klant'));
    }

    /**
     * Update customer details in the database.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Valideer alle invoervelden van het formulier
        $request->validate([
            'Naam' => 'required|string|max:100',
            'Bijzonderheden' => 'required|string|max:255',
            'Straatnaam' => 'required|string|max:100',
            'Huisnummer' => 'required|integer',
            'Toevoeging' => 'nullable|string|max:10',
            'Postcode' => 'required|string|max:10',
            'Plaats' => 'required|string|max:50',
            'Email' => 'required|email|max:100',
            'Mobiel' => 'required|string|max:20',
        ]);

        // Handmatige uniekheidscontrole op e-mailadres voor andere actieve klanten
        $existing = DB::select('
            SELECT 1 FROM Contact c
            JOIN KlantPerContact kpc ON c.Id = kpc.ContactId
            WHERE c.Email = ? AND kpc.KlantId <> ? AND c.IsActief = 1
        ', [$request->input('Email'), $id]);

        if (!empty($existing)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Email' => 'Het e-mailadres is al in gebruik'])
                ->with('error', 'Klantgegevens zijn niet bijgewerkt.');
        }

        // De ingevoerde naam splitsen we op de eerste spatie in Voornaam en Achternaam
        $name = $request->input('Naam');
        $parts = explode(' ', trim($name), 2);
        $voornaam = $parts[0];
        $tussenvoegsel = null;
        $achternaam = $parts[1] ?? '';

        $data = [
            'Voornaam' => $voornaam,
            'Tussenvoegsel' => $tussenvoegsel,
            'Achternaam' => $achternaam,
            'Bijzonderheden' => $request->input('Bijzonderheden') ?? '',
            'Straatnaam' => $request->input('Straatnaam'),
            'Huisnummer' => $request->input('Huisnummer'),
            'Toevoeging' => $request->input('Toevoeging'),
            'Postcode' => $request->input('Postcode'),
            'Plaats' => $request->input('Plaats'),
            'Email' => $request->input('Email'),
            'Mobiel' => $request->input('Mobiel')
        ];

        // Voer de update uit via de model methode
        $success = $this->klantModel->update($id, $data);

        if ($success) {
            return redirect()
                ->route('admin.klanten')
                ->with('success', 'Klantgegevens bijgewerkt.');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Klantgegevens zijn niet bijgewerkt.');
    }
}
