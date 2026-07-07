<x-app-layout>
    {{-- Exam Assignment: Detailed customer information view --}}
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="text-sm font-medium text-gray-500 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 text-[#b91c1c]">Home</a> / 
            <a href="{{ route('admin.klanten') }}" class="hover:text-gray-700 text-[#b91c1c]">Klanten</a> / 
            <span class="text-gray-900">Detail</span>
        </nav>

        {{-- Heading --}}
        <h1 class="text-3xl font-extrabold mb-6">
            <span class="text-[#b91c1c]">Klantdetail</span>
            <span class="text-gray-500 font-medium">{{ trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam]))) }}</span>
        </h1>

        {{-- Details Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
            <div class="divide-y divide-gray-100 text-sm">
                {{-- Naam --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Naam</span>
                    <span class="col-span-2 text-gray-700 font-medium">{{ trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam]))) }}</span>
                </div>
                {{-- Relatienummer --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Relatienummer</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Relatienummer }}</span>
                </div>
                {{-- Contact e-mail --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Contact e-mail</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->ContactEmail }}</span>
                </div>
                {{-- Account e-mail --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Account e-mail</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->AccountEmail }}</span>
                </div>
                {{-- Straatnaam --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Straatnaam</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Straatnaam }}</span>
                </div>
                {{-- Huisnummer --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Huisnummer</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Huisnummer }}</span>
                </div>
                {{-- Toevoeging --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Toevoeging</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Toevoeging ?? '-' }}</span>
                </div>
                {{-- Postcode --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Postcode</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Postcode }}</span>
                </div>
                {{-- Plaats --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Plaats</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Plaats }}</span>
                </div>
                {{-- Mobiel --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Mobiel</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Mobiel }}</span>
                </div>
                {{-- Bijzonderheden --}}
                <div class="grid grid-cols-3 py-3">
                    <span class="font-bold text-gray-900">Bijzonderheden</span>
                    <span class="col-span-2 text-gray-700">{{ $klant->Bijzonderheden ?? '-' }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 border-t border-gray-100 pt-6">
                <button type="button" onclick="window.location.href='{{ route('admin.klanten.edit', $klant->Id) }}'" class="bg-[#b91c1c] hover:bg-[#981414] text-white font-bold py-2 px-5 rounded-lg shadow-sm transition duration-150 cursor-pointer w-full sm:w-auto text-center">
                    Wijzigen
                </button>
                <a href="{{ route('admin.klanten') }}" class="border border-blue-500 hover:bg-blue-50 text-blue-500 font-bold py-2 px-5 rounded-lg bg-white transition duration-150 shadow-sm flex items-center justify-center w-full sm:w-auto text-center">
                    Terug
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
