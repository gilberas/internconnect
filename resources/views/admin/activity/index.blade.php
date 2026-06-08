<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Activity Log</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Action</label>
                    <select name="action"
                            class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                        <option value="">All Actions</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $action)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">From</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                           class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">To</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                           class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                </div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    Filter
                </button>
                @if (request('action') || request('from') || request('to'))
                    <a href="{{ route('admin.activity.index') }}"
                       class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
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
                                <th class="px-5 py-3 text-left">Action</th>
                                <th class="px-5 py-3 text-left">Subject</th>
                                <th class="px-5 py-3 text-left">IP Address</th>
                                <th class="px-5 py-3 text-left">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse ($logs as $log)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-5 py-3.5">
                                    @if ($log->user)
                                        <p class="font-medium text-gray-900 dark:text-white text-xs">{{ $log->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $log->user->email }}</p>
                                    @else
                                        <span class="text-xs text-gray-400 italic">System</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if (str_starts_with($log->action, 'verify') || str_starts_with($log->action, 'approve') || str_starts_with($log->action, 'reactivate'))
                                            bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                                        @elseif (str_starts_with($log->action, 'reject') || str_starts_with($log->action, 'suspend') || str_starts_with($log->action, 'revoke'))
                                            bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                                        @else
                                            bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-500 dark:text-gray-400">
                                    @if ($log->subject_type)
                                        {{ class_basename($log->subject_type) }}
                                        @if ($log->subject_id)
                                            <span class="text-gray-400">#{{ $log->subject_id }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-500 dark:text-gray-400 font-mono">
                                    {{ $log->ip_address ?? '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    <span title="{{ $log->created_at->format('d M Y, H:i:s') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">No activity recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($logs->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
