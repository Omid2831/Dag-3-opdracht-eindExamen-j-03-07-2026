<x-app-layout>
    {{-- Exam Assignment: Form view to edit customer details --}}
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="text-sm font-medium text-gray-500 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 text-[#b91c1c]">Home</a> / 
            <a href="{{ route('admin.klanten') }}" class="hover:text-gray-700 text-[#b91c1c]">Klanten</a> / 
            <span class="text-gray-900">Wijzigen</span>
        </nav>

        {{-- Error Alert --}}
        @if (session('error') || $errors->any())
            <div class="mb-6 p-4 bg-[#fde8e8] border border-[#f8b4b4] text-[#9b1c1c] rounded-lg shadow-sm">
                <span class="font-semibold text-sm">Klantgegevens zijn niet bijgewerkt.</span>
            </div>
        @endif

        {{-- Heading --}}
        <h1 class="text-3xl font-extrabold mb-6">
            <span class="text-[#b91c1c]">Klant wijzigen</span>
            <span class="text-gray-500 font-medium">{{ trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam]))) }}</span>
        </h1>

        {{-- Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
            <form method="POST" action="{{ route('admin.klanten.update', $klant->Id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Naam --}}
                    <div>
                        <label for="Naam" class="block text-sm font-bold text-gray-700 mb-2">Naam <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="Naam" id="Naam" required value="{{ old('Naam', trim(implode(' ', array_filter([$klant->Voornaam, $klant->Tussenvoegsel, $klant->Achternaam])))) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Naam') border-red-500 pr-10 @enderror">
                            @error('Naam')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Naam') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Relatienummer --}}
                    <div>
                        <label for="Relatienummer" class="block text-sm font-bold text-gray-700 mb-2">Relatienummer</label>
                        <input type="text" name="Relatienummer" id="Relatienummer" readonly value="{{ $klant->Relatienummer }}" class="w-full rounded-lg border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed">
                    </div>

                    {{-- Contact e-mail --}}
                    <div>
                        <label for="Email" class="block text-sm font-bold text-gray-700 mb-2">Contact e-mail <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="email" name="Email" id="Email" required value="{{ old('Email', $klant->ContactEmail) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Email') border-red-500 pr-10 @enderror">
                            @error('Email')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Account e-mail --}}
                    <div>
                        <label for="AccountEmail" class="block text-sm font-bold text-gray-700 mb-2">Account e-mail</label>
                        <input type="email" name="AccountEmail" id="AccountEmail" readonly value="{{ $klant->AccountEmail }}" class="w-full rounded-lg border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed">
                    </div>
                </div>

                {{-- Row 3: Straatnaam, Huisnummer, Toevoeging --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                    {{-- Straatnaam --}}
                    <div class="md:col-span-2">
                        <label for="Straatnaam" class="block text-sm font-bold text-gray-700 mb-2">Straatnaam <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="Straatnaam" id="Straatnaam" required value="{{ old('Straatnaam', $klant->Straatnaam) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Straatnaam') border-red-500 pr-10 @enderror">
                            @error('Straatnaam')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Straatnaam') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Huisnummer --}}
                    <div class="md:col-span-1">
                        <label for="Huisnummer" class="block text-sm font-bold text-gray-700 mb-2">Huisnummer <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="Huisnummer" id="Huisnummer" required value="{{ old('Huisnummer', $klant->Huisnummer) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Huisnummer') border-red-500 pr-10 @enderror">
                            @error('Huisnummer')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Huisnummer') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Toevoeging --}}
                    <div class="md:col-span-2">
                        <label for="Toevoeging" class="block text-sm font-bold text-gray-700 mb-2">Toevoeging</label>
                        <div class="relative">
                            <input type="text" name="Toevoeging" id="Toevoeging" value="{{ old('Toevoeging', $klant->Toevoeging) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Toevoeging') border-red-500 pr-10 @enderror">
                            @error('Toevoeging')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Toevoeging') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Row 4: Postcode, Plaats --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Postcode --}}
                    <div>
                        <label for="Postcode" class="block text-sm font-bold text-gray-700 mb-2">Postcode <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="Postcode" id="Postcode" required value="{{ old('Postcode', $klant->Postcode) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Postcode') border-red-500 pr-10 @enderror">
                            @error('Postcode')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Postcode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Plaats --}}
                    <div>
                        <label for="Plaats" class="block text-sm font-bold text-gray-700 mb-2">Plaats <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="Plaats" id="Plaats" required value="{{ old('Plaats', $klant->Plaats) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Plaats') border-red-500 pr-10 @enderror">
                            @error('Plaats')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Plaats') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Row 5: Mobiel --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Mobiel --}}
                    <div>
                        <label for="Mobiel" class="block text-sm font-bold text-gray-700 mb-2">Mobiel <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="Mobiel" id="Mobiel" required value="{{ old('Mobiel', $klant->Mobiel) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Mobiel') border-red-500 pr-10 @enderror">
                            @error('Mobiel')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Mobiel') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div></div>
                </div>

                {{-- Row 6: Bijzonderheden --}}
                <div class="grid grid-cols-1 gap-6 mb-6">
                    {{-- Bijzonderheden --}}
                    <div>
                        <label for="Bijzonderheden" class="block text-sm font-bold text-gray-700 mb-2">Bijzonderheden</label>
                        <div class="relative">
                            <input type="text" name="Bijzonderheden" id="Bijzonderheden" value="{{ old('Bijzonderheden', $klant->Bijzonderheden) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#b91c1c] focus:ring focus:ring-[#b91c1c] focus:ring-opacity-20 transition duration-150 @error('Bijzonderheden') border-red-500 pr-10 @enderror">
                            @error('Bijzonderheden')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('Bijzonderheden') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <p class="text-xs text-gray-500 mb-6">Velden met een <span class="text-red-500">*</span> zijn verplicht.</p>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-100 pt-6">
                    <button type="submit" class="bg-[#b91c1c] hover:bg-[#981414] text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition duration-150 cursor-pointer w-full sm:w-auto text-center">
                        Opslaan
                    </button>
                    <a href="{{ route('admin.klanten.show', $klant->Id) }}" class="border border-blue-500 hover:bg-blue-50 text-blue-500 font-bold py-2.5 px-6 rounded-lg bg-white transition duration-150 shadow-sm flex items-center justify-center w-full sm:w-auto text-center">
                        Terug
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
