<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Klanten</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">
                Overzicht klanten
            </h1>

            <!-- Filter Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex justify-end items-end space-x-3">
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 mb-1.5">Postcode zoeken</label>
                        <input type="text" placeholder="Bijv. 3512AB" class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white w-64">
                    </div>
                    <button class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Toon klanten
                    </button>
                    <button class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Reset
                    </button>
                </div>
            </div>

            <!-- List Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm text-gray-400 font-semibold">Gevonden klanten - 6 klant(en)</span>
                    
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
                                <th class="py-3.5 px-4 rounded-l-xl">Naam</th>
                                <th class="py-3.5 px-4">Relatienummer</th>
                                <th class="py-3.5 px-4">Adres</th>
                                <th class="py-3.5 px-4">Postcode</th>
                                <th class="py-3.5 px-4">Woonplaats</th>
                                <th class="py-3.5 px-4">Mobiel</th>
                                <th class="py-3.5 px-4">Contact e-mail</th>
                                <th class="py-3.5 px-4 text-center rounded-r-xl">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Ahmed Mansouri</td>
                                <td class="py-4 px-4 text-gray-600">KL 2026 004</td>
                                <td class="py-4 px-4 text-gray-600">Winkel van Sinkelstraat 4</td>
                                <td class="py-4 px-4 text-gray-600">3511KV</td>
                                <td class="py-4 px-4 text-gray-600">Utrecht</td>
                                <td class="py-4 px-4 text-gray-600">+31 6 1234 61 74</td>
                                <td class="py-4 px-4 text-gray-600">ahmed.mansouri@icloud.com</td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Daan Visser</td>
                                <td class="py-4 px-4 text-gray-600">KL-2026-006</td>
                                <td class="py-4 px-4 text-gray-600">Vleutenseweg 73</td>
                                <td class="py-4 px-4 text-gray-600">3532HA</td>
                                <td class="py-4 px-4 text-gray-600">Utrecht</td>
                                <td class="py-4 px-4 text-gray-600">+31 6 1234 61 76</td>
                                <td class="py-4 px-4 text-gray-600">daan.visser@live.nl</td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Jan Jansen</td>
                                <td class="py-4 px-4 text-gray-600">KL-2026-002</td>
                                <td class="py-4 px-4 text-gray-600">Biltstraat 44</td>
                                <td class="py-4 px-4 text-gray-600">3572BC</td>
                                <td class="py-4 px-4 text-gray-600">Utrecht</td>
                                <td class="py-4 px-4 text-gray-600">+31 6 1234 61 72</td>
                                <td class="py-4 px-4 text-gray-600">jan.jansen@outlook.com</td>
                                <td class="py-4 px-4 text-center">
                                    <a href="#" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-semibold text-gray-900">Marieke van den Berg</td>
                                <td class="py-4 px-4 text-gray-600">KL 2026 005</td>
                                <td class="py-4 px-4 text-gray-600">Adelaarstraat 50</td>
                                <td class="py-4 px-4 text-gray-600">3514CH</td>
                                <td class="py-4 px-4 text-gray-600">Utrecht</td>
                                <td class="py-4 px-4 text-gray-600">+31 6 1234 61 75</td>
                                <td class="py-4 px-4 text-gray-600">marieke.vandenberg@ziggo.nl</td>
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
