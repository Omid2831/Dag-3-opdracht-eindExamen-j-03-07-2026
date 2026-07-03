<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('admin.afspraken') }}" class="text-[#b91c1c] hover:underline">Afspraken</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Detail</span>
            </div>

             <!-- Page Title -->
            <h1 class="text-2xl font-bold mb-6">
                <span class="text-[#b91c1c]">Afspraakdetail</span>
                <span class="text-gray-500 ml-1.5 font-normal">{{ $afspraak->KlantNaam }}</span>
            </h1>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-2xl text-sm font-semibold mb-6 flex items-center space-x-2.5 max-w-2xl shadow-sm">
                    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Details Card -->
            <div class="max-w-2xl bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-6">
                <div class="divide-y divide-gray-100">
                    
                    <!-- Row 1: Klant -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Klant</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->KlantNaam }}</span>
                    </div>

                    <!-- Row 2: Relatienummer -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Relatienummer</span>
                        <span class="text-sm text-gray-700 col-span-2 font-medium">{{ $afspraak->Relatienummer }}</span>
                    </div>

                    <!-- Row 3: Mobiel -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Mobiel</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->KlantMobiel }}</span>
                    </div>

                    <!-- Row 4: Contact e-mail -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Contact e-mail</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->KlantEmail }}</span>
                    </div>

                    <!-- Row 5: Medewerker -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Medewerker</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->MedewerkerNaam }}</span>
                    </div>

                    <!-- Row 6: Behandeling -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Behandeling</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->BehandelingNaam }}</span>
                    </div>

                    <!-- Row 7: Datum -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Datum</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ date('d-m-Y', strtotime($afspraak->Datum)) }}</span>
                    </div>

                    <!-- Row 8: Starttijd -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Starttijd</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ date('H:i', strtotime($afspraak->Starttijd)) }}</span>
                    </div>

                    <!-- Row 9: Duur -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Duur</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ $afspraak->BehandelingDuur }} min</span>
                    </div>

                    <!-- Row 10: Eindtijd -->
                    <div class="grid grid-cols-3 py-3.5 items-center">
                        <span class="text-sm font-bold text-gray-800">Eindtijd</span>
                        <span class="text-sm text-gray-700 col-span-2">{{ date('H:i', strtotime($afspraak->Eindtijd)) }}</span>
                    </div>

                    <!-- Row 11: Status -->
                    <div class="grid grid-cols-3 py-3.5 items-center border-b border-gray-100">
                        <span class="text-sm font-bold text-gray-800">Status</span>
                        <span class="text-sm text-gray-700 col-span-2 font-medium">{{ $afspraak->Status }}</span>
                    </div>
                </div>

                <!-- Card Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.afspraken.edit', $afspraak->Id) }}" class="bg-[#b91c1c] hover:bg-red-800 text-white px-6 py-2 rounded-xl text-sm font-bold transition shadow-sm text-center inline-block">
                        Wijzigen
                    </a>
                    <a href="{{ route('admin.afspraken') }}" class="border border-blue-500 hover:bg-blue-50 text-blue-500 px-6 py-2 rounded-xl text-sm font-bold transition text-center inline-block">
                        Terug
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-8 text-xs text-gray-400 font-medium">
                &copy; 2026 Kniploket Tiko Alle rechten voorbehouden
            </footer>
        </div>
    </div>
</x-app-layout>
