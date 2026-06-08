<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Desktop right side: role badge + bell + user dropdown -->
            <div class="hidden sm:flex items-center gap-3">

                {{-- Role badge --}}
                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                    @if(auth()->user()->isStudent()) bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                    @elseif(auth()->user()->isCompany()) bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                    @else bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300
                    @endif">
                    {{ ucfirst(auth()->user()->account_type) }}
                </span>

                {{-- Notification Bell --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="relative w-9 h-9 flex items-center justify-center rounded-xl
                                   hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors
                                   text-gray-500 dark:text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0
                                  00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0
                                  .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs
                                     rounded-full flex items-center justify-center font-bold leading-none">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 top-12 w-80 bg-white dark:bg-gray-900 rounded-2xl
                                shadow-xl border border-gray-100 dark:border-gray-800 z-50 overflow-hidden">

                        {{-- Header --}}
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800
                                    flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.read-all') }}">
                                @csrf
                                <button type="submit"
                                        class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    Mark all read
                                </button>
                            </form>
                            @endif
                        </div>

                        {{-- Notification list --}}
                        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse(auth()->user()->notifications()->take(8)->get() as $notif)
                            <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800
                                               transition-colors flex gap-3 items-start
                                               {{ is_null($notif->read_at) ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                                    <div class="mt-1.5 shrink-0">
                                        <div class="w-2 h-2 rounded-full {{ is_null($notif->read_at) ? 'bg-blue-500' : 'bg-transparent' }}"></div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $notif->data['title'] ?? 'Notification' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                            {{ $notif->data['message'] ?? '' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </button>
                            </form>
                            @empty
                            <div class="px-4 py-8 text-center text-gray-400 text-xs">
                                No notifications yet.
                            </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800 text-center">
                            <a href="{{ route('notifications.index') }}"
                               class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm
                                       leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400
                                       bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300
                                       focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @hasrole('student')
                        <x-dropdown-link :href="route('student.profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        @elsehasrole('company')
                        <x-dropdown-link :href="route('company.profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        @else
                        <x-dropdown-link :href="route('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>
                        @endrole

                        <x-dropdown-link :href="route('notifications.index')">
                            {{ __('Notifications') }}
                            @if($unreadCount > 0)
                            <span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                                {{ $unreadCount }}
                            </span>
                            @endif
                        </x-dropdown-link>

                        <!-- Authentication -->
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                               dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none
                               focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500
                               dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
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
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @hasrole('student')
                <x-responsive-nav-link :href="route('student.profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                @elsehasrole('company')
                <x-responsive-nav-link :href="route('company.profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                @else
                <x-responsive-nav-link :href="route('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                @endrole

                <x-responsive-nav-link :href="route('notifications.index')">
                    {{ __('Notifications') }}
                    @if($unreadCount > 0)
                    <span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
