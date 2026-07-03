<x-app-layout>
    {{-- Exam Assignment: Customer overview page with postcode search filters --}}
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="text-sm font-medium text-gray-500 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Home</a> / 
            <span class="text-gray-900">Klanten</span>
        </nav>

        {{-- Session Flash Alerts --}}
        @if (session('success'))
            <div id="session-alert" class="mb-4 p-4 bg-[#e2f0d9] border border-[#c5e0b4] text-[#385723] rounded-lg shadow-sm flex items-center justify-between transition-all duration-300">
                <span class="font-semibold text-sm">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div id="session-alert" class="mb-4 p-4 bg-[#fde8e8] border border-[#f8b4b4] text-[#9b1c1c] rounded-lg shadow-sm flex items-center justify-between transition-all duration-300">
                <span class="font-semibold text-sm">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Heading --}}
        <h1 class="text-3xl font-extrabold text-[#b91c1c] mb-6">Overzicht klanten</h1>

        {{-- Search Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col sm:flex-row justify-end">
            <form method="GET" action="{{ route('admin.klanten') }}" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 w-full sm:w-auto">
                <div class="w-full sm:w-56">
                    <label for="postcode" class="block text-xs font-bold text-gray-700 mb-1.5">Postcode zoeken</label>
                    <input type="text" name="postcode" id="postcode" value="{{ request('postcode') }}" placeholder="Bijv. 3512AB" class="w-full h-9 text-xs rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150">
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="bg-[#b91c1c] hover:bg-[#981414] text-white text-xs font-bold h-9 px-4 rounded-lg transition duration-150 shadow-sm flex-1 sm:flex-none">
                        Toon klanten
                    </button>
                    <a href="{{ route('admin.klanten') }}" class="bg-[#6b7280] hover:bg-[#4b5563] text-white text-xs font-bold h-9 px-4 flex items-center justify-center rounded-lg transition duration-150 shadow-sm flex-1 sm:flex-none">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Count Info & Centered Pagination Row --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-4">
            <div class="text-xs font-bold text-gray-500 w-full sm:w-[200px] text-center sm:text-left">
                Gevonden klanten - {{ $klanten->total() }} klant(en)
            </div>
            
            {{-- Custom Centered Pagination --}}
            @if ($klanten->hasPages())
                <div class="flex items-center gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($klanten->onFirstPage())
                        <span class="w-7 h-7 flex items-center justify-center rounded bg-gray-50 text-gray-400 text-xs border border-gray-200 cursor-not-allowed">&lt;</span>
                    @else
                        <a href="{{ $klanten->previousPageUrl() }}" class="w-7 h-7 flex items-center justify-center rounded bg-white hover:bg-gray-50 text-gray-700 text-xs border border-gray-200 transition">&lt;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($klanten->getUrlRange(1, $klanten->lastPage()) as $page => $url)
                        @if ($page == $klanten->currentPage())
                            <span class="w-7 h-7 flex items-center justify-center rounded bg-[#b91c1c] text-white text-xs font-bold border border-[#b91c1c]">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-7 h-7 flex items-center justify-center rounded bg-white hover:bg-gray-50 text-gray-700 text-xs border border-gray-200 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($klanten->hasMorePages())
                        <a href="{{ $klanten->nextPageUrl() }}" class="w-7 h-7 flex items-center justify-center rounded bg-white hover:bg-gray-50 text-gray-700 text-xs border border-gray-200 transition">&gt;</a>
                    @else
                        <span class="w-7 h-7 flex items-center justify-center rounded bg-gray-50 text-gray-400 text-xs border border-gray-200 cursor-not-allowed">&gt;</span>
                    @endif
                </div>
            @endif

            <div class="hidden sm:block w-[200px]"></div>
        </div>

        {{-- Customers Table / Grid --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
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
                    <tbody class="divide-y divide-gray-300 text-sm text-gray-700 font-medium">
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
                                    <a href="{{ route('admin.klanten.show', $klant->Id) }}" class="border border-blue-500 hover:bg-blue-50 text-blue-500 font-semibold py-1.5 px-5 rounded-md text-xs transition duration-150 bg-white">
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
