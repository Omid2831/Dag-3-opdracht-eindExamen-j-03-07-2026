<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AfspraakController extends Controller
{
    public function index(Request $request): View
    {
        $afsprakenList = DB::select('CALL GetAllAfspraken()');

        $selectedStatus = $request->query('status');

        if ($selectedStatus && $selectedStatus !== 'Alle statussen') {
            $afsprakenList = array_filter($afsprakenList, function ($afspraak) use ($selectedStatus) {
                return strtolower($afspraak->Status) === strtolower($selectedStatus);
            });
        }

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 4;
        $currentItems = array_slice($afsprakenList, ($currentPage - 1) * $perPage, $perPage);

        $afspraken = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            count($afsprakenList),
            $perPage,
            $currentPage,
            [
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('admin.afspraken', compact('afspraken', 'selectedStatus'));
    }

    public function show(int $id): View
    {
        [$afspraak, $medewerkers, $behandelingen] = $this->getAfspraakData($id);

        if (! $afspraak) {
            abort(404);
        }

        return view('admin.afspraak_details', compact('afspraak'));
    }

    public function edit(int $id): View
    {
        [$afspraak, $medewerkers, $behandelingen] = $this->getAfspraakData($id);

        if (! $afspraak) {
            abort(404);
        }

        return view('admin.afspraak_edit', compact('afspraak', 'medewerkers', 'behandelingen'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'medewerker_id' => 'required',
            'behandeling_id' => 'required',
            'datum' => 'required|date',
            'starttijd' => 'required',
            'status' => 'required',
        ]);

        DB::update('CALL UpdateAfspraak(?, ?, ?, ?, ?, ?)', [
            $id,
            $request->input('medewerker_id'),
            $request->input('behandeling_id'),
            $request->input('datum'),
            $request->input('starttijd'),
            $request->input('status'),
        ]);

        return redirect()->route('admin.afspraken.show', $id)
            ->with('success', 'Afspraak bijgewerkt');
    }

    private function getAfspraakData(int $id): array
    {
        $pdo = DB::connection()->getPdo();
        $stmt = $pdo->prepare('CALL GetAfspraakById(?)');
        $stmt->execute([$id]);

        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $afspraak = ! empty($results) ? $results[0] : null;

        $stmt->nextRowset();
        $medewerkers = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $stmt->nextRowset();
        $behandelingen = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $stmt->closeCursor();

        return [$afspraak, $medewerkers, $behandelingen];
    }
}
