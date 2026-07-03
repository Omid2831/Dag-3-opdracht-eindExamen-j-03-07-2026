<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="text-sm font-semibold text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <a href="{{ route('admin.producten') }}" class="text-[#b91c1c] hover:underline">Producten</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Detail</span>
            </div>

            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-[#b91c1c] mb-6">
                Productdetail <span class="text-gray-600 font-normal">{{ $product->Naam }}</span>
            </h1>

            <!-- Success Session Alert (disappears after 3 seconds) -->
            @if (session('success'))
                <div id="alert-success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
                    <span class="block sm:inline font-semibold">{{ session('success') }}</span>
                </div>
                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(function() { alert.remove(); }, 500);
                        }
                    }, 3000);
                </script>
            @endif

            <!-- Detail Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 max-w-2xl">
                <div class="divide-y divide-gray-100">
                    
                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Product</span>
                        <span class="text-sm text-gray-600">{{ $product->Naam }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Merk</span>
                        <span class="text-sm text-gray-600">{{ $product->Merk }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Omschrijving</span>
                        <span class="text-sm text-gray-600 text-right max-w-md">{{ $product->Omschrijving }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">EAN-code</span>
                        <span class="text-sm text-gray-600">{{ $product->EANcode }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Houdbaarheidsdatum</span>
                        <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Inkoopprijs</span>
                        <span class="text-sm text-gray-600">EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Verkoopprijs</span>
                        <span class="text-sm text-gray-600">EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Aantal op voorraad</span>
                        <span class="text-sm text-gray-600">{{ $product->AantalOpVoorraad }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Leverancier</span>
                        <span class="text-sm text-gray-600">{{ $product->LeverancierNaam ?? '-' }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Postcode leverancier</span>
                        <span class="text-sm text-gray-600">{{ $product->LeverancierPostcode ?? '-' }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Plaats leverancier</span>
                        <span class="text-sm text-gray-600">{{ $product->LeverancierPlaats ?? '-' }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">E-mail leverancier</span>
                        <span class="text-sm text-gray-600">{{ $product->LeverancierEmail ?? '-' }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Mobiel leverancier</span>
                        <span class="text-sm text-gray-600">{{ $product->LeverancierMobiel ?? '-' }}</span>
                    </div>

                    <div class="py-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-700">Opmerking</span>
                        <span class="text-sm text-gray-600 text-right max-w-md">{{ $product->Opmerking ?? '-' }}</span>
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.producten.edit', $product->Id) }}" class="bg-[#b91c1c] hover:bg-red-800 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-sm">
                        Wijzigen
                    </a>
                    <a href="{{ route('admin.producten') }}" class="border border-blue-500 text-blue-500 hover:bg-blue-50 px-5 py-2 rounded-xl text-sm font-bold transition">
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
