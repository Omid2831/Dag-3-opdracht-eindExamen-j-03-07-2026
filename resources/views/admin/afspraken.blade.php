<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Afspraken</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">
                Overzicht afspraken
            </h1>

            <!-- Filter Section -->
            <form method="GET" action="{{ route('admin.afspraken') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex justify-end items-end space-x-3">
                    <div class="flex flex-col">
                        <label for="status" class="text-xs font-semibold text-gray-500 mb-1.5">Status selecteren</label>
                        <select name="status" id="status" class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white w-64">
                            <option value="Alle statussen" {{ ($selectedStatus ?? 'Alle statussen') === 'Alle statussen' ? 'selected' : '' }}>Alle statussen</option>
                            <option value="Inbehandeling" {{ ($selectedStatus ?? '') === 'Inbehandeling' ? 'selected' : '' }}>Inbehandeling</option>
                            <option value="Behandeld" {{ ($selectedStatus ?? '') === 'Behandeld' ? 'selected' : '' }}>Behandeld</option>
                            <option value="Verzet" {{ ($selectedStatus ?? '') === 'Verzet' ? 'selected' : '' }}>Verzet</option>
                            <option value="Geannuleerd" {{ ($selectedStatus ?? '') === 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Maak selectie
                    </button>
                    <a href="{{ route('admin.afspraken') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm text-center inline-block">
                        Reset
                    </a>
                </div>
            </form>

            <!-- List Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4 mb-6 w-full">
                    <div class="text-left">
                        <span class="text-sm text-gray-400 font-semibold">Gevonden afspraken - {{ $afspraken->total() }} afspraak(en)</span>
                    </div>
                    
                    <div class="flex justify-center">
                        <!-- Pagination -->
                        @if($afspraken->hasPages())
                        <div class="flex items-center space-x-1 text-xs">
                            {{-- Previous Page Link --}}
                            @if($afspraken->onFirstPage())
                                <span class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-300 cursor-not-allowed">‹</span>
                            @else
                                <a href="{{ $afspraken->previousPageUrl() }}" class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50">‹</a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($afspraken->getUrlRange(1, $afspraken->lastPage()) as $page => $url)
                                @if($page == $afspraken->currentPage())
                                    <span class="px-3 py-1.5 bg-[#b91c1c] text-white rounded font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($afspraken->hasMorePages())
                                <a href="{{ $afspraken->nextPageUrl() }}" class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50">›</a>
                            @else
                                <span class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-300 cursor-not-allowed">›</span>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <div></div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm text-left">
                        <thead>
                            <tr class="bg-[#b91c1c] text-white font-bold text-xs uppercase tracking-wide">
                                <th class="py-3.5 px-4 rounded-l-xl">Klant</th>
                                <th class="py-3.5 px-4">Medewerker</th>
                                <th class="py-3.5 px-4">Behandeling</th>
                                <th class="py-3.5 px-4">Datum</th>
                                <th class="py-3.5 px-4">Starttijd</th>
                                <th class="py-3.5 px-4">Duur</th>
                                <th class="py-3.5 px-4">Eindtijd</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4 text-center rounded-r-xl">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($afspraken as $afspraak)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">{{ $afspraak->KlantNaam }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $afspraak->MedewerkerNaam }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $afspraak->BehandelingNaam }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ date('d-m-Y', strtotime($afspraak->Datum)) }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ date('H:i', strtotime($afspraak->Starttijd)) }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $afspraak->Duur }} min</td>
                                <td class="py-4 px-4 text-gray-600">{{ date('H:i', strtotime($afspraak->Eindtijd)) }}</td>
                                <td class="py-4 px-4">
                                    <span class="font-medium @if($afspraak->Status === 'Geannuleerd') text-red-600 @elseif($afspraak->Status === 'Inbehandeling') text-orange-600 @else text-green-600 @endif">
                                        {{ $afspraak->Status }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('admin.afspraken.show', $afspraak->Id) }}" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-500 font-medium">
                                    Er zijn geen afspraken bekend die de geselecteerde status hebben
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-8 text-xs text-gray-400 font-medium">
                &copy; 2026 Kniploket Tiko Alle rechten voorbehouden
            </footer>
        </div>
    </div>
</x-app-layout>
