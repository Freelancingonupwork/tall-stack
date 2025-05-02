<nav class="main-header bg-white">
    <div class="max-w-7x2 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-gray-800 text-white">
                        Shop
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-white hover:text-black">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-white hover:text-black">
                        {{ __('Categories') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')" class="text-white hover:text-black">
                        {{ __('Cart') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden sm:flex sm:items-center ml-auto">
                <livewire:search-products />
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 settings-dropdown ">
                @auth('customer')
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="text-white user-dropdown inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-white hover:text-black transition ease-in-out duration-150">
                                <div>{{ Auth::guard('customer')->user()->name }}</div>

                                <div class="ml-1 text-white hover:text-black">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('customer.dashboard')" class="text-black dropdown-menu">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('orders.index')" class="text-black dropdown-menu">
                                {{ __('My Orders') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-menu">
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('customer.login') }}" class="text-sm text-white hover:text-black">Login</a>
                        <a href="{{ route('customer.register') }}" class="ml-4 text-sm text-white bg-indigo-600 py-2 px-4 rounded-md hover:bg-indigo-700 register-btn">Register</a>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <livewire:navigation-cart />
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-white hover:text-black transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="block pl-3 pr-4 py-2 text-white hover:text-black">
                {{ __('Products') }}
            </x-nav-link>
            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="block pl-3 pr-4 py-2 text-white hover:text-black">
                {{ __('Categories') }}
            </x-nav-link>
            <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')" class="block pl-3 pr-4 py-2 text-white hover:text-black">
                {{ __('Cart') }}
            </x-nav-link>
        </div>

        <!-- Mobile menu user section -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth('customer')
                <div class="px-4">
                    <div class="font-medium text-base text-white hover:text-black">{{ Auth::guard('customer')->user()->name }}</div>
                    <div class="font-medium text-sm text-white hover:text-black">{{ Auth::guard('customer')->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-nav-link :href="route('customer.dashboard')" class="block pl-3 pr-4 py-2 text-black hover:text-black">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" class="block pl-3 pr-4 py-2 text-black hover:text-black">
                        {{ __('My Orders') }}
                    </x-nav-link>
                    <x-nav-link href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="block pl-3 pr-4 py-2">
                        {{ __('Log Out') }}
                    </x-nav-link>
                    <form id="mobile-logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-nav-link :href="route('customer.login')" class="block pl-3 pr-4 py-2 text-white hover:text-black">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('customer.register')" class="block pl-3 pr-4 py-2 text-white hover:text-black register-btn ">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav> 