<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="text-sm font-medium text-gray-500 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Home</a> / 
            <span class="text-gray-900">Klanten</span>
        </nav>

        {{-- Session Flash Alerts --}}
        @if (session('success'))
            <div id="session-alert" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm flex items-center justify-between transition-all duration-300">
                <span class="font-semibold text-sm">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div id="session-alert" class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm flex items-center justify-between transition-all duration-300">
                <span class="font-semibold text-sm">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Heading --}}
        <h1 class="text-3xl font-extrabold text-[#b91c1c] mb-6">Overzicht klanten</h1>

        {{-- Search Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('admin.klanten') }}" class="flex flex-col md:flex-row md:items-end md:justify-end gap-4">
                <div class="w-full md:max-w-xs">
                    <label for="postcode" class="block text-sm font-bold text-gray-700 mb-1.5">Postcode zoeken</label>
                    <input type="text" name="postcode" id="postcode" value="{{ request('postcode') }}" placeholder="Bijv. 3512AB" class="w-full rounded-lg border-gray-200 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-[#b91c1c] hover:bg-[#981414] text-white font-bold py-2 px-6 rounded-lg transition duration-150 shadow-sm">
                        Toon klanten
                    </button>
                    <a href="{{ route('admin.klanten') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-lg transition duration-150 border border-gray-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Count Info --}}
        <div class="text-sm font-semibold text-gray-600 mb-4">
            Gevonden klanten - {{ $klanten->total() }} klant(en)
        </div>

        {{-- Customers Table / Grid --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#b91c1c] text-white text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">Naam</th>
                            <th class="py-4 px-6">Relatienummer</th>
                            <th class="py-4 px-6">Adres</th>
                            <th class="py-4 px-6">Postcode</th>
                            <th class="py-4 px-6">Woonplaats</th>
                            <th class="py-4 px-6">Mobiel</th>
                            <th class="py-4 px-6">Contact e-mail</th>
                            <th class="py-4 px-6 text-center">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700 font-medium">
                        @forelse ($klanten as $klant)
                            <tr class="hover:bg-gray-50 transition duration-75">
                                <td class="py-4 px-6 font-bold text-gray-900">{{ $klant->Naam }}</td>
                                <td class="py-4 px-6">{{ $klant->Relatienummer }}</td>
                                <td class="py-4 px-6">{{ $klant->Adres }}</td>
                                <td class="py-4 px-6 whitespace-nowrap">{{ $klant->Postcode }}</td>
                                <td class="py-4 px-6">{{ $klant->Woonplaats }}</td>
                                <td class="py-4 px-6 whitespace-nowrap">{{ $klant->Mobiel }}</td>
                                <td class="py-4 px-6">{{ $klant->ContactEmail }}</td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.klanten.show', $klant->Id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-1.5 px-4 rounded border border-gray-200 transition duration-150">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-gray-500 font-bold">
                                    Er zijn geen klanten bekend die de geselecteerde postcode hebben
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if ($klanten->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-center">
                    {{ $klanten->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Alert fade out script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alert = document.getElementById('session-alert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        });
    </script>
</x-app-layout>
