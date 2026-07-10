<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kniploket Tiko - Moderne Kapsalon</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .serif-title {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-[#FAF8F5] text-[#2C2621] min-h-screen flex flex-col antialiased">
    <!-- Header/Nav -->
    <header class="sticky top-0 z-50 bg-[#FAF8F5]/90 backdrop-blur-md border-b border-[#E6DCD3] transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <span class="serif-title text-2xl font-bold tracking-tight text-[#6D4C3D] hover:text-[#52382D] transition-colors">
                    Kniploket <span class="italic text-[#C99A80]">Tiko</span>
                </span>
            </a>

            <!-- Navigation Links (Placeholder/Informational) -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-[#5C5046]">
                <a href="#behandelingen" class="hover:text-[#C99A80] transition-colors">Behandelingen</a>
                <a href="#specialisten" class="hover:text-[#C99A80] transition-colors">Onze Specialisten</a>
                <a href="#producten" class="hover:text-[#C99A80] transition-colors">Producten</a>
                <a href="#over-ons" class="hover:text-[#C99A80] transition-colors">Over Ons</a>
            </nav>

            <!-- Auth Actions -->
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-[#6D4C3D] hover:bg-[#52382D] shadow-sm hover:shadow transition-all">
                            Naar Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-semibold text-[#5C5046] hover:text-[#6D4C3D] transition-colors">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2.5 rounded-full text-sm font-semibold text-[#FAF8F5] bg-[#C99A80] hover:bg-[#B5856B] shadow-sm hover:shadow transition-all">
                                Registreren
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-[#F5EFE9] to-[#FAF8F5] py-20 lg:py-32 overflow-hidden border-b border-[#E6DCD3]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-8 text-left">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#EAE0D5] text-[#6D4C3D] uppercase tracking-wider">
                        Welkom bij Kniploket Tiko
                    </span>
                    <h1 class="serif-title text-4xl sm:text-5xl lg:text-6xl font-bold text-[#42332A] leading-tight">
                        Jouw haar is onze <br class="hidden sm:inline">
                        <span class="italic text-[#C99A80] relative">
                            passie en specialiteit
                            <span class="absolute bottom-1 left-0 w-full h-[6px] bg-[#C99A80]/20 -z-10"></span>
                        </span>
                    </h1>
                    <p class="text-lg text-[#5C5046] max-w-xl leading-relaxed">
                        Kniploket Tiko is een moderne kapsalon geleid door Lisa Jansen en haar team van 4 ervaren specialisten. Of je nu komt voor knippen, kleuren, extensions of professionele verzorging; wij zorgen dat je straalt.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-full text-center font-semibold text-white bg-[#6D4C3D] hover:bg-[#52382D] transition-all shadow-md">
                                Plan je afspraak
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 rounded-full text-center font-semibold text-white bg-[#6D4C3D] hover:bg-[#52382D] transition-all shadow-md">
                                Maak een account & Boek online
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-full text-center font-semibold text-[#6D4C3D] border border-[#6D4C3D] hover:bg-[#FAF8F5] transition-all">
                                Log in voor bestellingen
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="lg:col-span-5 relative">
                    <!-- Elegant Abstract Styling Element instead of complex images -->
                    <div class="aspect-square bg-gradient-to-tr from-[#E6DCD3] to-[#FAF8F5] rounded-3xl p-8 border border-[#E6DCD3] shadow-lg flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <span class="text-4xl text-[#6D4C3D] font-bold">✨</span>
                            <span class="text-sm font-semibold text-[#C99A80] bg-[#FAF8F5] px-3 py-1 rounded-full shadow-sm">Online Boeken</span>
                        </div>
                        <div class="space-y-4">
                            <p class="serif-title text-2xl font-bold text-[#42332A]">"Eenvoudig online je afspraak plannen & haarproducten bestellen."</p>
                            <div class="h-1 w-20 bg-[#C99A80] rounded-full"></div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-[#6D4C3D] text-[#FAF8F5] flex items-center justify-center font-bold text-sm">LJ</div>
                            <div>
                                <p class="text-sm font-bold text-[#42332A]">Lisa Jansen</p>
                                <p class="text-xs text-[#5C5046]">Eigenaresse & Stylist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Behandelingen Section -->
        <section id="behandelingen" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                <div class="max-w-2xl mx-auto space-y-4">
                    <h2 class="serif-title text-3xl sm:text-4xl font-bold text-[#42332A]">Onze Behandelingen</h2>
                    <p class="text-[#5C5046]">Elke medewerker heeft een eigen specialisme om je van de beste zorg te voorzien.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Knippen -->
                    <div class="p-8 bg-[#FAF8F5] rounded-2xl border border-[#E6DCD3] text-left space-y-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-[#6D4C3D]/10 rounded-xl flex items-center justify-center text-[#6D4C3D] text-2xl">✂️</div>
                        <h3 class="text-lg font-bold text-[#42332A]">Knippen</h3>
                        <p class="text-sm text-[#5C5046] leading-relaxed">Modern of klassiek, voor dames, heren en kinderen. Precies afgestemd op jouw wensen.</p>
                    </div>
                    <!-- Verven -->
                    <div class="p-8 bg-[#FAF8F5] rounded-2xl border border-[#E6DCD3] text-left space-y-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-[#C99A80]/10 rounded-xl flex items-center justify-center text-[#C99A80] text-2xl">🎨</div>
                        <h3 class="text-lg font-bold text-[#42332A]">Kleuren & Balayage</h3>
                        <p class="text-sm text-[#5C5046] leading-relaxed">Van subtiele highlights tot complete transformaties met haarvriendelijke verfproducten.</p>
                    </div>
                    <!-- Stylen -->
                    <div class="p-8 bg-[#FAF8F5] rounded-2xl border border-[#E6DCD3] text-left space-y-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-[#6D4C3D]/10 rounded-xl flex items-center justify-center text-[#6D4C3D] text-2xl">👱‍♀️</div>
                        <h3 class="text-lg font-bold text-[#42332A]">Extensions & Styling</h3>
                        <p class="text-sm text-[#5C5046] leading-relaxed">Volume- en lengtebehandelingen met premium extensions en feestelijke styling.</p>
                    </div>
                    <!-- Haarverzorging -->
                    <div class="p-8 bg-[#FAF8F5] rounded-2xl border border-[#E6DCD3] text-left space-y-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-[#C99A80]/10 rounded-xl flex items-center justify-center text-[#C99A80] text-2xl">🧴</div>
                        <h3 class="text-lg font-bold text-[#42332A]">Haarverzorging</h3>
                        <p class="text-sm text-[#5C5046] leading-relaxed">Diepvoedende maskers, hoofdhuidmassages en advies voor het behoud van gezond haar.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Specialisten Section -->
        <section id="specialisten" class="py-20 bg-[#F5EFE9] border-t border-b border-[#E6DCD3]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                <div class="max-w-2xl mx-auto space-y-4">
                    <h2 class="serif-title text-3xl sm:text-4xl font-bold text-[#42332A]">Onze Specialisten</h2>
                    <p class="text-[#5C5046]">Ontmoet het team dat klaarstaat om je te adviseren en te verzorgen.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    <!-- Lisa -->
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-[#E6DCD3] flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-[#6D4C3D] text-white flex items-center justify-center text-xl font-bold">LJ</div>
                        <h3 class="font-bold text-[#42332A]">Lisa Jansen</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#6D4C3D]/10 text-[#6D4C3D] font-medium">Eigenaresse & All-round</span>
                    </div>
                    <!-- Specialist 1 -->
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-[#E6DCD3] flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-[#C99A80] text-white flex items-center justify-center text-xl font-bold">SM</div>
                        <h3 class="font-bold text-[#42332A]">Sarah</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#C99A80]/10 text-[#B5856B] font-medium">Kleurspecialist</span>
                    </div>
                    <!-- Specialist 2 -->
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-[#E6DCD3] flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-[#6D4C3D] text-white flex items-center justify-center text-xl font-bold">MK</div>
                        <h3 class="font-bold text-[#42332A]">Mike</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#6D4C3D]/10 text-[#6D4C3D] font-medium">Heren & Barber</span>
                    </div>
                    <!-- Specialist 3 -->
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-[#E6DCD3] flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-[#C99A80] text-white flex items-center justify-center text-xl font-bold">EM</div>
                        <h3 class="font-bold text-[#42332A]">Emma</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#C99A80]/10 text-[#B5856B] font-medium">Extensions Expert</span>
                    </div>
                    <!-- Specialist 4 -->
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-[#E6DCD3] flex flex-col items-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-[#6D4C3D] text-white flex items-center justify-center text-xl font-bold">SP</div>
                        <h3 class="font-bold text-[#42332A]">Sophie</h3>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#6D4C3D]/10 text-[#6D4C3D] font-medium">Haarverzorging</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Producten Bestellen Section -->
        <section id="producten" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 text-left">
                    <h2 class="serif-title text-3xl sm:text-4xl font-bold text-[#42332A]">Haarverzorging voor Thuis</h2>
                    <p class="text-[#5C5046] leading-relaxed text-lg">
                        Bij Kniploket Tiko werken én adviseren we alleen met de beste producten. Sinds kort kun je jouw favoriete shampoo, conditioner en stylingproducten ook eenvoudig online bij ons bestellen.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <span class="text-[#C99A80] text-xl font-bold">✔</span>
                            <p class="text-sm text-[#5C5046]"><strong class="text-[#42332A]">Online bestellen:</strong> Selecteer de gewenste producten in onze webshop na het inloggen.</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-[#C99A80] text-xl font-bold">✔</span>
                            <p class="text-sm text-[#5C5046]"><strong class="text-[#42332A]">Afhalen in de salon:</strong> Je bestelling ligt snel voor je klaar om afgehaald te worden.</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-[#C99A80] text-xl font-bold">✔</span>
                            <p class="text-sm text-[#5C5046]"><strong class="text-[#42332A]">Voorraadgarantie:</strong> Doordat ons systeem de voorraad live bijhoudt, grijp je nooit mis.</p>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 rounded-full text-sm font-semibold text-white bg-[#C99A80] hover:bg-[#B5856B] transition-all shadow-sm">
                            Naar de webshop
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 rounded-full text-sm font-semibold text-white bg-[#C99A80] hover:bg-[#B5856B] transition-all shadow-sm">
                            Log in om te bestellen
                        </a>
                    @endauth
                </div>
                <div class="bg-[#FAF8F5] p-8 rounded-2xl border border-[#E6DCD3] space-y-6">
                    <h3 class="serif-title text-xl font-bold text-[#42332A]">Populaire Producten</h3>
                    <div class="divide-y divide-[#E6DCD3]">
                        <div class="py-4 flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-sm text-[#42332A]">Hydrating Shampoo (250ml)</h4>
                                <p class="text-xs text-[#5C5046]">Ideaal voor droog of beschadigd haar</p>
                            </div>
                            <span class="text-sm font-bold text-[#6D4C3D]">€ 18,50</span>
                        </div>
                        <div class="py-4 flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-sm text-[#42332A]">Argan Oil Hair Treatment (100ml)</h4>
                                <p class="text-xs text-[#5C5046]">Voor extra glans en pluisvrij resultaat</p>
                            </div>
                            <span class="text-sm font-bold text-[#6D4C3D]">€ 24,95</span>
                        </div>
                        <div class="py-4 flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-sm text-[#42332A]">Matte Clay Hair Wax (75ml)</h4>
                                <p class="text-xs text-[#5C5046]">Sterke hold met een natuurlijke matte finish</p>
                            </div>
                            <span class="text-sm font-bold text-[#6D4C3D]">€ 16,50</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Over Ons Section -->
        <section id="over-ons" class="py-20 bg-[#FAF8F5] border-t border-[#E6DCD3]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                <h2 class="serif-title text-3xl sm:text-4xl font-bold text-[#42332A]">Over Kniploket Tiko</h2>
                <p class="text-lg text-[#5C5046] leading-relaxed">
                    Lisa Jansen startte de salon vijf jaar geleden als zelfstandige. Dankzij haar persoonlijke benadering, oog voor kwaliteit en groeiende klantenkring is Kniploket Tiko uitgegroeid tot een gevestigde waarde in de stad met vier professionele medewerkers in dienst. Onze missie is simpel: een rustpunt in je dag creëren en je met een glimlach én prachtig haar de deur uit laten gaan.
                </p>
                <div class="grid sm:grid-cols-3 gap-6 pt-6">
                    <div class="p-6 bg-white rounded-xl border border-[#E6DCD3]">
                        <p class="text-3xl font-extrabold text-[#C99A80]">5+</p>
                        <p class="text-xs text-[#5C5046] font-medium uppercase tracking-wider">Jaar Ervaring</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-[#E6DCD3]">
                        <p class="text-3xl font-extrabold text-[#C99A80]">5</p>
                        <p class="text-xs text-[#5C5046] font-medium uppercase tracking-wider">Haarspecialisten</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl border border-[#E6DCD3]">
                        <p class="text-3xl font-extrabold text-[#C99A80]">100%</p>
                        <p class="text-xs text-[#5C5046] font-medium uppercase tracking-wider">Klanttevredenheid</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#2C2621] text-[#E6DCD3] border-t border-[#42332A] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            <!-- Salon Info -->
            <div class="space-y-4">
                <h4 class="serif-title text-xl font-bold text-white">Kniploket Tiko</h4>
                <p class="text-sm leading-relaxed text-[#A1958D]">
                    De moderne kapsalon voor knippen, kleuren, extensions en professionele haarverzorging in de stad.
                </p>
            </div>
            <!-- Opening Hours -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm uppercase tracking-wider text-white">Openingstijden</h4>
                <ul class="text-sm space-y-2 text-[#A1958D]">
                    <li class="flex justify-between"><span>Dinsdag - Vrijdag:</span> <span>09:00 - 18:00</span></li>
                    <li class="flex justify-between"><span>Zaterdag:</span> <span>08:30 - 16:00</span></li>
                    <li class="flex justify-between"><span>Zondag & Maandag:</span> <span class="italic">Gesloten</span></li>
                </ul>
            </div>
            <!-- Contact -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm uppercase tracking-wider text-white">Contact & Locatie</h4>
                <p class="text-sm text-[#A1958D]">
                    Hoofdstraat 42<br>
                    1234 AB Haarstad<br>
                    Tel: 012-3456789<br>
                    E-mail: info@kniplokettiko.nl
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 mt-8 border-t border-[#42332A] text-center text-xs text-[#A1958D]">
            <p>&copy; {{ date('Y') }} Kniploket Tiko. Alle rechten voorbehouden.</p>
        </div>
    </footer>
</body>

</html>
