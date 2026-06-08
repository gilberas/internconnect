<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Companies</h2>
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

            {{-- Stats chips --}}
            <div class="flex flex-wrap gap-3">
                @foreach ([
                    ['Total',    $counts['total'],    'gray'],
                    ['Pending',  $counts['pending'],  'amber'],
                    ['Verified', $counts['verified'], 'emerald'],
                    ['Rejected', $counts['rejected'], 'red'],
                ] as [$label, $value, $color])
                <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-2.5 shadow-sm">
                    <span class="text-xl font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ $value }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $label }}</span>
                </div>
                @endforeach
            </div>

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search company name..."
                       class="flex-1 min-w-48 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                <select name="status"
                        class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                    Filter
                </button>
                @if (request('search') || request('status'))
                    <a href="{{ route('admin.companies.index') }}"
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
                                <th class="px-5 py-3 text-left">Company</th>
                                <th class="px-5 py-3 text-left">Reg Number</th>
                                <th class="px-5 py-3 text-left">Submitted</th>
                                <th class="px-5 py-3 text-left">Status</th>
                                <th class="px-5 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse ($companies as $c)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors {{ $c->isPending() ? 'border-l-4 border-l-amber-400' : '' }}">
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.companies.show', $c) }}"
                                       class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $c->company_name }}
                                    </a>
                                    <p class="text-xs text-gray-400">{{ $c->user->email }}</p>
                                </td>
                                <td class="px-5 py-4 text-gray-500 dark:text-gray-400 font-mono text-xs">
                                    {{ $c->registration_number }}
                                </td>
                                <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                    {{ $c->created_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4">
                                    <x-status-badge :status="$c->verification_status"/>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.companies.show', $c) }}"
                                       class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                                    No companies found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($companies->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                        {{ $companies->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
