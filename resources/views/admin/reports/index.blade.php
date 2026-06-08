<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Reports & Analytics</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('error'))
                <div class="flex items-center gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Date filter --}}
            <form method="GET" action="{{ route('admin.reports.index') }}"
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5
                         flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">From Date</label>
                    <input type="date" name="from_date" value="{{ $from }}"
                           class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">To Date</label>
                    <input type="date" name="to_date" value="{{ $to }}"
                           class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-blue-500">
                </div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    Apply Filter
                </button>
                @if (request('from_date') || request('to_date'))
                    <a href="{{ route('admin.reports.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Summary stat cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach ([
                    ['Students',     $students['total'],     'blue'],
                    ['Companies',    $companies['total'],    'emerald'],
                    ['Internships',  $internships['total'],  'indigo'],
                    ['Applications', $applications['total'], 'purple'],
                    ['Interviews',   $interviews['total'],   'amber'],
                ] as [$label, $val, $color])
                <div class="bg-white dark:bg-gray-900 rounded-xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm text-center">
                    <p class="text-3xl font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ $val }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $label }}</p>
                </div>
                @endforeach
            </div>

            {{-- Report sections --}}
            @foreach ([
                ['Students',     'students',     $students,
                    ['Total' => $students['total'], 'This Month' => $students['this_month']]],
                ['Companies',    'companies',    $companies,
                    ['Total' => $companies['total'], 'Verified' => $companies['verified'], 'Pending' => $companies['pending'], 'Rejected' => $companies['rejected']]],
                ['Internships',  'internships',  $internships,
                    ['Total' => $internships['total'], 'Approved' => $internships['approved'], 'Pending' => $internships['pending'], 'Closed' => $internships['closed']]],
                ['Applications', 'applications', $applications,
                    ['Total' => $applications['total'], 'Submitted' => $applications['submitted'], 'Accepted' => $applications['accepted'], 'Rejected' => $applications['rejected']]],
                ['Interviews',   'interviews',   $interviews,
                    ['Total' => $interviews['total'], 'Completed' => $interviews['completed'], 'Cancelled' => $interviews['cancelled'], 'Physical' => $interviews['physical'], 'Online' => $interviews['online']]],
            ] as [$title, $type, $data, $breakdown])
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $title }}</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reports.export', ['type' => $type, 'format' => 'excel', 'from_date' => $from, 'to_date' => $to]) }}"
                           class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Excel
                        </a>
                        <a href="{{ route('admin.reports.export', ['type' => $type, 'format' => 'pdf', 'from_date' => $from, 'to_date' => $to]) }}"
                           class="inline-flex items-center gap-1.5 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            PDF
                        </a>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-2 sm:grid-cols-{{ min(count($breakdown), 4) }} gap-4">
                    @foreach ($breakdown as $label => $val)
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $val }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $label }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- By-category breakdown for internships --}}
                @if ($type === 'internships' && $internships['by_category']->isNotEmpty())
                <div class="px-5 pb-5 border-t border-gray-50 dark:border-gray-800 pt-4">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">By Category</p>
                    <div class="space-y-1.5">
                        @foreach ($internships['by_category']->take(6) as $cat)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-600 dark:text-gray-400 w-32 truncate">{{ $cat->name }}</span>
                            <div class="flex-1 bg-gray-100 dark:bg-gray-800 rounded-full h-1.5">
                                @php $pct = $internships['total'] > 0 ? ($cat->internships_count / $internships['total']) * 100 : 0; @endphp
                                <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ round($pct) }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 w-6 text-right">{{ $cat->internships_count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
