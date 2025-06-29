<nav class="bg-primary-700" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-auto w-45" src="{{ asset('storage/img/books/logo1.png') }}"
                        alt="TOBUK | Albert Einstein Suka Baca Buku..">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Current: "bg-primary-900 text-white", Default: "text-primary-300 hover:bg-primary-700 hover:text-white" -->
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/books" :active="request()->is('books')">Book</x-nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    @auth
                        {{-- Keranjang notif --}}
                        <a href="{{ route('keranjang.index') }}"
                            class="relative rounded-full bg-primary-800 p-1 text-primary-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-500 focus:outline-hidden">
                            <span class="sr-only">View cart</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="none" class="size-6"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                            </svg>

                            {{-- INI BAGIAN BARU UNTUK NOTIFIKASI --}}
                            @auth
                                @if ($cartCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            @endauth
                            {{-- AKHIR BAGIAN BARU --}}
                        </a>

                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-primary-700 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-700 focus:outline-hidden"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="size-8 rounded-full"
                                        src="{{ asset('storage/img/books/default-profile.jpg') }}" alt="">
                                </button>
                            </div>

                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-primary-100 outline-hidden", Not Active: "" -->
                                <a href="#" class="block px-4 py-2 text-sm text-primary-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Sup? {{ Auth::user()->name }}</a>
                                <a href="/dashboard" class="block px-4 py-2 text-sm text-primary-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Dashboard</a>
                                <a href="/wishlist" class="block px-4 py-2 text-sm text-primary-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Favorites</a>
                                <form action="/logout" method="POST"> @csrf <button type="submit"
                                        class="block px-4 py-2 text-sm text-primary-700" role="menuitem" tabindex="-1"
                                        id="user-menu-item-2">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Login/Register --}}
                        <x-nav-link href="/login" :active="request()->is('login')">Login</x-nav-link>
                        <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
                    @endauth

                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-primary-800 p-2 text-primary-400 hover:bg-primary-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-800 focus:outline-hidden"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <!-- Current: "bg-primary-900 text-white", Default: "text-primary-300 hover:bg-primary-700 hover:text-white" -->
            <x-nav-link-mobile href="/" :active="request()->is('/')">Home</x-nav-link-mobile>
            <x-nav-link-mobile href="/books" :active="request()->is('books')">Book</x-nav-link-mobile>
            <x-nav-link-mobile href="/login" :active="request()->is('login')">Login</x-nav-link-mobile>
            <x-nav-link-mobile href="/register" :active="request()->is('register')">Login</x-nav-link-mobile>
        </div>
        <div class="border-t border-primary-700 pt-4 pb-3">
            <div class="flex items-center px-5">
                <div class="shrink-0">
                    <img class="size-10 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base/5 font-medium text-white">Tom Cook</div>
                    <div class="text-sm font-medium text-primary-400">tom@example.com</div>
                </div>
                <button type="button"
                    class="relative ml-auto shrink-0 rounded-full bg-primary-800 p-1 text-primary-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-800 focus:outline-hidden">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">View notifications</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </button>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-primary-400 hover:bg-primary-700 hover:text-white">Your
                    Profile</a>
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-primary-400 hover:bg-primary-700 hover:text-white">Settings</a>
                <a href="#"
                    class="block rounded-md px-3 py-2 text-base font-medium text-primary-400 hover:bg-primary-700 hover:text-white">Sign
                    out</a>
            </div>
        </div>
    </div>
</nav>
