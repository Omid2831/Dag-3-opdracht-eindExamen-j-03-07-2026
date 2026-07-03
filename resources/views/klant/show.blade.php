<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="text-sm font-medium text-gray-500 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Home</a> / 
            <a href="{{ route('admin.klanten') }}" class="hover:text-gray-700">Klanten</a> / 
            <span class="text-gray-900">Detail</span>
        </nav>

        {{-- Heading --}}
        <h1 class="text-3xl font-extrabold text-[#b91c1c] mb-6">
            Klantdetail {{ trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam]))) }}
        </h1>

        {{-- Details Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
            <div class="divide-y divide-gray-100 font-medium text-sm">
                {{-- Naam --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Naam</span>
                    <span class="col-span-2 text-gray-900 font-semibold">{{ trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam]))) }}</span>
                </div>
                {{-- Relatienummer --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Relatienummer</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Relatienummer }}</span>
                </div>
                {{-- Contact e-mail --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Contact e-mail</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->ContactEmail }}</span>
                </div>
                {{-- Account e-mail --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Account e-mail</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->AccountEmail }}</span>
                </div>
                {{-- Straatnaam --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Straatnaam</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Straatnaam }}</span>
                </div>
                {{-- Huisnummer --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Huisnummer</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Huisnummer }}</span>
                </div>
                {{-- Toevoeging --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Toevoeging</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Toevoeging ?? '-' }}</span>
                </div>
                {{-- Postcode --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Postcode</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Postcode }}</span>
                </div>
                {{-- Plaats --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Plaats</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Plaats }}</span>
                </div>
                {{-- Mobiel --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Mobiel</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Mobiel }}</span>
                </div>
                {{-- Bijzonderheden --}}
                <div class="grid grid-cols-3 py-3.5">
                    <span class="text-gray-500">Bijzonderheden</span>
                    <span class="col-span-2 text-gray-900">{{ $klant->Bijzonderheden ?? '-' }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 mt-8 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.klanten.edit', $klant->Id) }}" class="bg-[#b91c1c] hover:bg-[#981414] text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition duration-150">
                    Wijzigen
                </a>
                <a href="{{ route('admin.klanten') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition duration-150 border border-gray-200">
                    Terug
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
