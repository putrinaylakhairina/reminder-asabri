<header class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button @click="isSidebarOpen = !isSidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:bg-gray-200 focus:outline-none sm:hidden">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': isSidebarOpen, 'inline-flex': !isSidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !isSidebarOpen, 'inline-flex': isSidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24 items-center space-x-3">
                    <img src="{{ asset('logo-bsi.png') }}" class="h-10" alt="Logo BSI" />
                    <span class="self-center text-xs font-semibold sm:text-lg whitespace-nowrap text-primary">REMINDER ASABRI</span>
                </a>
            </div>
            <div class="flex items-center">
                <div x-data="{ open: false }" class="relative flex items-center ms-3">
                    <div>
                        <button @click="open = !open" type="button" class="flex items-center justify-center w-10 h-10 rounded-full focus:ring-4 focus:ring-gray-300 hover:bg-gray-200" aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            <x-lucide-user class="w-6 h-6 text-gray-800" />
                        </button>
                    </div>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg top-full"
                         style="display: none;">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900" role="none">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profil</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Keluar
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
