<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Producten</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">
                Overzicht producten
            </h1>

            <!-- Filter Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <form action="{{ route('admin.producten') }}" method="GET" class="flex justify-end items-end space-x-3">
                    <div class="flex flex-col">
                        <label for="category_select" class="text-xs font-semibold text-gray-500 mb-1.5">Categorie selecteren</label>
                        <select id="category_select" name="category_id" class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] bg-white w-64">
                            <option value="">Alle categorieën</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->Id }}" {{ $selectedCategory == $category->Id ? 'selected' : '' }}>
                                    {{ $category->Naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Maak selectie
                    </button>
                    <a href="{{ route('admin.producten') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold text-center transition shadow-sm">
                        Reset
                    </a>
                </form>
            </div>

            <!-- List Section -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm text-gray-400 font-semibold">Gevonden producten - {{ $products->total() }} product(en)</span>
                    
                    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                        <div class="flex items-center space-x-1">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <span class="px-3 py-1.5 border border-gray-200 rounded-lg text-gray-400 bg-gray-50 text-xs font-bold cursor-not-allowed">&lt;</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-300 rounded-lg text-gray-600 bg-white hover:bg-gray-50 text-xs font-bold transition">&lt;</a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if($page == $products->currentPage())
                                    <span class="px-3.5 py-1.5 bg-[#b91c1c] text-white rounded-lg text-xs font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3.5 py-1.5 border border-gray-300 rounded-lg text-gray-600 bg-white hover:bg-gray-50 text-xs font-bold transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-300 rounded-lg text-gray-600 bg-white hover:bg-gray-50 text-xs font-bold transition">&gt;</a>
                            @else
                                <span class="px-3 py-1.5 border border-gray-200 rounded-lg text-gray-400 bg-gray-50 text-xs font-bold cursor-not-allowed">&gt;</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm text-left">
                        <thead>
                            <tr class="bg-[#b91c1c] text-white font-bold text-xs uppercase tracking-wide">
                                <th class="py-3.5 px-4 rounded-l-xl">Product</th>
                                <th class="py-3.5 px-4">Categorie</th>
                                <th class="py-3.5 px-4">Merk</th>
                                <th class="py-3.5 px-4">EAN-code</th>
                                <th class="py-3.5 px-4">Verkoopprijs</th>
                                <th class="py-3.5 px-4">Voorraad</th>
                                <th class="py-3.5 px-4 text-center rounded-r-xl">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($products as $prod)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-4 font-semibold text-gray-900">{{ $prod->Naam }}</td>
                                    <td class="py-4 px-4 text-gray-600">{{ $prod->Categorie }}</td>
                                    <td class="py-4 px-4 text-gray-600">{{ $prod->Merk }}</td>
                                    <td class="py-4 px-4 text-gray-600">{{ $prod->EANcode }}</td>
                                    <td class="py-4 px-4 text-gray-600">EUR {{ number_format($prod->VerkoopPrijs, 2, ',', '.') }}</td>
                                    <td class="py-4 px-4 text-gray-600">{{ $prod->Voorraad }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="{{ route('admin.producten.show', $prod->Id) }}" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-4 py-1 rounded-lg text-xs font-bold transition inline-block">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-red-600 font-semibold bg-red-50/50 rounded-xl">
                                        Er zijn geen producten bekend binnen de geselecteerde categorie
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
