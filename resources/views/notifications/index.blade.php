<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h2>
            @if (auth()->user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit"
                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    Mark all as read
                </button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Filter tabs --}}
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            <div class="flex gap-2">
                <a href="{{ route('notifications.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
                          {{ ! request('filter')
                              ? 'bg-blue-600 text-white'
                              : 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    All
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium transition-colors
                          {{ request('filter') === 'unread'
                              ? 'bg-blue-600 text-white'
                              : 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    Unread
                    @if ($unread > 0)
                    <span class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full leading-none">
                        {{ $unread }}
                    </span>
                    @endif
                </a>
            </div>

            {{-- Notifications list --}}
            @if ($notifications->isEmpty())
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-16 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2
                              2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595
                              1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-sm text-gray-400">
                        {{ request('filter') === 'unread' ? 'No unread notifications.' : 'No notifications yet.' }}
                    </p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach ($notifications as $notif)
                    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left bg-white dark:bg-gray-900 rounded-xl border
                                       hover:shadow-sm transition-all flex gap-4 items-start p-4
                                       {{ is_null($notif->read_at)
                                           ? 'border-l-4 border-l-blue-500 border-gray-100 dark:border-gray-800'
                                           : 'border-gray-100 dark:border-gray-800' }}">
                            <div class="mt-1 shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full {{ is_null($notif->read_at) ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                            </div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $notif->data['title'] ?? 'Notification' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $notif->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1.5">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if (is_null($notif->read_at))
                            <span class="shrink-0 text-xs text-blue-600 dark:text-blue-400 font-medium self-center">
                                Mark read
                            </span>
                            @endif
                        </button>
                    </form>
                    @endforeach
                </div>

                @if ($notifications->hasPages())
                    <div class="mt-4">{{ $notifications->links() }}</div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
