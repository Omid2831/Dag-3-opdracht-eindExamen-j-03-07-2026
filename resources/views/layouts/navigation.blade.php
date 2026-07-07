@if(Auth::user()->role === 'eigenaar')
    <nav x-data="{ open: false }" class="bg-[#b91c1c] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4 xl:space-x-10 shrink min-w-0">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <span class="font-extrabold text-lg xl:text-xl tracking-wider text-white whitespace-nowrap">
                            KNIPLOKET TIKO
                        </span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden lg:flex lg:space-x-1 xl:space-x-2 2xl:space-x-3 lg:text-[10px] xl:text-[11px] 2xl:text-xs font-semibold whitespace-nowrap min-w-0 items-center">
                        <a href="#" class="text-white px-2 py-1.5 rounded-lg transition hover:text-red-200">Accounts</a>
                        <a href="#" class="text-white px-2 py-1.5 rounded-lg transition hover:text-red-200">Medewerkers</a>
                        <a href="#" class="text-white px-2 py-1.5 rounded-lg transition hover:text-red-200">Beschikbaarheid</a>
                        <a href="{{ route('admin.klanten') }}" class="text-white px-2 py-1.5 rounded-lg transition {{ request()->routeIs('admin.klanten') ? 'bg-[#981414] font-bold shadow-inner' : 'hover:text-red-200' }}">Klanten</a>
                        <a href="{{ route('admin.afspraken') }}" class="text-white px-2 py-1.5 rounded-lg transition {{ request()->routeIs('admin.afspraken') ? 'bg-[#981414] font-bold shadow-inner' : 'hover:text-red-200' }}">Afspraken</a>
                        <a href="{{ route('admin.behandelingen') }}" class="text-white px-2 py-1.5 rounded-lg transition {{ request()->routeIs('admin.behandelingen') ? 'bg-[#981414] font-bold shadow-inner' : 'hover:text-red-200' }}">Behandelingen</a>
                        <a href="{{ route('admin.producten') }}" class="text-white px-2 py-1.5 rounded-lg transition {{ request()->routeIs('admin.producten') ? 'bg-[#981414] font-bold shadow-inner' : 'hover:text-red-200' }}">Producten</a>
                        <a href="#" class="text-white px-2 py-1.5 rounded-lg transition hover:text-red-200">Bestellingen</a>
                    </div>
                </div>

                <!-- Right Side: User Name and Logout -->
                <div class="hidden lg:flex lg:items-center lg:space-x-3 shrink-0">
                    <span class="hidden xl:inline text-xs text-red-100 whitespace-nowrap">
                        {{ Auth::user()->name }} ({{ Auth::user()->role }})
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="border border-white/80 hover:bg-white hover:text-[#b91c1c] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 whitespace-nowrap">
                            Uitloggen
                        </button>
                    </form>
                </div>

                <!-- Mobile Hamburger -->
                <div class="-me-2 flex items-center lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-red-200 hover:text-white hover:bg-red-800 focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-[#a11818] border-t border-red-800">
            <div class="pt-2 pb-3 space-y-1">
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Accounts</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Medewerkers</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Beschikbaarheid</a>
                <a href="{{ route('admin.klanten') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Klanten</a>
                <a href="{{ route('admin.afspraken') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Afspraken</a>
                <a href="{{ route('admin.behandelingen') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Behandelingen</a>
                <a href="{{ route('admin.producten') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Producten</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">Bestellingen</a>
            </div>

            <!-- Responsive User Info -->
            <div class="pt-4 pb-1 border-t border-red-800">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-red-200">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:bg-red-800 transition">
                            Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@else
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
@endif
