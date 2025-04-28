<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 h-screen w-64 fixed flex flex-col border-r border-gray-200 dark:border-gray-700 shadow-lg">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-12 w-auto fill-current text-blue-700 dark:text-white" />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 space-y-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8h4v-8m-4 0h4" />
            </svg>
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.index')" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-6l-2-2H4a2 2 0 00-2 2v6h18z" />
            </svg>
            {{ __('Produk') }}
        </x-nav-link>

        <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.index')" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            {{ __('Kategori') }}
        </x-nav-link>

        <x-nav-link :href="route('keranjang.index')" :active="request()->routeIs('keranjang.index')" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m5-9l2 9" />
            </svg>
            {{ __('Keranjang') }}
        </x-nav-link>

        <x-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi.index')" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a4 4 0 100-8 4 4 0 000 8zm4.5-4H21m-8.5-4h7.5M3 17h7.5" />
            </svg>
            {{ __('Transaksi') }}
        </x-nav-link>
    </div>

    
</nav>

<!-- Top Navigation Bar -->
<div class="ml-64 flex items-center justify-end h-20 px-6 bg-blue-800 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow">
    <div class="flex items-center space-x-4">
        <!-- Profile Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center text-sm font-medium text-white dark:text-gray-400  dark:hover:text-white focus:outline-none">
                    <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
</svg>

                    </div>
                    <div>{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="ml-1">
                        <svg class="h-4 w-4 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>
