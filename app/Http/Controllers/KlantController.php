<?php

namespace App\Http\Controllers;

use App\Models\KlantModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class KlantController extends Controller
{
    /**
     * @var KlantModel
     */
    protected $klantModel;

    /**
     * KlantController constructor.
     */
    public function __construct(KlantModel $klantModel)
    {
        // Inject model dependency via constructor
        $this->klantModel = $klantModel;
    }

    /**
     * Display a listing of active customers, optionally filtered by postcode.
     */
    public function index(Request $request): View
    {
        // Get postcode search parameter from GET request
        $postcode = $request->input('postcode');
        $klanten = $this->klantModel->read($postcode) ?? [];

        // Handle collection pagination manually since we call raw stored procedures (4 items per page)
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
                'query' => $request->query(),
            ]
        );

        return view('klant.index', [
            'klanten' => $paginated,
            'postcode' => $postcode,
        ]);
    }

    /**
     * Display details of a single customer.
     *
     * @return View|RedirectResponse
     */
    public function show(int $id)
    {
        // Retrieve customer details using readById method from model
        $klant = $this->klantModel->readById($id) ?? [];

        if (empty((array) $klant)) {
            return redirect()
                ->route('admin.klanten')
                ->with('error', 'Klant niet gevonden.');
        }

        return view('klant.show', compact('klant'));
    }

    /**
     * Show the form for editing customer details.
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        // Retrieve existing customer details to prefill form fields
        $klant = $this->klantModel->readById($id) ?? [];

        if (empty((array) $klant)) {
            return redirect()
                ->route('admin.klanten')
                ->with('error', 'Klant niet gevonden.');
        }

        return view('klant.edit', compact('klant'));
    }

    /**
     * Update customer details in the database.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Run validations on all submitted form fields
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

        // Manually check if the email is already taken by another active contact
        $existing = $this->klantModel->getExistingActiveContactByEmail($request->input('Email'), $id) ?? [];

        if (! empty($existing)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['Email' => 'Het e-mailadres is al in gebruik'])
                ->with('error', 'Klantgegevens zijn niet bijgewerkt.');
        }

        // Split submitted full name by first space to extract Voornaam and Achternaam
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
            'Mobiel' => $request->input('Mobiel'),
        ];

        // Execute update on customer details using model
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
