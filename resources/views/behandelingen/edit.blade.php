<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl ml-20 mr-auto px-4">
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    Gegevens niet bijgewerkt
                </div>
            @endif

            <div class="text-sm font-semibold text-gray-500 mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-[#b91c1c]">Behandelingen</span>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Wijzigen</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <span class="text-[#b91c1c]">Product wijzigen</span> {{ $producten[0]->Product }}
            </h1>

            <form action="{{ route('admin.behandelingen.update', $producten[0]->ProductId) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="product_id" value="{{ $producten[0]->ProductId }}">

                <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Product</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->Product }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Omschrijving</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->Omschrijving }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Inkoopprijs</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->InkoopPrijs }}</div>

                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Inkoopprijs</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->VerkoopPrijs }}</div>

                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Nieuwe verkoopprijs *</label>
                            <input type="number" step="0.01" name="verkoopprijs" 
                                   value="{{ old('verkoopprijs', str_replace(['EUR ', ','], ['', '.'], $producten[0]->VerkoopPrijs)) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[#b91c1c] focus:border-[#b91c1c] {{ $errors->has('verkoopprijs') ? 'border-red-500' : '' }}">
                            
                            @error('verkoopprijs')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Minimaal 30 procent boven de inkoopprijs.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Merk</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->Merk }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">EAN-code</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->EANcode }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Aantal op voorraad</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->AantalOpVoorraad }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Leverancier</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">{{ $producten[0]->Leverancier }}</div>
                            
                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-1">Opmerking</label>
                            <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-md text-sm text-gray-500">Geschikt voor dagelijkse salon gebruik</div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <button type="submit" class="bg-[#b91c1c] text-white px-8 py-1.5 rounded-lg text-sm font-bold hover:bg-red-800 transition">Opslaan</button>
                        <a href="{{ route('admin.behandelingen.show', ['id' => $producten[0]->ProductId]) }}" class="bg-white border border-gray-300 text-gray-700 px-8 py-1.5 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Terug</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>