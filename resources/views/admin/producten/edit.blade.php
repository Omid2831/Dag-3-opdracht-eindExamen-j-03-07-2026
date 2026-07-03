<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('admin.producten') }}" class="text-[#b91c1c] hover:underline">Producten</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Wijzigen</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">
                Product wijzigen <span class="text-gray-600 font-normal">{{ $product->Naam }}</span>
            </h1>

            <!-- Error Session Alert -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                    <span class="block sm:inline font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 max-w-4xl">
                <form action="{{ route('admin.producten.update', $product->Id) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Product (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Product</label>
                            <input type="text" value="{{ $product->Naam }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Merk (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Merk</label>
                            <input type="text" value="{{ $product->Merk }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Omschrijving (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Omschrijving</label>
                            <input type="text" value="{{ $product->Omschrijving }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- EAN-code (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">EAN-code</label>
                            <input type="text" value="{{ $product->EANcode }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Inkoopprijs (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Inkoopprijs</label>
                            <input type="text" value="EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Aantal op voorraad (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Aantal op voorraad</label>
                            <input type="text" value="{{ $product->AantalOpVoorraad }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Huidige verkoopprijs (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Huidige verkoopprijs</label>
                            <input type="text" value="EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Leverancier (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Leverancier</label>
                            <input type="text" value="{{ $product->LeverancierNaam ?? '-' }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Houdbaarheidsdatum (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Houdbaarheidsdatum</label>
                            <input type="text" value="{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Plaats leverancier (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Plaats leverancier</label>
                            <input type="text" value="{{ $product->LeverancierPlaats ?? '-' }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <!-- Nieuwe houdbaarheidsdatum (editable) -->
                        <div>
                            <label for="Nieuwe_houdbaarheidsdatum" class="block text-sm font-bold text-gray-700 mb-1">Nieuwe houdbaarheidsdatum <span class="text-red-500">*</span></label>
                            <input type="date" id="Nieuwe_houdbaarheidsdatum" name="Nieuwe_houdbaarheidsdatum" value="{{ old('Nieuwe_houdbaarheidsdatum', $product->Houdbaarheidsdatum) }}" class="w-full border @error('Nieuwe_houdbaarheidsdatum') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c]">
                            <p class="text-xs text-gray-400 mt-1">De houdbaarheidsdatum mag uiterlijk met 7 dagen worden verlengd.</p>
                            @error('Nieuwe_houdbaarheidsdatum')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opmerking (disabled) -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Opmerking</label>
                            <input type="text" value="{{ $product->Opmerking ?? '-' }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-500 cursor-not-allowed">
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="submit" class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                            Opslaan
                        </button>
                        <a href="{{ route('admin.producten.show', $product->Id) }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl text-sm font-bold text-center transition shadow-sm">
                            Terug
                        </a>
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
