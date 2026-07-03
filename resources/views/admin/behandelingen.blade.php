<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Behandelingen</span>
            </div>

            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">Overzicht behandelingen</h1>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <form method="GET" action="{{ route('admin.behandelingen') }}"
                    class="flex justify-end items-end space-x-3">
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 mb-1.5">Behandeling selecteren</label>
                        <select name="soort"
                            class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white w-64">
                            <option value="">Alle behandelingen</option>
                            <option value="Combi behandelingen" {{ request('soort') == 'Combi behandelingen' ? 'selected' : '' }}>Combi behandelingen</option>
                            <option value="Extensions" {{ request('soort') == 'Extensions' ? 'selected' : '' }}>Extensions
                            </option>
                            <option value="Kleuren" {{ request('soort') == 'Kleuren' ? 'selected' : '' }}>Kleuren</option>
                            <option value="Knippen" {{ request('soort') == 'Knippen' ? 'selected' : '' }}>Knippen</option>
                            <option value="Overig" {{ request('soort') == 'Overig' ? 'selected' : '' }}>Overig</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Maak selectie
                    </button>
                    <a href="{{ route('admin.behandelingen') }}"
                        class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Reset
                    </a>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm text-gray-400 font-semibold">
                        Gevonden behandelingen - {{ $behandelingen->total() }} behandeling(en)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm text-left">
                        <thead>
                            <tr class="bg-[#b91c1c] text-white font-bold text-xs uppercase tracking-wide">
                                <th class="py-3.5 px-4 rounded-l-xl">Soort</th>
                                <th class="py-3.5 px-4 w-1/3">Omschrijving</th>
                                <th class="py-3.5 px-4">Duur</th>
                                <th class="py-3.5 px-4">Prijs</th>
                                <th class="py-3.5 px-4">Aantal producten</th>
                                <th class="py-3.5 px-4 text-center rounded-r-xl">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($behandelingen as $behandeling)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-4 font-semibold text-gray-900">{{ $behandeling->Soort }}</td>
                                    <td class="py-4 px-4">{{ $behandeling->Omschrijving }}</td>
                                    <td class="py-4 px-4">{{ $behandeling->Duur }}</td>
                                    <td class="py-4 px-4">{{ $behandeling->Prijs }}</td>
                                    <td class="py-4 px-4 text-center">{{ $behandeling->AantalProducten }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="{{ route('admin.behandelingen.producten', ['id' => $behandeling->behandelingId]) }}"
                                            class="text-xs font-bold text-[#b91c1c] border border-[#b91c1c] px-3 py-1.5 rounded-lg hover:bg-[#b91c1c] hover:text-white transition">
                                            Producten
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-m text-gray-500">Er zijn geen
                                        behandelingen gevonden met deze naam.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $behandelingen->appends(request()->query())->links() }}
                </div>
            </div>

            <footer class="text-center py-8 text-xs text-gray-400 font-medium">
                &copy; 2026 Kniploket Tiko Alle rechten voorbehouden
            </footer>
        </div>
    </div>
</x-app-layout>