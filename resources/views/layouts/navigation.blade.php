<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left -->
            <div class="flex items-center">
                
                <!-- Logo Stockify -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-boxes-stacked text-white text-lg"></i>
                    </div>

                    <span class="text-gray-800 dark:text-white font-bold text-lg">
                        Stockify
                    </span>

                </a>

                <!-- Menu -->
                <div class="hidden sm:flex sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                </div>

            </div>

            <!-- Right (User + Logout) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <span class="text-gray-700 dark:text-gray-300 mr-4">
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400 hover:text-gray-500">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden p-4">

        <div class="mb-2 text-gray-800 dark:text-white">
            {{ Auth::user()->name }}
        </div>

        <x-responsive-nav-link :href="route('dashboard')">
            Dashboard
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="text-red-400">Logout</button>
        </form>

    </div>
</nav>