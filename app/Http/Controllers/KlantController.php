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
        $postcode = $request->input('postcode');
        $klanten = $this->klantModel->read($postcode);

        // Client-side pagination (4 items per page)
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
        $klant = $this->klantModel->readById($id);

        if (empty((array)$klant)) {
            return redirect()
                ->route('klant.index')
                ->with('error', 'Customer not found.');
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
        $klant = $this->klantModel->readById($id);

        if (empty((array)$klant)) {
            return redirect()
                ->route('klant.index')
                ->with('error', 'Customer not found.');
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
        $request->validate([
            'Voornaam' => 'required|string|max:50',
            'Tussenvoegsel' => 'nullable|string|max:20',
            'Achternaam' => 'required|string|max:50',
            'Bijzonderheden' => 'required|string|max:255',
            'Straatnaam' => 'required|string|max:100',
            'Huisnummer' => 'required|integer',
            'Toevoeging' => 'nullable|string|max:10',
            'Postcode' => 'required|string|max:10',
            'Plaats' => 'required|string|max:50',
            'Email' => 'required|email|max:100',
            'Mobiel' => 'required|string|max:20',
        ]);

        // Uniqueness validation on contact email
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

        $success = $this->klantModel->update($id, $request->all());

        if ($success) {
            return redirect()
                ->route('klant.index')
                ->with('success', 'Klantgegevens bijgewerkt.');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Klantgegevens zijn niet bijgewerkt.');
    }
}
