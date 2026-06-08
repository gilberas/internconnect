<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('company.internships.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                My Internships
            </a>
            <span class="text-gray-300 dark:text-gray-600 shrink-0">/</span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">{{ $internship->title }}</span>
            <x-status-badge :status="$internship->status" class="shrink-0"/>
        </div>
    </x-slot>

    @php $daysLeft = (int) now()->startOfDay()->diffInDays($internship->deadline, false); @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Info chips ──────────────────────────────────────────────────────── --}}
            <div class="flex flex-wrap gap-3 mb-6">
                <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $internship->typeLabel() }}
                </span>
                <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    {{ $internship->location }}
                </span>
                <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $internship->duration }}
                </span>
                <span class="inline-flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $internship->positions }} {{ Str::plural('position', $internship->positions) }}
                </span>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- LEFT (2/3) ─────────────────────────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-5">

                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Description</h3>
                        <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $internship->description }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Requirements</h3>
                        <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $internship->requirements }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Responsibilities</h3>
                        <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $internship->responsibilities }}</div>
                    </div>

                    @if (!empty($internship->skills_required))
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Skills Required</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($internship->skills_required as $skill)
                                <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- RIGHT (1/3, sticky) ─────────────────────────────────────────── --}}
                <div class="space-y-4 lg:sticky lg:top-6 lg:self-start">

                    {{-- Status card --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Status</p>
                        <x-status-badge :status="$internship->status" class="mb-3"/>

                        @if ($internship->status === 'rejected')
                            <div class="mt-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-3">
                                <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-1">Rejection Reason</p>
                                <p class="text-xs text-red-600 dark:text-red-400">{{ $internship->rejection_reason }}</p>
                            </div>
                        @elseif ($internship->status === 'pending')
                            <div class="mt-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-3">
                                <p class="text-xs text-amber-700 dark:text-amber-300">Awaiting admin review. This may take up to 24 hours.</p>
                            </div>
                        @elseif ($internship->status === 'approved')
                            <div class="mt-2 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl p-3">
                                <p class="text-xs text-emerald-700 dark:text-emerald-300">Live — accepting applications from students.</p>
                            </div>
                        @elseif ($internship->status === 'closed')
                            <div class="mt-2 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400">This internship is closed and no longer accepting applications.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Stats card --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Applications</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ $internship->applications->count() }}
                        </p>
                        <a href="{{ route('company.applicants.index', $internship) }}"
                           class="text-sm text-blue-600 dark:text-blue-400 font-medium hover:underline">
                            View Applicants →
                        </a>
                    </div>

                    {{-- Deadline card --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Deadline</p>
                            @if ($daysLeft <= 0)
                                <span class="text-xs font-semibold text-gray-500 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-full">Expired</span>
                            @elseif ($daysLeft <= 7)
                                <span class="text-xs font-semibold text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded-full">{{ $daysLeft }} days left</span>
                            @else
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">{{ $daysLeft }} days left</span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $internship->deadline->format('d F Y') }}
                        </p>
                    </div>

                    {{-- Actions card --}}
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-5 space-y-2.5">
                        @if ($internship->isEditable())
                            <a href="{{ route('company.internships.edit', $internship) }}"
                               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Internship
                            </a>
                        @endif

                        @if ($internship->status === 'approved')
                            <form method="POST" action="{{ route('company.internships.close', $internship) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-full py-2.5 rounded-xl border border-amber-300 dark:border-amber-700 text-sm font-medium text-amber-700 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors"
                                        onclick="return confirm('Close this internship? Students will no longer be able to apply.')">
                                    Close Internship
                                </button>
                            </form>
                        @endif

                        @if (in_array($internship->status, ['pending', 'rejected']))
                            <form method="POST" action="{{ route('company.internships.destroy', $internship) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full py-2.5 rounded-xl border border-red-300 dark:border-red-700 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                        onclick="return confirm('Delete this internship? This cannot be undone.')">
                                    Delete Internship
                                </button>
                            </form>
                        @endif
                    </div>

                </div>{{-- /right --}}
            </div>{{-- /grid --}}

        </div>
    </div>
</x-app-layout>
