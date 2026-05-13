<aside :class="{'translate-x-0': isSidebarOpen}" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-secondary to-secondary" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            {{-- Common Menu --}}
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-background-alt group {{ request()->routeIs('dashboard') ? 'bg-background-alt' : '' }}">
                    <x-lucide-layout-dashboard class="w-5 h-5 text-black" />
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            {{-- Role-based Menus --}}
            @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.pensioners.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-background-alt group {{ request()->routeIs('admin.pensioners.*') ? 'bg-background-alt' : '' }}">
                        <x-lucide-users class="w-5 h-5 text-black" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Data Pensiunan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reminders.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-background-alt group {{ request()->routeIs('admin.reminders.*') ? 'bg-background-alt' : '' }}">
                        <x-lucide-bell class="w-5 h-5 text-black" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Reminder</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.history.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-background-alt group {{ request()->routeIs('admin.history.*') ? 'bg-background-alt' : '' }}">
                        <x-lucide-history class="w-5 h-5 text-black" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Notifikasi</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->role === 'asabri')
                <li>
                    <a href="{{ route('asabri.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-background-alt group {{ request()->routeIs('asabri.dashboard') ? 'bg-background-alt' : '' }}">
                        <x-lucide-file-text class="w-5 h-5 text-black" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Data Pribadi</span>
                    </a>
                </li>
            @endif
        </ul>

        {{-- Logout Button at the bottom --}}
        <div class="absolute bottom-0 left-0 w-full p-4">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <x-lucide-log-out class="w-5 h-5 text-black" />
                    <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
                </a>
            </form>

            <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        © 2026 One Seulanga Nusantara. All rights reserved.
                    </p>
                </div>
                
        </div>
    </div>
</aside>
