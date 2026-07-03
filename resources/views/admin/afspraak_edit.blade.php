<x-app-layout>
    <div class="py-8 bg-gray-55 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('admin.afspraken') }}" class="text-[#b91c1c] hover:underline">Afspraken</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Wijzigen</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold mb-6">
                <span class="text-[#b91c1c]">Afspraak wijzigen</span>
                <span class="text-gray-500 ml-1.5 font-normal">{{ $afspraak->KlantNaam }}</span>
            </h1>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-2xl text-sm font-semibold mb-6 flex items-center space-x-2.5 max-w-4xl shadow-sm">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Afspraakgegevens zijn niet bijgewerkt</span>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 max-w-4xl">
                <form method="POST" action="{{ route('admin.afspraken.update', $afspraak->Id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Klant (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Klant</label>
                            <input type="text" value="{{ $afspraak->KlantNaam }}" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Relatienummer (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Relatienummer</label>
                            <input type="text" value="{{ $afspraak->Relatienummer }}" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Contact e-mail (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Contact e-mail</label>
                            <input type="text" value="{{ $afspraak->KlantEmail }}" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Mobiel (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Mobiel</label>
                            <input type="text" value="{{ $afspraak->KlantMobiel }}" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Medewerker (Select) -->
                        <div class="flex flex-col">
                            <label for="medewerker_id" class="text-sm font-bold text-gray-800 mb-2">Medewerker <span class="text-red-500">*</span></label>
                            <select name="medewerker_id" id="medewerker_id" required class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white">
                                @foreach($medewerkers as $medewerker)
                                    <option value="{{ $medewerker->Id }}" {{ old('medewerker_id', $afspraak->MedewerkerId) == $medewerker->Id ? 'selected' : '' }}>
                                        {{ $medewerker->Naam }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Behandeling (Select) -->
                        <div class="flex flex-col">
                            <label for="behandeling_id" class="text-sm font-bold text-gray-800 mb-2">Behandeling <span class="text-red-500">*</span></label>
                            <select name="behandeling_id" id="behandeling_id" required class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white">
                                @foreach($behandelingen as $behandeling)
                                    <option value="{{ $behandeling->Id }}" {{ old('behandeling_id', $afspraak->BehandelingId) == $behandeling->Id ? 'selected' : '' }}>
                                        {{ $behandeling->Naam }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Datum (Date input) -->
                        <div class="flex flex-col">
                            <label for="datum" class="text-sm font-bold text-gray-800 mb-2">Datum <span class="text-red-500">*</span></label>
                            <input type="date" name="datum" id="datum" required value="{{ old('datum', date('Y-m-d', strtotime($afspraak->Datum))) }}" class="border @error('datum') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-2.5 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white">
                            @error('datum')
                                <span class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Starttijd (Time input) -->
                        <div class="flex flex-col">
                            <label for="starttijd" class="text-sm font-bold text-gray-800 mb-2">Starttijd <span class="text-red-500">*</span></label>
                            <input type="time" name="starttijd" id="starttijd" required value="{{ old('starttijd', date('H:i', strtotime($afspraak->Starttijd))) }}" class="border @error('starttijd') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-2.5 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white">
                            @error('starttijd')
                                <span class="text-xs text-red-600 mt-1.5 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Duur (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Duur</label>
                            <input type="text" value="{{ $afspraak->BehandelingDuur }} min" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Eindtijd (Readonly) -->
                        <div class="flex flex-col">
                            <label class="text-sm font-bold text-gray-800 mb-2">Eindtijd</label>
                            <input type="text" value="{{ date('H:i', strtotime($afspraak->Eindtijd)) }}" disabled class="bg-gray-50 text-gray-500 border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full cursor-not-allowed">
                        </div>

                        <!-- Status (Select) -->
                        <div class="flex flex-col">
                            <label for="status" class="text-sm font-bold text-gray-800 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white">
                                <option value="Inbehandeling" {{ old('status', $afspraak->Status) === 'Inbehandeling' ? 'selected' : '' }}>Inbehandeling</option>
                                <option value="Behandeld" {{ old('status', $afspraak->Status) === 'Behandeld' ? 'selected' : '' }}>Behandeld</option>
                                <option value="Geannuleerd" {{ old('status', $afspraak->Status) === 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>

                    </div>

                    <!-- Bottom row: explanation and actions -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mt-8 pt-6 border-t border-gray-100">
                        <span class="text-xs text-gray-400 font-medium">Velden met een <span class="text-red-500">*</span> zijn verplicht.</span>
                        <div class="flex space-x-3">
                            <button type="submit" class="bg-[#b91c1c] hover:bg-red-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">
                                Opslaan
                            </button>
                            <a href="{{ route('admin.afspraken.show', $afspraak->Id) }}" class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition text-center inline-block">
                                Terug
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <footer class="text-center py-8 text-xs text-gray-400 font-medium">
                &copy; 2026 Kniploket Tiko Alle rechten voorbehouden
            </footer>
        </div>
    </div>
</x-app-layout>
