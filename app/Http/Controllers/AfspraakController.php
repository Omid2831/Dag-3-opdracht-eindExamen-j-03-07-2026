<?php

namespace App\Http\Controllers;

use App\Models\Afspraak;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AfspraakController extends Controller
{
    public function __construct(protected Afspraak $afspraakModel) {}

    public function index(Request $request): View
    {
        $afsprakenList = $this->afspraakModel->getAll();

        $selectedStatus = $request->query('status');

        if ($selectedStatus && $selectedStatus !== 'Alle statussen') {
            $afsprakenList = array_filter($afsprakenList, function ($afspraak) use ($selectedStatus) {
                return strtolower($afspraak->Status) === strtolower($selectedStatus);
            });
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 4;
        $currentItems = array_slice($afsprakenList, ($currentPage - 1) * $perPage, $perPage);

        $afspraken = new LengthAwarePaginator(
            $currentItems,
            count($afsprakenList),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('admin.afspraken', compact('afspraken', 'selectedStatus'));
    }

    public function show(int $id): View
    {
        [$afspraak, $medewerkers, $behandelingen] = $this->afspraakModel->getDetailsById($id);

        if (! $afspraak) {
            abort(404);
        }

        return view('admin.afspraak_details', compact('afspraak'));
    }

    public function edit(int $id): View
    {
        [$afspraak, $medewerkers, $behandelingen] = $this->afspraakModel->getDetailsById($id);

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

        $medewerkerId = $request->input('medewerker_id');
        $behandelingId = $request->input('behandeling_id');
        $datum = $request->input('datum');
        $starttijd = $request->input('starttijd');

        // Fetch duration of the selected treatment to calculate end time
        $duration = $this->afspraakModel->getTreatmentDuration($behandelingId);

        $newStart = strtotime("$datum $starttijd");
        $newEnd = $newStart + ($duration * 60);

        // Fetch other active appointments for this medewerker on this date
        $existingAppointments = $this->afspraakModel->getExistingAppointmentsForCollision($medewerkerId, $datum, $id);

        $hasCollision = false;
        foreach ($existingAppointments as $existing) {
            $existStart = strtotime("$datum {$existing->Starttijd}");
            $existEnd = $existStart + ($existing->Duurminuten * 60);

            if ($newStart < $existEnd && $newEnd > $existStart) {
                $hasCollision = true;
                break;
            }
        }

        if ($hasCollision) {
            throw ValidationException::withMessages([
                'datum' => 'De medewerker heeft al een afspraak op de gekozen datum en tijd',
                'starttijd' => 'Kies een ander tijdstip voor deze medewerker',
            ]);
        }

        $this->afspraakModel->updateViaProcedure(
            $id,
            $medewerkerId,
            $behandelingId,
            $datum,
            $starttijd,
            $request->input('status')
        );

        return redirect()->route('admin.afspraken.show', $id)
            ->with('success', 'Afspraak bijgewerkt');
    }
}
