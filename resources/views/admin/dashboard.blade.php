<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 relative overflow-hidden"
                 style="background: radial-gradient(circle at 95% 10%, rgba(245, 158, 11, 0.12) 0%, rgba(255, 255, 255, 0) 50%), white;">
                
                <!-- Top Badge -->
                <span class="inline-block bg-amber-500 text-black text-[10px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-md">
                    Kapsalon applicatie
                </span>

                <!-- Title Section -->
                <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight mt-4">
                    Eigenaar
                </h1>
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">
                    Home
                </p>
                <p class="text-gray-500 text-sm mt-4 leading-relaxed max-w-2xl">
                    Welkom bij Kniploket Tiko - hier regel je eenvoudig klanten, afspraken en planning voor de salon.
                </p>

                <!-- Grid Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
                    <!-- Accounts Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Accounts</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Beheer gebruikersaccounts en roltoewijzingen.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="#" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Medewerkers Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Medewerkers</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Overzicht van medewerkers en hun basisgegevens.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="#" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Beschikbaarheid Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Beschikbaarheid</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Bekijk de beschikbaarheid van medewerkers per dag en tijd.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="#" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Klanten Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Klanten</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Bekijk en filter klantgegevens op postcode en contactinformatie.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.klanten') }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Afspraken Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Afspraken</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Plan, bekijk en beheer afspraken met status en tijd.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.afspraken') }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Behandelingen Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Behandelingen</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Overzicht van behandelingen, duur en prijsinformatie.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.behandelingen') }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Producten Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Producten</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Bekijk en beheer producten binnen het assortiment.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('admin.producten') }}" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>

                    <!-- Bestellingen Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Bestellingen</h3>
                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Bekijk en beheer klantbestellingen en bestelstatus.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="#" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-1.5 rounded-lg text-xs font-bold tracking-wide transition inline-block">
                                Openen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="text-center py-8 text-xs text-gray-400 font-medium">
                &copy; 2026 Kniploket Tiko Alle rechten voorbehouden
            </footer>
        </div>
    </div>
</x-app-layout>
