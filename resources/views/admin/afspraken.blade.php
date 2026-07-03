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
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex justify-end items-end space-x-3">
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 mb-1.5">Status selecteren</label>
                        <select class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white w-64">
                            <option>Alle statussen</option>
                            <option>Behandeld</option>
                            <option>Inbehandeling</option>
                            <option>Geannuleerd</option>
                        </select>
                    </div>
                    <button class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Maak selectie
                    </button>
                    <button class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Reset
                    </button>
                </div>
            </div>

            <!-- List Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm text-gray-400 font-semibold">Gevonden afspraken - 6 afspraak(en)</span>
                    
                    <!-- Pagination -->
                    <div class="flex items-center space-x-1 text-xs">
                        <a href="#" class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-400 hover:bg-gray-50">‹</a>
                        <a href="#" class="px-3 py-1.5 bg-[#b91c1c] text-white rounded font-bold">1</a>
                        <a href="#" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50">2</a>
                        <a href="#" class="px-2.5 py-1.5 border border-gray-200 rounded text-gray-400 hover:bg-gray-50">›</a>
                    </div>
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
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Ahmed Mansouri</td>
                                <td class="py-4 px-4 text-gray-600">Lisa van Dijk</td>
                                <td class="py-4 px-4 text-gray-600">Combi behandelingen</td>
                                <td class="py-4 px-4 text-gray-600">15-07-2026</td>
                                <td class="py-4 px-4 text-gray-600">12:30</td>
                                <td class="py-4 px-4 text-gray-600">90 min</td>
                                <td class="py-4 px-4 text-gray-600">14:00</td>
                                <td class="py-4 px-4">
                                    <span class="text-red-600 font-medium">Geannuleerd</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Saskia de Boer</td>
                                <td class="py-4 px-4 text-gray-600">Mohamed El Idrissi</td>
                                <td class="py-4 px-4 text-gray-600">Knippen</td>
                                <td class="py-4 px-4 text-gray-600">10-07-2026</td>
                                <td class="py-4 px-4 text-gray-600">15:00</td>
                                <td class="py-4 px-4 text-gray-600">30 min</td>
                                <td class="py-4 px-4 text-gray-600">15:30</td>
                                <td class="py-4 px-4">
                                    <span class="text-orange-600 font-medium">Inbehandeling</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Daan Visser</td>
                                <td class="py-4 px-4 text-gray-600">Youssef Benali</td>
                                <td class="py-4 px-4 text-gray-600">Permanent</td>
                                <td class="py-4 px-4 text-gray-600">10-07-2026</td>
                                <td class="py-4 px-4 text-gray-600">13:30</td>
                                <td class="py-4 px-4 text-gray-600">120 min</td>
                                <td class="py-4 px-4 text-gray-600">15:30</td>
                                <td class="py-4 px-4">
                                    <span class="text-green-600 font-medium">Behandeld</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Marieke van den Berg</td>
                                <td class="py-4 px-4 text-gray-600">Lisa van Dijk</td>
                                <td class="py-4 px-4 text-gray-600">Knippen</td>
                                <td class="py-4 px-4 text-gray-600">10-07-2026</td>
                                <td class="py-4 px-4 text-gray-600">14:00</td>
                                <td class="py-4 px-4 text-gray-600">30 min</td>
                                <td class="py-4 px-4 text-gray-600">14:30</td>
                                <td class="py-4 px-4">
                                    <span class="text-red-600 font-medium">Geannuleerd</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
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
