<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Users</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search name or email..."
                       class="flex-1 min-w-48 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                <select name="type"
                        class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="student" {{ request('type') === 'student' ? 'selected' : '' }}>Students</option>
                    <option value="company" {{ request('type') === 'company' ? 'selected' : '' }}>Companies</option>
                </select>
                <select name="status"
                        class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                    Filter
                </button>
                @if (request('search') || request('type') || request('status'))
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Clear
                    </a>
                @endif
            </form>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 text-left">User</th>
                                <th class="px-5 py-3 text-left">Type</th>
                                <th class="px-5 py-3 text-left">Joined</th>
                                <th class="px-5 py-3 text-left">Status</th>
                                <th class="px-5 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse ($users as $u)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors {{ $u->isSuspended() ? 'border-l-4 border-l-red-400' : '' }}">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $u->email }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $u->isStudent()
                                            ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'
                                            : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' }}">
                                        {{ ucfirst($u->account_type) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                    {{ $u->created_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4">
                                    <x-status-badge :status="$u->status"/>
                                </td>
                                <td class="px-5 py-4" x-data="{ open: false }">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.users.show', $u) }}"
                                           class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                            View
                                        </a>
                                        @if ($u->isSuspended())
                                            <form method="POST" action="{{ route('admin.users.reactivate', $u) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="text-xs font-medium text-emerald-600 dark:text-emerald-400 hover:underline">
                                                    Reactivate
                                                </button>
                                            </form>
                                        @else
                                            <button @click="open = !open"
                                                    class="text-xs font-medium text-red-500 dark:text-red-400 hover:underline">
                                                Suspend
                                            </button>
                                        @endif
                                    </div>

                                    @if (!$u->isSuspended())
                                    <div x-show="open" x-cloak
                                         class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                        <form method="POST" action="{{ route('admin.users.suspend', $u) }}" class="space-y-2">
                                            @csrf @method('PATCH')
                                            <textarea name="suspended_reason" required rows="2"
                                                      placeholder="Reason for suspension (min 10 characters)..."
                                                      class="w-full rounded-lg border-red-300 dark:border-red-700 dark:bg-gray-800 text-xs focus:ring-red-500 resize-none"></textarea>
                                            <div class="flex gap-2">
                                                <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                                    Confirm Suspend
                                                </button>
                                                <button type="button" @click="open = false"
                                                        class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-xs text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
