<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('company.internships.show', $internship) }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ $internship->title }}
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 shrink-0">Applicants</span>
        </div>
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

            {{-- Stats row ──────────────────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $cards = [
                        ['label' => 'Total Applicants',    'value' => $stats['total'],               'color' => 'blue'],
                        ['label' => 'Under Review',         'value' => $stats['under_review'],        'color' => 'indigo'],
                        ['label' => 'Shortlisted',          'value' => $stats['shortlisted'],         'color' => 'purple'],
                        ['label' => 'Interview Scheduled',  'value' => $stats['interview_scheduled'], 'color' => 'amber'],
                    ];
                @endphp
                @foreach ($cards as $card)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">{{ $card['label'] }}</p>
                        <p class="text-3xl font-bold text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400">{{ $card['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Filter tabs ────────────────────────────────────────────────────── --}}
            @php
                $tabs = [
                    ''                    => 'All',
                    'submitted'           => 'Submitted',
                    'under_review'        => 'Under Review',
                    'shortlisted'         => 'Shortlisted',
                    'interview_scheduled' => 'Interview Scheduled',
                    'accepted'            => 'Accepted',
                    'rejected'            => 'Rejected',
                ];
            @endphp
            <div class="border-b border-gray-200 dark:border-gray-800">
                <nav class="flex flex-wrap gap-x-6 gap-y-1 -mb-px">
                    @foreach ($tabs as $value => $label)
                        @php $active = request('status', '') === $value; @endphp
                        <a href="{{ route('company.applicants.index', array_merge(['internship' => $internship->id], $value ? ['status' => $value] : [])) }}"
                           class="py-3 text-sm font-medium border-b-2 transition-colors
                                  {{ $active
                                      ? 'border-blue-600 text-blue-600 dark:text-blue-400'
                                      : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Applicants table ───────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

                @if ($applications->isEmpty())
                    <div class="py-20 text-center">
                        <div class="w-14 h-14 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            {{ request('status') ? 'No applicants with this status.' : 'No applicants yet for this internship.' }}
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                <tr>
                                    <th class="px-5 py-3 text-left">Student</th>
                                    <th class="px-5 py-3 text-left">University</th>
                                    <th class="px-5 py-3 text-left">Applied</th>
                                    <th class="px-5 py-3 text-left">Status</th>
                                    <th class="px-5 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @foreach ($applications as $app)
                                @php $student = $app->student; @endphp
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                    {{-- Student --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0 text-xs font-semibold text-white">
                                                {{ strtoupper(substr($student->full_name ?? $student->user->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white leading-tight truncate max-w-[180px]">
                                                    {{ $student->full_name ?? $student->user->name }}
                                                </p>
                                                <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ $student->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- University + program --}}
                                    <td class="px-5 py-3.5">
                                        <p class="text-gray-700 dark:text-gray-300 text-xs truncate max-w-[160px]">{{ $student->university ?? '—' }}</p>
                                        <p class="text-gray-400 text-xs truncate max-w-[160px]">{{ $student->program ?? '' }}</p>
                                    </td>
                                    {{-- Applied --}}
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                        {{ $app->created_at->diffForHumans() }}
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-5 py-3.5">
                                        <x-status-badge :status="$app->status"/>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-5 py-3.5">
                                        <a href="{{ route('company.applicants.show', [$internship, $app]) }}"
                                           class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($applications->hasPages())
                        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
                            {{ $applications->links() }}
                        </div>
                    @endif
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
