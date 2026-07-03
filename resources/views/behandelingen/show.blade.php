<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="w-full max-w-5xl ml-20 mr-auto px-4">

            <div class="text-sm font-semibold text-gray-500 mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-[#b91c1c] hover:underline">Home</a>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-[#b91c1c]">Behandelingen</span>
                <span class="mx-1 text-gray-400">/</span>
                <span class="text-gray-400">Detail</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                <span class="text-[#b91c1c]">Productdetail</span> {{ $producten[0]->Product }}
            </h1>

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $details = [
                                'Product' => $producten[0]->Product,
                                'Merk' => $producten[0]->Merk,
                                'Omschrijving' => $producten[0]->Omschrijving,
                                'EAN-code' => $producten[0]->EANcode,
                                'Houdbaarheidsdatum' => $producten[0]->Houdbaarheidsdatum,
                                'Inkoopprijs' => $producten[0]->InkoopPrijs,
                                'Verkoopprijs' => $producten[0]->VerkoopPrijs,
                                'Aantal op voorraad' => $producten[0]->AantalOpVoorraad,
                                'Leverancier' => $producten[0]->Leverancier,
                                'Postcode leverancier' => $producten[0]->PostcodeLeverancier,
                                'Plaats leverancier' => $producten[0]->PlaatsLeverancier,
                                'E-mail leverancier' => $producten[0]->EmailLeverancier,
                                'Mobiel leverancier' => $producten[0]->MobielLeverancier,
                                'Opmerking' => $producten[0]->Opmerking,
                            ];
                        @endphp

                        @foreach($details as $label => $value)
                        <tr>
                            <th class="py-3 pr-8 text-sm font-bold text-gray-700 w-1/4">{{ $label }}</th>
                            <td class="py-3 text-sm text-gray-600">{{ $value ?? 'Geschikt voor dagelijkse salon gebruik' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.behandelingen.edit', ['id' => $producten[0]->ProductId]) }}" class="bg-[#b91c1c] text-white px-6 py-1.5 rounded-lg text-sm font-bold hover:bg-red-800 transition">
                        Wijzigen
                    </a>
                    <a href="{{ route('admin.behandelingen.producten', ['id' => $producten[0]->ProductId]) }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-1.5 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                        Terug
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>